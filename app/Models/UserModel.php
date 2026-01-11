<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username', 'email', 'hp','img_profile', 'password', 'role', 'created_at', 'updated_at'
    ];

    public function getUserWithWallet($userId)
    {
        $user = $this->find($userId);
        if ($user) {
            $walletModel = new \App\Models\WalletModel();
            $wallet = $walletModel->getOrCreateWallet($userId);
            $user['wallet'] = $wallet;
        }
        return $user;
    }
}