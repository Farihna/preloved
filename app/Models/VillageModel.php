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

    public function getPostalCodeByVillageId($villageId)
    {
        return $this->db->table('village_postal_codes')
            ->select('postal_codes.code')
            ->join('postal_codes', 'postal_codes.id = village_postal_codes.postal_code_id')
            ->join('villages', 'villages.village_code = village_postal_codes.village_code')
            ->where('villages.id', $villageId)
            ->get()
            ->getRow();
    }
}
