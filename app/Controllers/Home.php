<?php

namespace App\Controllers;

use App\Models\ProductModel; 
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
class Home extends BaseController
{
    protected $product;
    protected $transaction;
    protected $transaction_detail;

    public function __construct()
    {
        helper('form');
        helper('number');
        $this->product = new ProductModel();
        $this->transaction = new TransactionModel;
        $this->transaction_detail = new TransactionDetailModel;
    }

    public function index(): string
    {
        $product = $this->product->findAll();
        $data['product'] = $product;

        return view('v_home',$data);
    }
}
