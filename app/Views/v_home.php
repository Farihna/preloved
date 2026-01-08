<?= $this->extend('layout_user') ?>
<?= $this->section('content') ?>

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
                        <a href="<?= base_url('produk/detail/' . $item['id']) ?>" class="btn-buy-now btn btn-primary">
                        <i class="bi bi-cart-check"></i> Beli Sekarang
                    </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>