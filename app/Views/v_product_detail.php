<?= $this->extend('layout_user') ?>
<?= $this->section('content') ?>

<style>
    .product-detail-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .product-detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 48px;
        margin-bottom: 40px;
    }
    
    .product-image-section {
        position: sticky;
        top: 100px;
    }
    
    .main-image {
        width: 100%;
        height: 500px;
        border-radius: 20px;
        object-fit: cover;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    
    .product-info-section {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    
    .product-badge-status {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 16px;
    }
    
    .badge-available {
        background: #d1fae5;
        color: #065f46;
    }
    
    .badge-sold {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .product-title-detail {
        font-size: 32px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 16px;
        line-height: 1.2;
    }
    
    .product-price-detail {
        font-size: 40px;
        font-weight: 800;
        color: #667eea;
        margin-bottom: 24px;
    }
    
    .product-meta {
        display: flex;
        gap: 24px;
        padding: 20px 0;
        border-top: 2px solid #f1f5f9;
        border-bottom: 2px solid #f1f5f9;
        margin-bottom: 24px;
    }
    
    .meta-item {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #64748b;
        font-size: 14px;
    }
    
    .meta-item i {
        font-size: 20px;
        color: #667eea;
    }
    
    .product-description {
        font-size: 16px;
        line-height: 1.8;
        color: #475569;
        margin-bottom: 32px;
    }
    
    .action-buttons {
        display: flex;
        gap: 16px;
        margin-top: 32px;
    }
    
    .btn-buy-now {
        flex: 2;
        padding: 18px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    
    .btn-buy-now:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(102, 126, 234, 0.4);
    }
    
    .btn-negotiate {
        flex: 1;
        padding: 18px;
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
        border-radius: 12px;
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    
    .btn-negotiate:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
    }
    
    .seller-info-card {
        background: #f8fafc;
        padding: 24px;
        border-radius: 16px;
        margin-top: 32px;
    }
    
    .seller-info-card h4 {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 16px;
    }
    
    .seller-detail {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    
    .seller-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
    }
    
    .seller-name {
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
    }
    
    .seller-location {
        font-size: 14px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 4px;
    }
    
    /* Modal Nego */
    .modal-nego .modal-content {
        border: none;
        border-radius: 20px;
    }
    
    .modal-nego .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px 20px 0 0;
        padding: 24px 28px;
    }
    
    .nego-price-display {
        background: #f8fafc;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 20px;
    }
    
    .nego-price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }
    
    .nego-price-label {
        color: #64748b;
        font-size: 14px;
    }
    
    .nego-price-value {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
    }
    
    .nego-offer-input {
        width: 100%;
        padding: 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 18px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .nego-offer-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }
    
    @media (max-width: 768px) {
        .product-detail-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }
        
        .product-image-section {
            position: static;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-buy-now, .btn-negotiate {
            flex: 1;
        }
    }
</style>

<div class="product-detail-container">
    <div class="product-detail-grid">
        <!-- Left: Image -->
        <div class="product-image-section">
            <img src="<?= base_url('img/' . $product['foto']) ?>" 
                 alt="<?= $product['nama'] ?>" 
                 class="main-image">
        </div>
        
        <!-- Right: Info -->
        <div class="product-info-section">
            <span class="product-badge-status <?= $product['status'] == 1 ? 'badge-available' : 'badge-sold' ?>">
                <?= $product['status'] == 1 ? '✓ Available' : '✗ Sold Out' ?>
            </span>
            
            <h1 class="product-title-detail"><?= esc($product['nama']) ?></h1>
            
            <div class="product-price-detail">
                Rp <?= number_format($product['harga'], 0, ',', '.') ?>
            </div>
            
            <div class="product-meta">
                <div class="meta-item">
                    <i class="bi bi-box-seam"></i>
                    <span><?= format_weight($product['weight'] ?? 500) ?></span>
                </div>
                <div class="meta-item">
                    <i class="bi bi-geo-alt"></i>
                    <span><?= $product['city_name'] ?? 'Indonesia' ?></span>
                </div>
                <?php if ($product['is_negotiable']): ?>
                <div class="meta-item">
                    <i class="bi bi-chat-dots"></i>
                    <span>Negotiable</span>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="product-description">
                <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 12px;">Description</h4>
                <p><?= nl2br(esc($product['deskripsi'])) ?></p>
            </div>
            
            <?php if ($product['status'] == 1 && session()->get('isLoggedIn') && session()->get('user_id') != $product['id_user']): ?>
            <div class="action-buttons">
                <button class="btn-buy-now" onclick="buyNow()">
                    <i class="bi bi-cart-check-fill"></i>
                    <span>Beli Sekarang</span>
                </button>
                
                <?php if ($product['is_negotiable']): ?>
                <button class="btn-negotiate" data-bs-toggle="modal" data-bs-target="#negoModal">
                    <i class="bi bi-chat-left-dots-fill"></i>
                    <span>Tawar Harga</span>
                </button>
                <?php endif; ?>
            </div>
            <?php elseif (!session()->get('isLoggedIn')): ?>
            <div class="action-buttons">
                <a href="<?= base_url('login') ?>" class="btn-buy-now">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Login to Buy</span>
                </a>
            </div>
            <?php endif; ?>
            
            <!-- Seller Info -->
            <div class="seller-info-card">
                <h4>Seller Information</h4>
                <div class="seller-detail">
                    <img src="<?= base_url('img/' . ($seller['img_profile'] ?? 'no_profile.jpg')) ?>" 
                         alt="Seller" class="seller-avatar">
                    <div>
                        <div class="seller-name"><?= esc($seller['username']) ?></div>
                        <div class="seller-location">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span><?= $product['city_name'] ?? 'Indonesia' ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nego -->
<div class="modal fade modal-nego" id="negoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">💬 Tawar Harga</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: brightness(0) invert(1);"></button>
            </div>
            <div class="modal-body" style="padding: 28px;">
                <div class="nego-price-display">
                    <div class="nego-price-row">
                        <span class="nego-price-label">Harga Asli</span>
                        <span class="nego-price-value">Rp <?= number_format($product['harga'], 0, ',', '.') ?></span>
                    </div>
                </div>
                
                <div class="form-group-custom" style="margin-bottom: 20px;">
                    <label class="form-label-custom">Harga Tawaran Anda</label>
                    <input type="number" id="offerPrice" class="nego-offer-input" 
                           placeholder="Masukkan harga tawaran" 
                           max="<?= $product['harga'] - 1000 ?>">
                    <small style="color: #64748b; font-size: 13px; display: block; margin-top: 8px;">
                        Harga tawaran harus lebih rendah dari harga asli
                    </small>
                </div>
                
                <div class="form-group-custom">
                    <label class="form-label-custom">Pesan (Opsional)</label>
                    <textarea id="offerMessage" class="form-control-custom" rows="3" 
                              placeholder="Sampaikan alasan atau kondisi nego..."></textarea>
                </div>
            </div>
            <div class="modal-footer-custom" style="padding: 20px 28px; border-top: 1px solid #e2e8f0;">
                <button type="button" class="btn-modal btn-secondary-custom" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn-modal btn-primary-custom" onclick="submitNego()">Kirim Tawaran</button>
            </div>
        </div>
    </div>
</div>

<script>
// Buy Now
function buyNow() {
    window.location.href = '<?= base_url("transaction/checkout/" . $product['id']) ?>';
}

// Submit Nego
function submitNego() {
    const offerPrice = document.getElementById('offerPrice').value;
    const message = document.getElementById('offerMessage').value;
    
    if (!offerPrice || offerPrice <= 0) {
        alert('Harga tawaran harus diisi!');
        return;
    }
    
    if (offerPrice >= <?= $product['harga'] ?>) {
        alert('Harga tawaran harus lebih rendah dari harga asli!');
        return;
    }
    
    // Send AJAX request
    fetch('<?= base_url("negotiation/create") ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            product_id: <?= $product['id'] ?>,
            offer_price: offerPrice,
            message: message
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            bootstrap.Modal.getInstance(document.getElementById('negoModal')).hide();
            // Redirect ke halaman my offers
            window.location.href = '<?= base_url("negotiation/my-offers") ?>';
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
}
</script>

<?= $this->endSection() ?>