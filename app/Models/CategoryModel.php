<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'slug', 'icon', 'description', 'is_active'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]',
        'slug' => 'required|alpha_dash|is_unique[categories.slug,id,{id}]',
    ];
    
    /**
     * Get all active categories
     */
    public function getActiveCategories()
    {
        return $this->where('is_active', 1)
                    ->orderBy('name', 'ASC')
                    ->findAll();
    }
    
    /**
     * Get category with product count
     */
    public function getCategoriesWithCount()
    {
        return $this->select('categories.*, COUNT(product.id) as product_count')
                    ->join('product', 'product.category_id = categories.id AND product.status = 1', 'left')
                    ->where('categories.is_active', 1)
                    ->groupBy('categories.id')
                    ->orderBy('categories.name', 'ASC')
                    ->findAll();
    }
    
    /**
     * Get category by slug
     */
    public function getCategoryBySlug($slug)
    {
        return $this->where('slug', $slug)
                    ->where('is_active', 1)
                    ->first();
    }
    
    /**
     * Get popular categories (most product)
     */
    public function getPopularCategories($limit = 6)
    {
        return $this->select('categories.*, COUNT(product.id) as product_count')
                    ->join('product', 'product.category_id = categories.id AND product.status = 1', 'left')
                    ->where('categories.is_active', 1)
                    ->groupBy('categories.id')
                    ->orderBy('product_count', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
    
    /**
     * Generate slug from name
     */
    public function generateSlug($name)
    {
        $slug = url_title($name, '-', true);
        
        // Check if slug exists
        $exists = $this->where('slug', $slug)->first();
        
        if ($exists) {
            $slug = $slug . '-' . time();
        }
        
        return $slug;
    }
}
