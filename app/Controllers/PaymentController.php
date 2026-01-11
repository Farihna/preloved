<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\MidtransService;
use App\Models\TransactionModel;
use App\Models\PaymentModel;

class PaymentController extends BaseController
{
    protected $midtransService;
    protected $transactionModel;
    protected $paymentModel;
    
    public function __construct()
    {
        $this->midtransService = new MidtransService();
        $this->transactionModel = new TransactionModel();
        $this->paymentModel = new PaymentModel();
    }
    
    /**
     * Create Snap Token for payment
     * POST /payment/create-snap-token
     */
    public function createSnapToken()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login first'
            ]);
        }
        
        $transactionId = $this->request->getPost('transaction_id');
        
        if (!$transactionId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Transaction ID is required'
            ]);
        }
        
        // Verify transaction belongs to user
        $transaction = $this->transactionModel->find($transactionId);
        
        if (!$transaction || $transaction['buyer_id'] != session()->get('user_id')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Transaction not found'
            ]);
        }
        
        // Check if transaction is pending
        if ($transaction['status'] != 'pending') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'This transaction cannot be paid'
            ]);
        }
        
        // Create Snap Token
        $result = $this->midtransService->createSnapToken($transactionId);
        
        return $this->response->setJSON($result);
    }
    
    /**
     * Midtrans Notification Handler
     * POST /payment/midtrans/notification
     */
    public function midtransNotification()
    {
        // Get raw POST data
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        log_message('info', 'Midtrans Notification Received: ' . $json);
        
        // Process notification
        $result = $this->midtransService->handleNotification($data);
        
        // Return response to Midtrans
        return $this->response->setJSON($result);
    }
    
    /**
     * Payment Finish Page
     * GET /payment/finish?order_id=xxx&status_code=xxx&transaction_status=xxx
     */
    public function finish()
    {
        $orderId = $this->request->getGet('order_id');
        $statusCode = $this->request->getGet('status_code');
        $transactionStatus = $this->request->getGet('transaction_status');
        
        $data = [
            'order_id' => $orderId,
            'status_code' => $statusCode,
            'transaction_status' => $transactionStatus,
        ];
        
        // Get payment info
        if ($orderId) {
            $payment = $this->paymentModel->getByMidtransOrderId($orderId);
            if ($payment) {
                $transaction = $this->transactionModel->find($payment['transaction_id']);
                $data['transaction'] = $transaction;
                $data['payment'] = $payment;
                
                // AUTO-APPROVE PAYMENT UNTUK SANDBOX (DEMO MODE)
                // Ini hanya untuk testing/sandbox, di production pakai notification dari Midtrans
                if ($transaction['status'] == 'pending') {
                    log_message('info', '=== AUTO-APPROVE PAYMENT (SANDBOX MODE) ===');
                    log_message('info', 'Order ID: ' . $orderId);
                    log_message('info', 'Transaction ID: ' . $transaction['id']);
                    
                    // Update transaction status to paid
                    $this->transactionModel->update($transaction['id'], [
                        'status' => 'paid',
                        'payment_date' => date('Y-m-d H:i:s')
                    ]);
                    
                    // Update payment status
                    $this->paymentModel->update($payment['id'], [
                        'payment_status' => 'settlement',
                        'paid_at' => date('Y-m-d H:i:s'),
                        'midtrans_transaction_status' => 'settlement',
                    ]);
                    
                    // Update product status to sold
                    $productModel = new \App\Models\ProductModel();
                    $productModel->update($transaction['product_id'], ['status' => 0]);
                    
                    // ADD BALANCE TO SELLER
                    $walletModel = new \App\Models\WalletModel();
                    $sellerBalance = $walletModel->addBalance(
                        $transaction['seller_id'],
                        $transaction['product_price'], // Hanya harga produk, ongkir bukan untuk penjual
                        'Penjualan Produk - ' . $transaction['transaction_code'],
                        $transaction['id'],
                        'sale'
                    );
                    
                    if ($sellerBalance) {
                        log_message('info', 'Seller balance added: Rp' . number_format($transaction['product_price']));
                    } else {
                        log_message('error', 'Failed to add seller balance');
                    }
                    
                    // Refresh transaction data
                    $transaction = $this->transactionModel->find($payment['transaction_id']);
                    $data['transaction'] = $transaction;
                    
                    log_message('info', 'Payment auto-approved successfully');
                }
            }
        }
        
        return view('v_payment_finish', $data);
    }
    
    /**
     * Payment Unfinish Page (user cancelled/back)
     * GET /payment/unfinish
     */
    public function unfinish()
    {
        $orderId = $this->request->getGet('order_id');
        
        $data = ['order_id' => $orderId];
        
        if ($orderId) {
            $payment = $this->paymentModel->getByMidtransOrderId($orderId);
            if ($payment) {
                $transaction = $this->transactionModel->find($payment['transaction_id']);
                $data['transaction'] = $transaction;
            }
        }
        
        return view('v_payment_unfinish', $data);
    }
    
    /**
     * Payment Error Page
     * GET /payment/error
     */
    public function error()
    {
        $orderId = $this->request->getGet('order_id');
        
        return view('v_payment_error', ['order_id' => $orderId]);
    }
    
    /**
     * Check payment status
     * GET /payment/check-status/{transaction_id}
     */
    public function checkStatus($transactionId)
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login first'
            ]);
        }
        
        $transaction = $this->transactionModel->find($transactionId);
        
        if (!$transaction || $transaction['buyer_id'] != session()->get('user_id')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Transaction not found'
            ]);
        }
        
        $payment = $this->paymentModel->getByTransactionId($transactionId);
        
        return $this->response->setJSON([
            'success' => true,
            'transaction_status' => $transaction['status'],
            'payment_status' => $payment['payment_status'] ?? null,
            'payment_type' => $payment['payment_type'] ?? null,
            'payment_channel' => $payment['payment_channel'] ?? null,
        ]);
    }
}