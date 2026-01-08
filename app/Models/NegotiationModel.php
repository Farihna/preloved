<?php

namespace App\Models;

use CodeIgniter\Model;

class NegotiationModel extends Model
{
    protected $table            = 'negotiations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'product_id', 'buyer_id', 'seller_id', 'original_price', 
        'offer_price', 'counter_price', 'buyer_message', 'seller_message',
        'status', 'nego_count', 'expires_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'product_id' => 'required|integer',
        'buyer_id' => 'required|integer',
        'seller_id' => 'required|integer',
        'original_price' => 'required|decimal',
        'offer_price' => 'required|decimal',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

        public function getNegoWithDetails($id)
    {
        return $this->select('negotiations.*, 
                              product.nama as product_name, 
                              product.foto as product_photo,
                              product.harga as product_price,
                              buyer.username as buyer_name,
                              buyer.email as buyer_email,
                              buyer.hp as buyer_phone,
                              seller.username as seller_name,
                              seller.email as seller_email')
                    ->join('product', 'product.id = negotiations.product_id')
                    ->join('user as buyer', 'buyer.id = negotiations.buyer_id')
                    ->join('user as seller', 'seller.id = negotiations.seller_id')
                    ->where('negotiations.id', $id)
                    ->first();
    }
    
    // Get semua nego untuk buyer
    public function getBuyerNegotiations($buyerId, $status = null)
    {
        $builder = $this->select('negotiations.*, 
                                  product.nama as product_name, 
                                  product.foto as product_photo,
                                  seller.username as seller_name')
                        ->join('product', 'product.id = negotiations.product_id')
                        ->join('user as seller', 'seller.id = negotiations.seller_id')
                        ->where('negotiations.buyer_id', $buyerId);
        
        if ($status) {
            $builder->where('negotiations.status', $status);
        }
        
        return $builder->orderBy('negotiations.created_at', 'DESC')->findAll();
    }
    
    // Get semua nego request untuk seller
    public function getSellerNegotiations($sellerId, $status = null)
    {
        $builder = $this->select('negotiations.*, 
                                  product.nama as product_name, 
                                  product.foto as product_photo,
                                  buyer.username as buyer_name,
                                  buyer.hp as buyer_phone')
                        ->join('product', 'product.id = negotiations.product_id')
                        ->join('user as buyer', 'buyer.id = negotiations.buyer_id')
                        ->where('negotiations.seller_id', $sellerId);
        
        if ($status) {
            $builder->where('negotiations.status', $status);
        }
        
        return $builder->orderBy('negotiations.created_at', 'DESC')->findAll();
    }
    
    // Check apakah buyer sudah pernah nego produk ini
    public function hasActiveNegotiation($productId, $buyerId)
    {
        return $this->where('product_id', $productId)
                    ->where('buyer_id', $buyerId)
                    ->whereIn('status', ['pending', 'countered'])
                    ->where('(expires_at IS NULL OR expires_at > NOW())', null, false)
                    ->first();
    }
    
    // Update status nego
    public function acceptNegotiation($id, $sellerMessage = null)
    {
        return $this->update($id, [
            'status' => 'accepted',
            'seller_message' => $sellerMessage,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+24 hours'))
        ]);
    }
    
    public function counterNegotiation($id, $counterPrice, $sellerMessage = null)
    {
        return $this->update($id, [
            'status' => 'countered',
            'counter_price' => $counterPrice,
            'seller_message' => $sellerMessage,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+24 hours'))
        ]);
    }
    
    public function rejectNegotiation($id, $sellerMessage = null)
    {
        return $this->update($id, [
            'status' => 'rejected',
            'seller_message' => $sellerMessage
        ]);
    }
}
