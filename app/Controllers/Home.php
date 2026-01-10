<?php

namespace App\Controllers;

use App\Models\ProductModel; 
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\UserModel;
use App\Models\CategoryModel;

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
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        
        // Get category filter from query string
        $categorySlug = $this->request->getGet('category');
        $search = $this->request->getGet('search');
        
        // Build query
        $builder = $productModel->select('product.*, user.username, user.hp, categories.name as category_name, categories.icon as category_icon')
                                ->join('user', 'user.id = product.id')
                                ->join('categories', 'categories.id = product.category_id', 'left')
                                ->where('product.status', 1);
        
        // Filter by category
        if ($categorySlug) {
            $category = $categoryModel->getCategoryBySlug($categorySlug);
            if ($category) {
                $builder->where('product.category_id', $category['id']);
            }
        }
        
        // Search filter
        if ($search) {
            $builder->groupStart()
                    ->like('product.nama', $search)
                    ->orLike('product.deskripsi', $search)
                    ->groupEnd();
        }
        
        $products = $builder->orderBy('product.created_at', 'DESC')->findAll();
        
        // Get all categories with count
        $categories = $categoryModel->getCategoriesWithCount();
        
        $data = [
            'product' => $products,
            'categories' => $categories,
            'activeCategory' => $categorySlug ?? 'all',
            'searchKeyword' => $search ?? ''
        ];
        
        return view('v_home', $data);
    }
}