<?php

namespace App\Controllers;

use App\Libraries\RajaOngkirService;
use CodeIgniter\Controller;

class RajaOngkirController extends BaseController
{
    protected $rajaOngkir;
    
    public function __construct()
    {
        $this->rajaOngkir = new RajaOngkirService();
    }
    
    /**
     * Calculate shipping cost from district
     * POST /rajaongkir/calculate-shipping
     */
    public function calculateShipping()
    {
        try {
            $districtId = $this->request->getPost('district_id');
            $weight = $this->request->getPost('weight') ?: 1000;
            
            if (!$districtId) {
                return $this->response->setJSON(['success' => false, 'message' => 'District ID is required']);
            }
            
            $result = $this->rajaOngkir->calculateMultipleCouriers($districtId, $weight);
            return $this->response->setJSON($result);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan internal: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Search domestic destination
     * GET /rajaongkir/search-destination?query=xxx
     */
    public function searchDestination()
    {
        $query = $this->request->getGet('query');
        
        if (!$query) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Query parameter is required'
            ]);
        }
        
        $result = $this->rajaOngkir->searchDomesticDestination($query, 10);
        
        if ($result) {
            return $this->response->setJSON([
                'success' => true,
                'data' => $result['data'] ?? []
            ]);
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'No results found'
        ]);
    }
}