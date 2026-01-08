<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'transaction_code', 'product_id', 'buyer_id', 'seller_id', 'negotiation_id',
        'product_price', 'shipping_cost', 'total_amount',
        'shipping_name', 'shipping_phone', 'shipping_address', 
        'shipping_city_id', 'shipping_city_name', 'shipping_province', 'shipping_postal_code',
        'courier_code', 'courier_service', 'courier_name', 'estimated_delivery', 'tracking_number',
        'payment_proof', 'payment_date', 'status', 'notes',
        'completed_at', 'cancelled_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'product_id' => 'required|integer',
        'buyer_id' => 'required|integer',
        'seller_id' => 'required|integer',
        'product_price' => 'required|decimal',
        'shipping_cost' => 'required|decimal',
        'total_amount' => 'required|decimal',
        'shipping_name' => 'required|string',
        'shipping_phone' => 'required|string',
        'shipping_address' => 'required|string',
    ];
    
    protected $beforeInsert = ['generateTransactionCode'];
    
    // Auto-generate transaction code
    protected function generateTransactionCode(array $data)
    {
        if (!isset($data['data']['transaction_code'])) {
            $data['data']['transaction_code'] = 'TRX-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));
        }
        return $data;
    }
    
    // Get transaksi dengan detail lengkap
    public function getTransactionWithDetails($id)
    {
        return $this->select('transactions.*, 
                              product.nama as product_name, 
                              product.foto as product_photo,
                              product.deskripsi as product_desc,
                              buyer.username as buyer_name,
                              buyer.email as buyer_email,
                              seller.username as seller_name,
                              seller.email as seller_email,
                              seller.hp as seller_phone')
                    ->join('product', 'product.id = transactions.product_id')
                    ->join('user as buyer', 'buyer.id = transactions.buyer_id')
                    ->join('user as seller', 'seller.id = transactions.seller_id')
                    ->where('transactions.id', $id)
                    ->first();
    }
    
    // Get transaksi pembeli
    public function getBuyerTransactions($buyerId, $status = null)
    {
        $builder = $this->select('transactions.*, 
                                  product.nama as product_name, 
                                  product.foto as product_photo,
                                  seller.username as seller_name')
                        ->join('product', 'product.id = transactions.product_id')
                        ->join('user as seller', 'seller.id = transactions.seller_id')
                        ->where('transactions.buyer_id', $buyerId);
        
        if ($status) {
            $builder->where('transactions.status', $status);
        }
        
        return $builder->orderBy('transactions.created_at', 'DESC')->findAll();
    }
    
    // Get transaksi penjual
    public function getSellerTransactions($sellerId, $status = null)
    {
        $builder = $this->select('transactions.*, 
                                  product.nama as product_name, 
                                  product.foto as product_photo,
                                  buyer.username as buyer_name,
                                  buyer.hp as buyer_phone')
                        ->join('product', 'product.id = transactions.product_id')
                        ->join('user as buyer', 'buyer.id = transactions.buyer_id')
                        ->where('transactions.seller_id', $sellerId);
        
        if ($status) {
            $builder->where('transactions.status', $status);
        }
        
        return $builder->orderBy('transactions.created_at', 'DESC')->findAll();
    }
    
    // Update status transaksi
    public function updateStatus($id, $status, $notes = null)
    {
        $data = ['status' => $status];
        
        if ($notes) {
            $data['notes'] = $notes;
        }
        
        if ($status === 'completed') {
            $data['completed_at'] = date('Y-m-d H:i:s');
        } elseif ($status === 'cancelled') {
            $data['cancelled_at'] = date('Y-m-d H:i:s');
        }
        
        return $this->update($id, $data);
    }
    
    // Upload payment proof
    public function uploadPaymentProof($id, $filename)
    {
        return $this->update($id, [
            'payment_proof' => $filename,
            'payment_date' => date('Y-m-d H:i:s'),
            'status' => 'paid'
        ]);
    }
    
    // Input resi pengiriman
    public function inputTrackingNumber($id, $trackingNumber)
    {
        return $this->update($id, [
            'tracking_number' => $trackingNumber,
            'status' => 'shipped'
        ]);
    }}
