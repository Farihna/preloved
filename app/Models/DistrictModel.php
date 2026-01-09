<?php

namespace App\Models;

use CodeIgniter\Model;

class DistrictModel extends Model
{
    protected $table      = 'districts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['district_code', 'city_id', 'name'];
    protected $useTimestamps = true;

    public function getDistrictsByCitiy($cityId)
    {
        return $this->where('city_id', $cityId)->orderBy('name', 'ASC')->findAll();
    }
}
