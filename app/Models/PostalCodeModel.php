<?php

namespace App\Models;

use CodeIgniter\Model;

class PostalCodeModel extends Model
{
    protected $table      = 'postal_codes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['code'];
    protected $useTimestamps = true;

    public function getVillages($postalCodeId)
    {
        return $this->db->table('villages')
            ->select('villages.*')
            ->join('village_postal_codes', 'village_postal_codes.village_code = villages.village_code')
            ->where('village_postal_codes.postal_code_id', $postalCodeId)
            ->get()
            ->getResultArray();
    }

    public function getDistricts($postalCodeId)
    {
        return $this->db->table('districts')
            ->select('districts.*')
            ->join('district_postal_codes', 'district_postal_codes.district_code = districts.district_code')
            ->where('district_postal_codes.postal_code_id', $postalCodeId)
            ->get()
            ->getResultArray();
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
