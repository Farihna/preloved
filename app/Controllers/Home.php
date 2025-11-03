<?php

namespace App\Controllers;

use App\Models\ProductModel; 
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\UserModel;
class Home extends BaseController
{
    protected $product;
    protected $transaction;
    protected $transaction_detail;
    protected $userModel;

    public function __construct()
    {
        helper('form');
        helper('number');
        $this->product = new ProductModel();
        $this->transaction = new TransactionModel;
        $this->transaction_detail = new TransactionDetailModel;
        $this->userModel = new UserModel();
    }

    public function index(): string
    {
        $product = $this->product->findAll();
        $data['product'] = $product;

        $user_id = session()->get('user_id');
        if ($user_id) {
            $data['user_profile'] = $this->userModel->find($user_id);
        } else {
            $data['user_profile'] = ['img_profile' => 'no_profil.jpg', 'username' => 'Guest'];
        }

        return view('v_home',$data);
    }
}
