<?php

namespace App\Libraries;

class RajaOngkirService
{
    protected $apiKey;
    protected $baseUrl;
    protected $defaultOriginId;
    
    public function __construct()
    {
        $config = RajaOngkirConfig::get();
        
        $this->apiKey = $config->apiKey;
        $this->baseUrl = $config->baseUrl;
        $this->defaultOriginId = $config->defaultOriginId;
        
        log_message('info', 'RajaOngkir Service Initialized');
        log_message('info', 'API Key: ' . substr($this->apiKey, 0, 10) . '***');
        log_message('info', 'Base URL: ' . $this->baseUrl);
        log_message('info', 'Origin ID: ' . $this->defaultOriginId);
    }
    
    /**
     * Search domestic destination
     */
    public function searchDomesticDestination($searchQuery, $limit = 5)
    {
        try {
            $url = $this->baseUrl . '/destination/domestic-destination';
            
            $queryParams = http_build_query([
                'search' => $searchQuery,
                'limit' => $limit
            ]);
            
            $fullUrl = $url . '?' . $queryParams;
            
            log_message('info', 'Searching destination: ' . $searchQuery);
            
            $curl = curl_init();
            
            curl_setopt_array($curl, [
                CURLOPT_URL => $fullUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => [
                    'accept: application/json',
                    'key: ' . $this->apiKey
                ],
            ]);
            
            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $err = curl_error($curl);
            
            curl_close($curl);
            
            if ($err) {
                log_message('error', 'cURL Error: ' . $err);
                return null;
            }
            
            log_message('info', 'Search HTTP Code: ' . $httpCode);
            
            $result = json_decode($response, true);
            
            return $result;
        } catch (\Exception $e) {
            log_message('error', 'Search Destination Error: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Calculate domestic shipping cost
     */
    public function calculateDomesticCost($originId, $destinationId, $weight, $courier)
    {
        try {
            $url = $this->baseUrl . '/calculate/domestic-cost';
            
            log_message('info', "Calculating: Origin={$originId}, Dest={$destinationId}, Weight={$weight}, Courier={$courier}");
            
            $curl = curl_init();
            
            $postFields = [
                'origin' => (string)$originId,
                'destination' => (string)$destinationId,
                'weight' => (string)$weight,
                'courier' => $courier
            ];
            
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => http_build_query($postFields),
                CURLOPT_HTTPHEADER => [
                    'accept: application/json',
                    'content-type: application/x-www-form-urlencoded',
                    'key: ' . $this->apiKey
                ],
            ]);
            
            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $err = curl_error($curl);
            
            curl_close($curl);
            
            if ($err) {
                log_message('error', "cURL Error ({$courier}): " . $err);
                return null;
            }
            
            log_message('info', "Cost HTTP Code ({$courier}): " . $httpCode);
            
            $result = json_decode($response, true);
            
            return $result;
        } catch (\Exception $e) {
            log_message('error', "Calculate Cost Error ({$courier}): " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get destination ID from district, city, and province
     */
    public function getDestinationId($districtName, $cityName, $provinceName)
    {
        try {
            // Try with full address first
            $searchQuery = trim($districtName) . ', ' . trim($cityName) . ', ' . trim($provinceName);
            
            log_message('info', 'Search (full): ' . $searchQuery);
            
            $result = $this->searchDomesticDestination($searchQuery, 5);
            
            if ($result && !empty($result['data'])) {
                log_message('info', 'Found destination: ' . $result['data'][0]['id']);
                return $result['data'][0]['id'];
            }
            
            // Fallback: Try with City and Province only
            $fallbackQuery = trim($cityName) . ', ' . trim($provinceName);
            
            log_message('info', 'Search (fallback): ' . $fallbackQuery);
            
            $result = $this->searchDomesticDestination($fallbackQuery, 1);
            
            if ($result && !empty($result['data'])) {
                log_message('info', 'Found destination (fallback): ' . $result['data'][0]['id']);
                return $result['data'][0]['id'];
            }
            
            log_message('error', 'Destination not found');
            return null;
        } catch (\Exception $e) {
            log_message('error', 'Get Destination ID Error: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Calculate shipping for multiple couriers
     */
    public function calculateMultipleCouriers($districtId, $weight)
    {
        try {
            $db = \Config\Database::connect();
            
            log_message('info', "=== START CALCULATION ===");
            log_message('info', "District ID: {$districtId}, Weight: {$weight}");
            
            // Get district, city, province names
            $query = $db->table('districts')
                ->select('districts.name as district_name, cities.name as city_name, cities.type as city_type, provinces.name as province_name')
                ->join('cities', 'cities.id = districts.city_id')
                ->join('provinces', 'provinces.id = cities.province_id')
                ->where('districts.id', $districtId)
                ->get();
            
            $location = $query->getRow();
            
            if (!$location) {
                log_message('error', 'Location not found');
                return [
                    'success' => false,
                    'message' => 'Data wilayah tidak ditemukan'
                ];
            }
            
            log_message('info', 'Location: ' . json_encode($location));
            
            // Get destination ID
            $destinationId = $this->getDestinationId(
                $location->district_name,
                $location->city_name,
                $location->province_name
            );
            
            if (!$destinationId) {
                return [
                    'success' => false,
                    'message' => "Lokasi tidak ditemukan di RajaOngkir: {$location->district_name}, {$location->city_name}"
                ];
            }
            
            log_message('info', "Destination ID: {$destinationId}");
            
            // Get couriers
            $config = RajaOngkirConfig::get();
            $couriers = $config->availableCouriers;
            
            $shippingOptions = [];
            
            // Calculate cost for each courier
            foreach ($couriers as $courier) {
                try {
                    $result = $this->calculateDomesticCost(
                        $this->defaultOriginId,
                        $destinationId,
                        $weight,
                        $courier
                    );
                    
                    if ($result && !empty($result['data'])) {
                        foreach ($result['data'] as $service) {
                            $shippingOptions[] = [
                                'courier_code' => $courier,
                                'courier_name' => strtoupper($courier),
                                'service' => $service['service'] ?? 'Regular',
                                'description' => $service['description'] ?? '',
                                'cost' => (int)($service['cost'] ?? 0),
                                'etd' => $service['etd'] ?? 'N/A',
                            ];
                        }
                        log_message('info', "✓ {$courier}: " . count($result['data']) . " services");
                    } else {
                        log_message('warning', "✗ {$courier}: No data");
                    }
                } catch (\Exception $e) {
                    log_message('error', "✗ {$courier}: " . $e->getMessage());
                    continue;
                }
            }
            
            if (empty($shippingOptions)) {
                log_message('error', 'No shipping options found');
                return [
                    'success' => false,
                    'message' => 'Tidak ada layanan pengiriman tersedia'
                ];
            }
            
            // Sort by cost
            usort($shippingOptions, function($a, $b) {
                return $a['cost'] <=> $b['cost'];
            });
            
            log_message('info', "Total options: " . count($shippingOptions));
            log_message('info', "Cheapest: {$shippingOptions[0]['courier_name']} - Rp" . number_format($shippingOptions[0]['cost']));
            log_message('info', "=== END CALCULATION ===");
            
            return [
                'success' => true,
                'data' => $shippingOptions,
                'cheapest' => $shippingOptions[0],
                'destination_id' => $destinationId,
                'location' => $location
            ];
        } catch (\Exception $e) {
            log_message('error', '=== CALCULATION ERROR ===');
            log_message('error', 'Message: ' . $e->getMessage());
            log_message('error', 'File: ' . $e->getFile() . ':' . $e->getLine());
            
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }
}