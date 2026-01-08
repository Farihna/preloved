<?= $this->extend('layout_user') ?>
<?= $this->section('content') ?>

<style>
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 24px;
        padding: 60px 40px;
        margin-bottom: 48px;
        color: white;
        text-align: center;
    }
    
    .hero-title {
        font-size: 42px;
        font-weight: 800;
        margin-bottom: 16px;
    }
    
    .hero-subtitle {
        font-size: 18px;
        opacity: 0.95;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 28px;
        margin-top: 32px;
    }
    
    .product-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.4s ease;
        border: 2px solid transparent;
    }
    
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        border-color: #667eea;
    }
    
    .product-image-wrapper {
        position: relative;
        width: 100%;
        height: 280px;
        overflow: hidden;
        background: #f1f5f9;
    }
    
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    
    .product-card:hover .product-image {
        transform: scale(1.08);
    }
    
    .product-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    }
    
    .product-badge.available {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    }
    
    .product-content {
        padding: 24px;
    }
    
    .product-title {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .product-price {
        font-size: 26px;
        font-weight: 800;
        color: #667eea;
        margin-bottom: 12px;
    }
    
    .product-description {
        font-size: 14px;
        color: #64748b;
        line-height: 1.6;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .product-footer {
        display: flex;
        gap: 12px;
    }
    
    .btn-contact {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 24px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 15px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .btn-contact:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        color: white;
    }
    
    .alert-success-custom {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 20px 24px;
        border-radius: 16px;
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 4px 20px rgba(16, 185, 129, 0.2);
    }
    
    .alert-success-custom i {
        font-size: 24px;
    }
    
    .empty-state {
        text-align: center;
        padding: 80px 20px;
    }
    
    .empty-state i {
        font-size: 80px;
        color: #cbd5e1;
        margin-bottom: 24px;
    }
    
    .empty-state h3 {
        font-size: 24px;
        color: #475569;
        margin-bottom: 12px;
    }
    
    .empty-state p {
        color: #94a3b8;
        font-size: 16px;
    }
    
    @media (max-width: 768px) {
        .hero-section {
            padding: 40px 24px;
        }
        
        .hero-title {
            font-size: 28px;
        }
        
        .hero-subtitle {
            font-size: 16px;
        }
        
        .products-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }
</style>

<?php if (session()->getFlashData('success')): ?>
    <div class="alert-success-custom">
        <i class="bi bi-check-circle-fill"></i>
        <span><?= session()->getFlashData('success') ?></span>
    </div>
<?php endif; ?>

<div class="hero-section">
    <h1 class="hero-title">Discover Preloved Treasures</h1>
    <p class="hero-subtitle">Find amazing deals on quality second-hand items. Buy sustainable, save money, and give products a second life.</p>
</div>

<?php if (empty($product)): ?>
    <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <h3>No Products Yet</h3>
        <p>Check back soon for new items!</p>
    </div>
<?php else: ?>
    <div class="products-grid">
        <?php foreach ($product as $item): ?>
            <div class="product-card">
                <div class="product-image-wrapper">
                    <img src="<?= base_url('img/' . $item['foto']) ?>" alt="<?= $item['nama'] ?>" class="product-image">
                    <?php if ($item['status'] == 0): ?>
                        <div class="product-badge">Sold</div>
                    <?php else: ?>
                        <div class="product-badge available">Available</div>
                    <?php endif; ?>
                </div>
                
                <div class="product-content">
                    <h3 class="product-title"><?= $item['nama'] ?></h3>
                    <div class="product-price"><?= number_to_currency($item['harga'], 'IDR') ?></div>
                    <p class="product-description"><?= $item['deskripsi'] ?></p>
                    
                    <div class="product-footer">
                        <a href="<?= base_url('produk/detail/' . $item['id']) ?>" class="btn-buy-now">
                        <i class="bi bi-cart-check"></i> Beli Sekarang
                    </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>