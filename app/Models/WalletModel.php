<?php

namespace App\Models;

use CodeIgniter\Model;

class WalletModel extends Model
{
    protected $table = 'wallets';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'balance'];
    protected $useTimestamps = true;
    
    /**
     * Get or create wallet for user
     */
    public function getOrCreateWallet($userId)
    {
        $wallet = $this->where('user_id', $userId)->first();
        
        if (!$wallet) {
            $walletId = $this->insert([
                'user_id' => $userId,
                'balance' => 0
            ]);
            
            $wallet = $this->find($walletId);
        }
        
        return $wallet;
    }
    
    /**
     * Add balance (credit)
     */
    public function addBalance($userId, $amount, $description, $transactionId = null, $referenceType = 'sale')
    {
        $db = \Config\Database::connect();
        $db->transStart();
        
        try {
            $wallet = $this->getOrCreateWallet($userId);
            $balanceBefore = $wallet['balance'];
            $balanceAfter = $balanceBefore + $amount;
            
            // Update wallet balance
            $this->update($wallet['id'], ['balance' => $balanceAfter]);
            
            // Record transaction
            $walletTrxModel = new WalletTransactionModel();
            $walletTrxModel->insert([
                'wallet_id' => $wallet['id'],
                'transaction_id' => $transactionId,
                'type' => 'credit',
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => $description,
                'reference_type' => $referenceType,
            ]);
            
            $db->transComplete();
            
            if ($db->transStatus() === false) {
                throw new \Exception('Failed to add balance');
            }
            
            return true;
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Add Balance Error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Deduct balance (debit)
     */
    public function deductBalance($userId, $amount, $description, $transactionId = null, $referenceType = 'withdrawal')
    {
        $db = \Config\Database::connect();
        $db->transStart();
        
        try {
            $wallet = $this->getOrCreateWallet($userId);
            $balanceBefore = $wallet['balance'];
            
            if ($balanceBefore < $amount) {
                throw new \Exception('Insufficient balance');
            }
            
            $balanceAfter = $balanceBefore - $amount;
            
            // Update wallet balance
            $this->update($wallet['id'], ['balance' => $balanceAfter]);
            
            // Record transaction
            $walletTrxModel = new WalletTransactionModel();
            $walletTrxModel->insert([
                'wallet_id' => $wallet['id'],
                'transaction_id' => $transactionId,
                'type' => 'debit',
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => $description,
                'reference_type' => $referenceType,
            ]);
            
            $db->transComplete();
            
            if ($db->transStatus() === false) {
                throw new \Exception('Failed to deduct balance');
            }
            
            return true;
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Deduct Balance Error: ' . $e->getMessage());
            return false;
        }
    }
}