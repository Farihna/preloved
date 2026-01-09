<?php

namespace App\Models;

use CodeIgniter\Model;

class AddressModel extends Model
{
    protected $table      = 'addresses';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'user_id', 'type', 'is_default', 'label', 'recipient_name',
        'phone_number', 'address_line', 'province_id', 'city_id',
        'district_id', 'village_id', 'zip_code', 
        'province', 'city', 'district', 'village'
    ];

    /**
     * Mengambil alamat default milik user
     */
    public function getDefaultAddress($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('is_default', 1)
                    ->first();
    }

    public function getFullAddress($addressId)
    {
        return $this->select('addresses.*, provinces.name as province_name, cities.name as city_name, districts.name as district_name, villages.name as village_name')
            ->join('provinces', 'provinces.id = addresses.province_id')
            ->join('cities', 'cities.id = addresses.city_id')
            ->join('districts', 'districts.id = addresses.district_id')
            ->join('villages', 'villages.id = addresses.village_id')
            ->where('addresses.id', $addressId)
            ->findAll();
    }
}

