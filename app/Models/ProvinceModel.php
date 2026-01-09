<?php

namespace App\Models;

use CodeIgniter\Model;

class ProvinceModel extends Model
{
    protected $table      = 'provinces';
    protected $primaryKey = 'id';
    protected $allowedFields = ['province_code', 'name'];
    protected $useTimestamps = true;
}
