<?php

namespace App\Models;

use CodeIgniter\Model;

class CityModel extends Model
{
    protected $table      = 'cities';
    protected $primaryKey = 'id';
    protected $allowedFields = ['city_code', 'province_id', 'name', 'type'];
    protected $useTimestamps = true;

    public function getCitiesByProvince($provinceId)
    {
        return $this->select('id, name, type, province_id')
                    ->where('province_id', $provinceId)
                    ->orderBy('type', 'ASC')
                    ->orderBy('name', 'ASC')
                    ->findAll();
    }
}
