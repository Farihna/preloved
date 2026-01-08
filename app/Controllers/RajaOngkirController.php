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
     * Get all provinces
     * GET /rajaongkir/provinces
     */
    public function provinces()
    {
        $provinces = $this->rajaOngkir->getProvinces();
        
        if ($provinces) {
            return $this->response->setJSON([
                'success' => true,
                'data' => $provinces
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to get provinces'
            ]);
        }
    }
    
    /**
     * Get cities by province
     * GET /rajaongkir/cities/{province_id}
     */
    public function cities($provinceId = null)
    {
        $cities = $this->rajaOngkir->getCities($provinceId);
        
        if ($cities) {
            return $this->response->setJSON([
                'success' => true,
                'data' => $cities
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to get cities'
            ]);
        }
    }
    
    /**
     * Calculate shipping cost
     * POST /rajaongkir/cost
     */
    public function cost()
    {
        $origin = $this->request->getPost('origin');
        $destination = $this->request->getPost('destination');
        $weight = $this->request->getPost('weight');
        $courier = $this->request->getPost('courier');
        
        // Validation
        if (!$origin || !$destination || !$weight || !$courier) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'All parameters are required'
            ]);
        }
        
        $cost = $this->rajaOngkir->getCost($origin, $destination, $weight, $courier);
        
        if ($cost) {
            return $this->response->setJSON([
                'success' => true,
                'data' => $cost
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to calculate shipping cost'
            ]);
        }
    }
}