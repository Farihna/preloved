<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionHistoryModel extends Model
{
    protected $table = 'transaction_history';
    protected $primaryKey = 'id';
    protected $allowedFields = ['transaction_id', 'status', 'notes', 'created_by'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = null;
    
    // Get history transaksi
    public function getHistory($transactionId)
    {
        return $this->where('transaction_id', $transactionId)
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }
}