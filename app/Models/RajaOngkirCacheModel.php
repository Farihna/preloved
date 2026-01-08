<?php

namespace App\Models;

use CodeIgniter\Model;


class RajaOngkirCacheModel extends Model
{
    protected $table = 'rajaongkir_cache';
    protected $primaryKey = 'id';
    protected $allowedFields = ['cache_key', 'cache_type', 'cache_data', 'expires_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = null;
    
    // Get cache yang valid
    public function getCache($key)
    {
        $cache = $this->where('cache_key', $key)
                      ->where('expires_at >', date('Y-m-d H:i:s'))
                      ->first();
        
        if ($cache) {
            return json_decode($cache['cache_data'], true);
        }
        
        return null;
    }
    
    // Set cache
    public function setCache($key, $type, $data, $ttl = 86400)
    {
        $expiresAt = date('Y-m-d H:i:s', time() + $ttl);
        
        return $this->insert([
            'cache_key' => $key,
            'cache_type' => $type,
            'cache_data' => json_encode($data),
            'expires_at' => $expiresAt
        ]);
    }
    
    // Clean expired cache
    public function cleanExpired()
    {
        return $this->where('expires_at <', date('Y-m-d H:i:s'))->delete();
    }
}
