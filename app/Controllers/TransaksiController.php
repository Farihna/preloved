<?php

namespace App\Controllers;
use App\Controllers\BaseController;
// use CodeIgniter\HTTP\ResponseInterface;    
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

use App\Models\ProductModel;
use App\Models\NegotiationModel; 
use App\Models\AddressModel;
use CodeIgniter\Controller;

class TransaksiController extends BaseController
{
    protected $transactionModel;
    protected $productModel;
    protected $negotiationModel;
    protected $addressModel;
    
    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $this->productModel = new ProductModel();
        $this->negotiationModel = new NegotiationModel();
        $this->addressModel = new AddressModel();
        helper(['form', 'url', 'number']);
    }
    
    // ============================================
    // CHECKOUT PROCESS
    // ============================================
    
    /**
     * Checkout page
     * GET /transaction/checkout/{product_id}?nego_id=xxx (optional)
     */
    public function checkout($productId)
    {
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('failed', 'Please login first');
            return redirect()->to('/login');
        }
        
        $buyerId = session()->get('user_id');
        $negoId = $this->request->getGet('nego_id');
        
        // Get product
        $product = $this->productModel->find($productId);
        if (!$product) {
            session()->setFlashdata('failed', 'Product not found');
            return redirect()->to('/');
        }
        
        // Check if product is available
        if ($product['status'] == 0) {
            session()->setFlashdata('failed', 'Product is already sold');
            return redirect()->to('/');
        }
        
        // Check if buying own product
        if ($product['id_user'] == $buyerId) {
            session()->setFlashdata('failed', 'You cannot buy your own product');
            return redirect()->to('/');
        }
        
        // Determine final price
        $finalPrice = $product['harga'];
        $negotiation = null;
        
        if ($negoId) {
            $negotiation = $this->negotiationModel->find($negoId);
            
            if (!$negotiation || $negotiation['buyer_id'] != $buyerId) {
                session()->setFlashdata('failed', 'Invalid negotiation');
                return redirect()->to('/');
            }
            
            if (!in_array($negotiation['status'], ['accepted', 'countered'])) {
                session()->setFlashdata('failed', 'Negotiation is not approved');
                return redirect()->to('/');
            }
            
            if ($negotiation['expires_at'] && strtotime($negotiation['expires_at']) < time()) {
                session()->setFlashdata('failed', 'Negotiation has expired');
                return redirect()->to('/');
            }
            
            if ($negotiation['status'] == 'accepted') {
                $finalPrice = $negotiation['offer_price'];
            } else {
                $finalPrice = $negotiation['counter_price'];
            }
        }
        
        // Get user addresses with full details
        $addresses = $this->addressModel->getFullAddress($buyerId);
        
        $data = [
            'product' => $product,
            'negotiation' => $negotiation,
            'finalPrice' => $finalPrice,
            'addresses' => $addresses
        ];
        
        return view('v_checkout', $data);
    }
    
    /**
     * Process checkout
     * POST /transaction/process
     */
    public function process()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login first'
            ]);
        }
        
        $buyerId = session()->get('user_id');
        
        // Get form data
        $productId = $this->request->getPost('product_id');
        $negoId = $this->request->getPost('negotiation_id');
        $addressId = $this->request->getPost('address_id');
        $courierCode = $this->request->getPost('courier_code');
        $courierService = $this->request->getPost('courier_service');
        $courierName = $this->request->getPost('courier_name');
        $shippingCost = $this->request->getPost('shipping_cost');
        $estimatedDelivery = $this->request->getPost('estimated_delivery');
        $productPrice = $this->request->getPost('product_price');
        $totalAmount = $this->request->getPost('total_amount');
        
        // Validation
        if (!$productId || !$addressId || !$courierCode || !$productPrice) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'All fields are required'
            ]);
        }
        
        // Get product & address
        $product = $this->productModel->find($productId);
        $address = $this->addressModel->find($addressId);
        
        if (!$product || !$address) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product or address not found'
            ]);
        }
        
        // Check product availability
        if ($product['status'] == 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product is no longer available'
            ]);
        }
        
        // Prepare transaction data
        $transactionData = [
            'product_id' => $productId,
            'buyer_id' => $buyerId,
            'seller_id' => $product['id_user'],
            'negotiation_id' => $negoId ?: null,
            'product_price' => $productPrice,
            'shipping_cost' => $shippingCost,
            'total_amount' => $totalAmount,
            'shipping_name' => $address['recipient_name'],
            'shipping_phone' => $address['phone'],
            'shipping_address' => $address['address'],
            'shipping_city_id' => $address['city_id'],
            'shipping_city_name' => $address['city_name'],
            'shipping_province' => $address['province'],
            'shipping_postal_code' => $address['postal_code'],
            'courier_code' => $courierCode,
            'courier_service' => $courierService,
            'courier_name' => $courierName,
            'estimated_delivery' => $estimatedDelivery,
            'status' => 'pending'
        ];
        
        // Insert transaction
        $transactionId = $this->transactionModel->insert($transactionData);
        
        if ($transactionId) {
            // Update product status to pending (reserved)
            $this->productModel->update($productId, ['status' => 0]);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Order created successfully!',
                'transaction_id' => $transactionId,
                'redirect' => base_url('transaction/detail/' . $transactionId)
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to create order'
            ]);
        }
    }
    
    // ============================================
    // BUYER - MY ORDERS
    // ============================================
    
    /**
     * My orders page (buyer)
     * GET /transaction/my-orders
     */
    public function myOrders()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        
        $buyerId = session()->get('user_id');
        $status = $this->request->getGet('status');
        
        $data = [
            'transactions' => $this->transactionModel->getBuyerTransactions($buyerId, $status),
            'activeTab' => $status ?? 'all'
        ];
        
        return view('v_my_orders', $data);
    }
    
    /**
     * Transaction detail
     * GET /transaction/detail/{id}
     */
    public function detail($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        
        $userId = session()->get('user_id');
        $transaction = $this->transactionModel->getTransactionWithDetails($id);
        
        if (!$transaction) {
            session()->setFlashdata('failed', 'Transaction not found');
            return redirect()->to('/');
        }
        
        // Check authorization (buyer or seller)
        if ($transaction['buyer_id'] != $userId && $transaction['seller_id'] != $userId) {
            session()->setFlashdata('failed', 'Unauthorized access');
            return redirect()->to('/');
        }
        
        $data = [
            'transaction' => $transaction,
            'isBuyer' => ($transaction['buyer_id'] == $userId)
        ];
        
        return view('v_transaction_detail', $data);
    }
    
    /**
     * Upload payment proof
     * POST /transaction/payment-proof
     */
    public function uploadPaymentProof()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login first'
            ]);
        }
        
        $transactionId = $this->request->getPost('transaction_id');
        $file = $this->request->getFile('payment_proof');
        
        // Validation
        if (!$file || !$file->isValid()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid file upload'
            ]);
        }
        
        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Only JPG, JPEG, PNG files are allowed'
            ]);
        }
        
        // Validate file size (max 2MB)
        if ($file->getSize() > 2048000) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'File size must not exceed 2MB'
            ]);
        }
        
        // Get transaction
        $transaction = $this->transactionModel->find($transactionId);
        if (!$transaction || $transaction['buyer_id'] != session()->get('user_id')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Transaction not found'
            ]);
        }
        
        // Check status
        if ($transaction['status'] != 'pending') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Payment proof already uploaded'
            ]);
        }
        
        // Move file
        $newName = 'payment_' . $transactionId . '_' . time() . '.' . $file->getExtension();
        $file->move(ROOTPATH . 'public/img/payments', $newName);
        
        // Update transaction
        if ($this->transactionModel->uploadPaymentProof($transactionId, $newName)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Payment proof uploaded successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to upload payment proof'
            ]);
        }
    }
    
    /**
     * Cancel transaction (buyer)
     * POST /transaction/cancel/{id}
     */
    public function cancel($id)
    {
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('failed', 'Please login first');
            return redirect()->to('/login');
        }
        
        $userId = session()->get('user_id');
        $transaction = $this->transactionModel->find($id);
        
        if (!$transaction || $transaction['buyer_id'] != $userId) {
            session()->setFlashdata('failed', 'Transaction not found');
            return redirect()->back();
        }
        
        // Can only cancel if pending or paid
        if (!in_array($transaction['status'], ['pending', 'paid'])) {
            session()->setFlashdata('failed', 'Cannot cancel this transaction');
            return redirect()->back();
        }
        
        // Cancel transaction
        if ($this->transactionModel->updateStatus($id, 'cancelled', 'Cancelled by buyer')) {
            // Return product status to available
            $this->productModel->update($transaction['product_id'], ['status' => 1]);
            
            session()->setFlashdata('success', 'Transaction cancelled successfully');
        } else {
            session()->setFlashdata('failed', 'Failed to cancel transaction');
        }
        
        return redirect()->back();
    }
    
    // ============================================
    // SELLER - MY SALES
    // ============================================
    
    /**
     * My sales page (seller)
     * GET /transaction/my-sales
     */
    public function mySales()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        
        $sellerId = session()->get('user_id');
        $status = $this->request->getGet('status');
        
        $data = [
            'transactions' => $this->transactionModel->getSellerTransactions($sellerId, $status),
            'activeTab' => $status ?? 'all',
            'newOrdersCount' => $this->transactionModel->where('seller_id', $sellerId)
                                                       ->where('status', 'paid')
                                                       ->countAllResults()
        ];
        
        return view('v_my_sales', $data);
    }
    
    /**
     * Confirm payment (seller)
     * POST /transaction/confirm-payment/{id}
     */
    public function confirmPayment($id)
    {
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('failed', 'Please login first');
            return redirect()->to('/login');
        }
        
        $sellerId = session()->get('user_id');
        $transaction = $this->transactionModel->find($id);
        
        if (!$transaction || $transaction['seller_id'] != $sellerId) {
            session()->setFlashdata('failed', 'Transaction not found');
            return redirect()->back();
        }
        
        // Check status
        if ($transaction['status'] != 'paid') {
            session()->setFlashdata('failed', 'Cannot confirm this transaction');
            return redirect()->back();
        }
        
        // Confirm payment
        if ($this->transactionModel->updateStatus($id, 'processed', 'Payment confirmed by seller')) {
            session()->setFlashdata('success', 'Payment confirmed! Please process the order.');
        } else {
            session()->setFlashdata('failed', 'Failed to confirm payment');
        }
        
        return redirect()->back();
    }
    
    /**
     * Input tracking number (seller)
     * POST /transaction/input-resi
     */
    public function inputResi()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login first'
            ]);
        }
        
        $sellerId = session()->get('user_id');
        $transactionId = $this->request->getPost('transaction_id');
        $trackingNumber = $this->request->getPost('tracking_number');
        
        // Validation
        if (!$trackingNumber) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tracking number is required'
            ]);
        }
        
        // Get transaction
        $transaction = $this->transactionModel->find($transactionId);
        if (!$transaction || $transaction['seller_id'] != $sellerId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Transaction not found'
            ]);
        }
        
        // Check status
        if ($transaction['status'] != 'processed') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Cannot input tracking number for this transaction'
            ]);
        }
        
        // Input resi
        if ($this->transactionModel->inputTrackingNumber($transactionId, $trackingNumber)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Tracking number added successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to add tracking number'
            ]);
        }
    }
    
    /**
     * Complete transaction (auto or manual)
     * POST /transaction/complete/{id}
     */
    public function complete($id)
    {
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('failed', 'Please login first');
            return redirect()->to('/login');
        }
        
        $userId = session()->get('user_id');
        $transaction = $this->transactionModel->find($id);
        
        if (!$transaction) {
            session()->setFlashdata('failed', 'Transaction not found');
            return redirect()->back();
        }
        
        // Only buyer or seller can complete
        if ($transaction['buyer_id'] != $userId && $transaction['seller_id'] != $userId) {
            session()->setFlashdata('failed', 'Unauthorized');
            return redirect()->back();
        }
        
        // Check status
        if ($transaction['status'] != 'shipped') {
            session()->setFlashdata('failed', 'Cannot complete this transaction');
            return redirect()->back();
        }
        
        // Complete transaction
        if ($this->transactionModel->updateStatus($id, 'completed', 'Transaction completed')) {
            session()->setFlashdata('success', 'Transaction completed successfully!');
        } else {
            session()->setFlashdata('failed', 'Failed to complete transaction');
        }
        
        return redirect()->back();
    }
}
