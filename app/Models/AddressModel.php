<?php

namespace App\Models;

use CodeIgniter\Model;

class AddressModel extends Model
{
    protected $table = 'user_addresses';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'label', 'recipient_name', 'phone', 'address',
        'city_id', 'city_name', 'province', 'postal_code', 'is_default'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $beforeInsert = ['setDefaultAddress'];
    protected $beforeUpdate = ['setDefaultAddress'];
    
    // Jika set sebagai default, unset yang lain
    protected function setDefaultAddress(array $data)
    {
        if (isset($data['data']['is_default']) && $data['data']['is_default'] == 1) {
            $userId = $data['data']['user_id'] ?? null;
            if ($userId) {
                $this->where('user_id', $userId)->set(['is_default' => 0])->update();
            }
        }
        return $data;
    }
    
    // Get semua alamat user
    public function getUserAddresses($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('is_default', 'DESC')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
    
    // Get alamat default
    public function getDefaultAddress($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('is_default', 1)
                    ->first();
    }
}

