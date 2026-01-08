<?php
namespace App\Config;

use CodeIgniter\Config\BaseConfig;

class RajaOngkir extends BaseConfig
{
    // RajaOngkir API Key (get from https://rajaongkir.com)
    public $apiKey = 'YOUR_API_KEY_HERE';
    
    // API Type: starter, basic, or pro
    public $apiType = 'starter';
    
    // Base URL based on API type
    public $baseUrls = [
        'starter' => 'https://api.rajaongkir.com/starter',
        'basic' => 'https://api.rajaongkir.com/basic',
        'pro' => 'https://pro.rajaongkir.com/api'
    ];
    
    // Available couriers for starter account
    public $availableCouriers = [
        'jne' => 'JNE',
        'pos' => 'POS Indonesia',
        'tiki' => 'TIKI'
    ];
    
    // Cache TTL (in seconds)
    public $cacheTTL = [
        'province' => 2592000,  // 30 days
        'city' => 2592000,      // 30 days
        'cost' => 3600          // 1 hour
    ];
}