<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    protected $produk;
    protected $user;

    public function __construct()
    {
        $this->produk = new ProductModel();
        $this->user = new UserModel();
    }

    public function index()
    {
        $userCount = $this->user->countAllResults();
        $productCount = $this->produk->countAllResults();

        $data= [
            'userCount' => $userCount,
            'productCount' => $productCount
        ];
        return view('admin/v_dashboard', $data);
    }
}
