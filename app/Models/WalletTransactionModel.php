<?php

namespace App\Models;

use CodeIgniter\Model;

class WalletTransactionModel extends Model
{
    protected $table = 'wallet_transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'wallet_id', 'transaction_id', 'type', 'amount',
        'balance_before', 'balance_after', 'description', 'reference_type'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = null;
    
    /**
     * Get wallet history for user
     */
    public function getUserHistory($userId, $limit = 50)
    {
        return $this->select('wallet_transactions.*')
            ->join('wallets', 'wallets.id = wallet_transactions.wallet_id')
            ->where('wallets.user_id', $userId)
            ->orderBy('wallet_transactions.created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}