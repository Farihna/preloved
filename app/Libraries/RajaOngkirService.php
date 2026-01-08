<?php

namespace App\Libraries;

use App\Models\RajaOngkirCacheModel;

class RajaOngkirService
{
    protected $apiKey;
    protected $baseUrl;
    protected $cacheModel;
    
    public function __construct()
    {
        // Set your RajaOngkir API Key here or in .env file
        $this->apiKey = getenv('RAJAONGKIR_API_KEY') ?: 'YOUR_API_KEY_HERE';
        $this->baseUrl = 'https://api.rajaongkir.com/starter';
        $this->cacheModel = new RajaOngkirCacheModel();
    }
    
    /**
     * Get all provinces
     */
    public function getProvinces()
    {
        $cacheKey = 'provinces_all';
        
        // Check cache first
        $cached = $this->cacheModel->getCache($cacheKey);
        if ($cached) {
            return $cached;
        }
        
        // Call API
        $response = $this->callApi('province');
        
        if ($response && isset($response['rajaongkir']['results'])) {
            $data = $response['rajaongkir']['results'];
            
            // Save to cache (30 days)
            $this->cacheModel->setCache($cacheKey, 'province', $data, 2592000);
            
            return $data;
        }
        
        return null;
    }
    
    /**
     * Get cities (all or by province)
     */
    public function getCities($provinceId = null)
    {
        $cacheKey = $provinceId ? "cities_province_{$provinceId}" : 'cities_all';
        
        // Check cache
        $cached = $this->cacheModel->getCache($cacheKey);
        if ($cached) {
            return $cached;
        }
        
        // Call API
        $endpoint = 'city';
        if ($provinceId) {
            $endpoint .= '?province=' . $provinceId;
        }
        
        $response = $this->callApi($endpoint);
        
        if ($response && isset($response['rajaongkir']['results'])) {
            $data = $response['rajaongkir']['results'];
            
            // Save to cache (30 days)
            $this->cacheModel->setCache($cacheKey, 'city', $data, 2592000);
            
            return $data;
        }
        
        return null;
    }
    
    /**
     * Get shipping cost
     */
    public function getCost($origin, $destination, $weight, $courier)
    {
        // Cache key for cost calculation
        $cacheKey = md5("cost_{$origin}_{$destination}_{$weight}_{$courier}");
        
        // Check cache (1 hour)
        $cached = $this->cacheModel->getCache($cacheKey);
        if ($cached) {
            return $cached;
        }
        
        // Prepare data
        $data = [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier
        ];
        
        // Call API
        $response = $this->callApi('cost', $data, 'POST');
        
        if ($response && isset($response['rajaongkir']['results'])) {
            $data = $response['rajaongkir']['results'];
            
            // Save to cache (1 hour)
            $this->cacheModel->setCache($cacheKey, 'cost', $data, 3600);
            
            return $data;
        }
        
        return null;
    }
    
    /**
     * Call RajaOngkir API
     */
    private function callApi($endpoint, $data = null, $method = 'GET')
    {
        $url = $this->baseUrl . '/' . $endpoint;
        
        $curl = curl_init();
        
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => [
                'key: ' . $this->apiKey
            ]
        ];
        
        if ($method === 'POST' && $data) {
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = http_build_query($data);
        }
        
        curl_setopt_array($curl, $options);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            log_message('error', 'RajaOngkir API Error: ' . $err);
            return null;
        }
        
        return json_decode($response, true);
    }
    
    /**
     * Get city detail by ID
     */
    public function getCityDetail($cityId)
    {
        $response = $this->callApi("city?id={$cityId}");
        
        if ($response && isset($response['rajaongkir']['results'])) {
            return $response['rajaongkir']['results'];
        }
        
        return null;
    }
    
    /**
     * Format courier services for display
     */
    public function formatCourierServices($results)
    {
        $formatted = [];
        
        foreach ($results as $result) {
            if (!isset($result['costs'])) continue;
            
            foreach ($result['costs'] as $cost) {
                $formatted[] = [
                    'courier_code' => strtolower($result['code']),
                    'courier_name' => $result['name'],
                    'service' => $cost['service'],
                    'description' => $cost['description'],
                    'cost' => $cost['cost'][0]['value'],
                    'etd' => $cost['cost'][0]['etd'],
                    'note' => $cost['cost'][0]['note'] ?? ''
                ];
            }
        }
        
        // Sort by price
        usort($formatted, function($a, $b) {
            return $a['cost'] - $b['cost'];
        });
        
        return $formatted;
    }
}