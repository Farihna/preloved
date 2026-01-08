<?php

namespace App\Controllers;

use App\Models\NegotiationModel;
use App\Models\ProductModel;
use CodeIgniter\Controller;

class NegotiationController extends BaseController
{
    protected $negotiationModel;
    protected $productModel;
    
    public function __construct()
    {
        $this->negotiationModel = new NegotiationModel();
        $this->productModel = new ProductModel();
        helper(['form', 'url']);
    }
    
    // ============================================
    // BUYER ACTIONS
    // ============================================
    
    /**
     * Create new negotiation (AJAX)
     * POST /negotiation/create
     */
    public function create()
    {
        // Check login
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login first'
            ]);
        }
        
        $buyerId = session()->get('user_id');
        $productId = $this->request->getPost('product_id');
        $offerPrice = $this->request->getPost('offer_price');
        $message = $this->request->getPost('message');
        
        // Validasi input
        if (!$productId || !$offerPrice) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product ID and offer price are required'
            ]);
        }
        
        // Get product detail
        $product = $this->productModel->find($productId);
        if (!$product) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product not found'
            ]);
        }
        
        // Check if product is negotiable
        if (!$product['is_negotiable']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'This product price is fixed (not negotiable)'
            ]);
        }
        
        // Tidak bisa nego produk sendiri
        if ($product['id_user'] == $buyerId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You cannot negotiate your own product'
            ]);
        }
        
        // Check if product is available
        if ($product['status'] == 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product is already sold'
            ]);
        }
        
        // Check if already has active negotiation
        $activeNego = $this->negotiationModel->hasActiveNegotiation($productId, $buyerId);
        if ($activeNego) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You already have an active negotiation for this product'
            ]);
        }
        
        // Validasi harga tawaran
        $originalPrice = $product['harga'];
        if ($offerPrice >= $originalPrice) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Offer price must be lower than original price'
            ]);
        }
        
        if ($offerPrice <= 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Offer price must be greater than 0'
            ]);
        }
        
        // Create negotiation
        $data = [
            'product_id' => $productId,
            'buyer_id' => $buyerId,
            'seller_id' => $product['id_user'],
            'original_price' => $originalPrice,
            'offer_price' => $offerPrice,
            'buyer_message' => $message,
            'status' => 'pending',
            'nego_count' => 1,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+24 hours'))
        ];
        
        if ($this->negotiationModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Negotiation sent successfully! Wait for seller response.'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to send negotiation. Please try again.'
            ]);
        }
    }
    
    /**
     * Get my offers (buyer)
     * GET /negotiation/my-offers
     */
    public function myOffers()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $buyerId = session()->get('user_id');
        $status = $this->request->getGet('status');
        
        $data = [
            'negotiations' => $this->negotiationModel->getBuyerNegotiations($buyerId, $status),
            'activeTab' => $status ?? 'all'
        ];
        
        return view('user/v_my_offers', $data);
    }
    
    /**
     * Counter offer from buyer (nego lagi)
     * POST /negotiation/counter-offer
     */
    public function counterOffer()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login first'
            ]);
        }
        
        $buyerId = session()->get('user_id');
        $negoId = $this->request->getPost('nego_id');
        $newOffer = $this->request->getPost('new_offer');
        $message = $this->request->getPost('message');
        
        // Get negotiation
        $nego = $this->negotiationModel->find($negoId);
        if (!$nego || $nego['buyer_id'] != $buyerId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Negotiation not found'
            ]);
        }
        
        // Check status (hanya bisa counter jika status = countered)
        if ($nego['status'] != 'countered') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Cannot counter this negotiation'
            ]);
        }
        
        // Check nego count (max 3x)
        if ($nego['nego_count'] >= 3) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Maximum negotiation attempts reached (3x)'
            ]);
        }
        
        // Validasi harga
        if ($newOffer >= $nego['original_price']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Offer must be lower than original price'
            ]);
        }
        
        // Update negotiation
        $updateData = [
            'offer_price' => $newOffer,
            'buyer_message' => $message,
            'status' => 'pending',
            'nego_count' => $nego['nego_count'] + 1,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+24 hours'))
        ];
        
        if ($this->negotiationModel->update($negoId, $updateData)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Counter offer sent successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to send counter offer'
            ]);
        }
    }
    
    // ============================================
    // SELLER ACTIONS
    // ============================================
    
    /**
     * Get negotiation requests (seller)
     * GET /negotiation/requests
     */
    public function requests()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $sellerId = session()->get('user_id');
        $status = $this->request->getGet('status');
        
        $data = [
            'negotiations' => $this->negotiationModel->getSellerNegotiations($sellerId, $status),
            'activeTab' => $status ?? 'all',
            'pendingCount' => $this->negotiationModel->where('seller_id', $sellerId)
                                                     ->where('status', 'pending')
                                                     ->countAllResults()
        ];
        
        return view('user/v_nego_requests', $data);
    }
    
    /**
     * Accept negotiation (seller)
     * POST /negotiation/accept/{id}
     */
    public function accept($id)
    {
        if (!session()->get('logged_in')) {
            session()->setFlashdata('failed', 'Please login first');
            return redirect()->to('/login');
        }
        
        $sellerId = session()->get('user_id');
        
        // Get negotiation
        $nego = $this->negotiationModel->find($id);
        if (!$nego || $nego['seller_id'] != $sellerId) {
            session()->setFlashdata('failed', 'Negotiation not found');
            return redirect()->back();
        }
        
        // Check status
        if ($nego['status'] != 'pending') {
            session()->setFlashdata('failed', 'This negotiation has already been responded to');
            return redirect()->back();
        }
        
        // Accept negotiation
        $message = $this->request->getPost('message') ?? 'Your offer has been accepted!';
        
        if ($this->negotiationModel->acceptNegotiation($id, $message)) {
            session()->setFlashdata('success', 'Negotiation accepted successfully!');
        } else {
            session()->setFlashdata('failed', 'Failed to accept negotiation');
        }
        
        return redirect()->back();
    }
    
    /**
     * Counter negotiation (seller)
     * POST /negotiation/counter/{id}
     */
    public function counter($id)
    {
        if (!session()->get('logged_in')) {
            session()->setFlashdata('failed', 'Please login first');
            return redirect()->to('/login');
        }
        
        $sellerId = session()->get('user_id');
        $counterPrice = $this->request->getPost('counter_price');
        $message = $this->request->getPost('message');
        
        // Get negotiation
        $nego = $this->negotiationModel->find($id);
        if (!$nego || $nego['seller_id'] != $sellerId) {
            session()->setFlashdata('failed', 'Negotiation not found');
            return redirect()->back();
        }
        
        // Check status
        if ($nego['status'] != 'pending') {
            session()->setFlashdata('failed', 'This negotiation has already been responded to');
            return redirect()->back();
        }
        
        // Validasi counter price
        if (!$counterPrice || $counterPrice <= 0) {
            session()->setFlashdata('failed', 'Counter price must be greater than 0');
            return redirect()->back();
        }
        
        if ($counterPrice <= $nego['offer_price']) {
            session()->setFlashdata('failed', 'Counter price must be higher than buyer offer');
            return redirect()->back();
        }
        
        if ($counterPrice >= $nego['original_price']) {
            session()->setFlashdata('failed', 'Counter price must be lower than original price');
            return redirect()->back();
        }
        
        // Counter negotiation
        if ($this->negotiationModel->counterNegotiation($id, $counterPrice, $message)) {
            session()->setFlashdata('success', 'Counter offer sent successfully!');
        } else {
            session()->setFlashdata('failed', 'Failed to send counter offer');
        }
        
        return redirect()->back();
    }
    
    /**
     * Reject negotiation (seller)
     * POST /negotiation/reject/{id}
     */
    public function reject($id)
    {
        if (!session()->get('logged_in')) {
            session()->setFlashdata('failed', 'Please login first');
            return redirect()->to('/login');
        }
        
        $sellerId = session()->get('user_id');
        $message = $this->request->getPost('message') ?? 'Sorry, your offer has been rejected.';
        
        // Get negotiation
        $nego = $this->negotiationModel->find($id);
        if (!$nego || $nego['seller_id'] != $sellerId) {
            session()->setFlashdata('failed', 'Negotiation not found');
            return redirect()->back();
        }
        
        // Check status
        if ($nego['status'] != 'pending') {
            session()->setFlashdata('failed', 'This negotiation has already been responded to');
            return redirect()->back();
        }
        
        // Reject negotiation
        if ($this->negotiationModel->rejectNegotiation($id, $message)) {
            session()->setFlashdata('success', 'Negotiation rejected');
        } else {
            session()->setFlashdata('failed', 'Failed to reject negotiation');
        }
        
        return redirect()->back();
    }
}