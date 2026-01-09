<?php

namespace App\Models;

use CodeIgniter\Model;

class VillageModel extends Model
{
   protected $table      = 'villages';
    protected $primaryKey = 'id';
    protected $allowedFields = ['village_code', 'district_id', 'name'];
    protected $useTimestamps = true;

    public function getVillagesByDistrict($districtId)
    {
        return $this->where('district_id', $districtId)->orderBy('name', 'ASC')->findAll();
    }
}
