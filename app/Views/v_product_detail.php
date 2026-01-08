<?= $this->extend('layout_user') ?>
<?= $this->section('content') ?>

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
                
                <div class="mb-3"> <label for="offerMessage" class="form-label">Pesan (Opsional)</label>
                    <textarea id="offerMessage" class="form-control" rows="3" 
                            placeholder="Sampaikan alasan atau kondisi nego..."></textarea>
                </div>

                <div class="modal-footer" style="padding: 20px 28px; border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="submitNego()">Kirim Tawaran</button>
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