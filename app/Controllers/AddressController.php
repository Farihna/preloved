<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AddressModel;
use App\Models\ProvinceModel;
use App\Models\CityModel;
use App\Models\DistrictModel;
use App\Models\VillageModel;

class AddressController extends BaseController
{
    protected $addressModel;
    protected $provinceModel;
    protected $cityModel;
    protected $districtModel;
    protected $villageModel;

    public function __construct()
    {
        $this->addressModel = new AddressModel();
        $this->provinceModel = new ProvinceModel();
        $this->cityModel = new CityModel();
        $this->districtModel = new DistrictModel();
        $this->villageModel = new VillageModel();
    }

    public function getProvinces()
    {
        $provinces = $this->provinceModel->orderBy('name', 'ASC')->findAll();
        return $this->response->setJSON([
            'success' => true,
            'data' => $provinces
        ]);
    }

    public function getCities($provinceId)
    {
        $cities = $this->cityModel->getCitiesByProvince($provinceId);
        return $this->response->setJSON([
            'success' => true,
            'data' => $cities
        ]);
    }

    public function getDistricts($cityId)
    {
        $districts = $this->districtModel->getDistrictsByCitiy($cityId);
        return $this->response->setJSON([
            'success' => true,
            'data' => $districts
        ]);
    }

    public function getVillages($districtId)
    {
        $villages = $this->villageModel->getVillagesByDistrict($districtId);
        return $this->response->setJSON([
            'success' => true,
            'data' => $villages
        ]);
    }

    public function store()
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        $rules = [
            'label' => 'required',
            'recipient_name' => 'required',
            'phone_number' => 'required',
            'address_line' => 'required',
            'province_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'district_id' => 'required|numeric',
            'village_id' => 'required|numeric',
            'zip_code' => 'required|max_length[5]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak lengkap',
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Jika set sebagai default, update alamat lain jadi tidak default
        if ($this->request->getPost('is_default') == '1') {
            $this->addressModel->where('user_id', $userId)
                               ->set(['is_default' => 0])
                               ->update();
        }

        // Ambil nama wilayah untuk disimpan di kolom text
        $province = $this->provinceModel->find($this->request->getPost('province_id'));
        $city = $this->cityModel->find($this->request->getPost('city_id'));
        $district = $this->districtModel->find($this->request->getPost('district_id'));
        $village = $this->villageModel->find($this->request->getPost('village_id'));

        $data = [
            'user_id' => $userId,
            'type' => $this->request->getPost('type') ?? 'home',
            'is_default' => $this->request->getPost('is_default') ?? 0,
            'label' => $this->request->getPost('label'),
            'recipient_name' => $this->request->getPost('recipient_name'),
            'phone_number' => $this->request->getPost('phone_number'),
            'address_line' => $this->request->getPost('address_line'),
            'province_id' => $this->request->getPost('province_id'),
            'city_id' => $this->request->getPost('city_id'),
            'district_id' => $this->request->getPost('district_id'),
            'village_id' => $this->request->getPost('village_id'),
            'zip_code' => $this->request->getPost('zip_code'),
            'province' => $province['name'] ?? '',
            'city' => $city['name'] ?? '',
            'district' => $district['name'] ?? '',
            'village' => $village['name'] ?? ''
        ];

        if ($this->addressModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Alamat berhasil ditambahkan'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal menambahkan alamat'
        ]);
    }

    public function edit($id)
    {
        $userId = session()->get('user_id');
        $address = $this->addressModel->find($id);

        if (!$address || $address['user_id'] != $userId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Alamat tidak ditemukan'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $address
        ]);
    }

    public function update()
    {
        $userId = session()->get('user_id');
        $addressId = $this->request->getPost('address_id');
        
        if (!$userId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        // Check ownership
        $address = $this->addressModel->find($addressId);
        if (!$address || $address['user_id'] != $userId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Alamat tidak ditemukan'
            ]);
        }

        $rules = [
            'label' => 'required',
            'recipient_name' => 'required',
            'phone_number' => 'required',
            'address_line' => 'required',
            'province_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'district_id' => 'required|numeric',
            'village_id' => 'required|numeric',
            'zip_code' => 'required|max_length[5]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak lengkap',
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Jika set sebagai default, update alamat lain jadi tidak default
        if ($this->request->getPost('is_default') == '1') {
            $this->addressModel->where('user_id', $userId)
                            ->where('id !=', $addressId)
                            ->set(['is_default' => 0])
                            ->update();
        }

        // Ambil nama wilayah untuk disimpan
        $province = $this->provinceModel->find($this->request->getPost('province_id'));
        $city = $this->cityModel->find($this->request->getPost('city_id'));
        $district = $this->districtModel->find($this->request->getPost('district_id'));
        $village = $this->villageModel->find($this->request->getPost('village_id'));

        $data = [
            'type' => $this->request->getPost('type') ?? $address['type'],
            'is_default' => $this->request->getPost('is_default') ?? $address['is_default'],
            'label' => $this->request->getPost('label'),
            'recipient_name' => $this->request->getPost('recipient_name'),
            'phone_number' => $this->request->getPost('phone_number'),
            'address_line' => $this->request->getPost('address_line'),
            'province_id' => $this->request->getPost('province_id'),
            'city_id' => $this->request->getPost('city_id'),
            'district_id' => $this->request->getPost('district_id'),
            'village_id' => $this->request->getPost('village_id'),
            'zip_code' => $this->request->getPost('zip_code'),
            'province' => $province['name'] ?? '',
            'city' => $city['name'] ?? '',
            'district' => $district['name'] ?? '',
            'village' => $village['name'] ?? ''
        ];

        if ($this->addressModel->update($addressId, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Alamat berhasil diperbarui'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal memperbarui alamat'
        ]);
    }

    public function getPostalCodeByVillage($villageId)
    {
        $villageModel = new VillageModel();
        $result = $villageModel->getPostalCodeByVillageId($villageId);

        return $this->response->setJSON([
            'success' => (bool)$result,
            'postal_code' => $result ? $result->code : ''
        ]);
    }

    public function setDefault($id)
    {
        $userId = session()->get('user_id');
        $address = $this->addressModel->find($id);

        if (!$address || $address['user_id'] != $userId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Alamat tidak ditemukan'
            ]);
        }

        // Set semua alamat user jadi tidak default
        $this->addressModel->where('user_id', $userId)->set(['is_default' => 0])->update();
        
        // Set alamat terpilih jadi default
        $this->addressModel->update($id, ['is_default' => 1]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Alamat default berhasil diubah'
        ]);
    }

    public function delete($id)
    {
        $userId = session()->get('user_id');
        $address = $this->addressModel->find($id);

        if (!$address || $address['user_id'] != $userId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Alamat tidak ditemukan'
            ]);
        }

        if ($this->addressModel->delete($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Alamat berhasil dihapus'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal menghapus alamat'
        ]);
    }
}