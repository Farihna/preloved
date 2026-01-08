<?= $this->extend('layout_user') ?>
<?= $this->section('content') ?>

<style>
    .offers-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .nego-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 16px;
        transition: all 0.3s ease;
    }
    
    .nego-card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }
    
    .nego-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f1f5f9;
    }
    
    .nego-date {
        font-size: 13px;
        color: #64748b;
    }
    
    .nego-status-badge {
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
    }
    
    .status-nego-pending {
        background: #fef3c7;
        color: #92400e;
    }
    
    .status-nego-accepted {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-nego-countered {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .status-nego-rejected {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .nego-body {
        display: grid;
        grid-template-columns: 120px 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .nego-product-image {
        width: 120px;
        height: 120px;
        border-radius: 12px;
        object-fit: cover;
    }
    
    .nego-info {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    
    .nego-product-name {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
    }
    
    .nego-seller {
        font-size: 14px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .nego-prices {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        background: #f8fafc;
        padding: 16px;
        border-radius: 12px;
    }
    
    .price-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    
    .price-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
    }
    
    .price-value {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
    }
    
    .price-value.highlight {
        color: #667eea;
        font-size: 22px;
    }
    
    .price-value.success {
        color: #10b981;
    }
    
    .nego-messages {
        background: #fef3c7;
        padding: 16px;
        border-radius: 12px;
        margin-top: 16px;
        border-left: 4px solid #f59e0b;
    }
    
    .nego-messages.accepted {
        background: #d1fae5;
        border-left-color: #10b981;
    }
    
    .nego-messages.rejected {
        background: #fee2e2;
        border-left-color: #ef4444;
    }
    
    .message-label {
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 6px;
    }
    
    .message-text {
        font-size: 14px;
        color: #475569;
        line-height: 1.6;
    }
    
    .nego-footer {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 16px;
        border-top: 2px solid #f1f5f9;
    }
    
    .btn-nego-action {
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
    }
    
    .btn-checkout-nego {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .btn-checkout-nego:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        color: white;
    }
    
    .btn-counter-nego {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
    }
    
    .btn-counter-nego:hover {
        background: #667eea;
        color: white;
    }
    
    .nego-count-badge {
        display: inline-block;
        padding: 4px 10px;
        background: #667eea;
        color: white;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        margin-left: 8px;
    }
    
    @media (max-width: 768px) {
        .nego-body {
            grid-template-columns: 1fr;
        }
        
        .nego-prices {
            grid-template-columns: 1fr;
        }
        
        .nego-footer {
            flex-direction: column;
        }
        
        .btn-nego-action {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="offers-container">
    <div class="page-header-orders">
        <h1>Tawaran Saya</h1>
        <p>Kelola semua tawaran harga Anda</p>
    </div>
    
    <!-- Tabs -->
    <div class="tabs-container">
        <a href="<?= base_url('negotiation/my-offers') ?>" 
           class="tab-btn <?= $activeTab == 'all' ? 'active' : '' ?>">
            Semua
        </a>
        <a href="<?= base_url('negotiation/my-offers?status=pending') ?>" 
           class="tab-btn <?= $activeTab == 'pending' ? 'active' : '' ?>">
            Menunggu
        </a>
        <a href="<?= base_url('negotiation/my-offers?status=accepted') ?>" 
           class="tab-btn <?= $activeTab == 'accepted' ? 'active' : '' ?>">
            Diterima
        </a>
        <a href="<?= base_url('negotiation/my-offers?status=countered') ?>" 
           class="tab-btn <?= $activeTab == 'countered' ? 'active' : '' ?>">
            Ditawar Balik
        </a>
        <a href="<?= base_url('negotiation/my-offers?status=rejected') ?>" 
           class="tab-btn <?= $activeTab == 'rejected' ? 'active' : '' ?>">
            Ditolak
        </a>
    </div>
    
    <!-- Negotiations List -->
    <?php if (empty($negotiations)): ?>
        <div class="empty-state">
            <i class="bi bi-chat-left-dots"></i>
            <h3>Belum Ada Tawaran</h3>
            <p>Belum ada tawaran harga yang Anda ajukan</p>
        </div>
    <?php else: ?>
        <div class="orders-list">
            <?php foreach ($negotiations as $nego): ?>
            <div class="nego-card">
                <!-- Header -->
                <div class="nego-header">
                    <div class="nego-date">
                        <?= date('d M Y, H:i', strtotime($nego['created_at'])) ?>
                        <span class="nego-count-badge">Nego ke-<?= $nego['nego_count'] ?></span>
                    </div>
                    <span class="nego-status-badge status-nego-<?= $nego['status'] ?>">
                        <?php
                        $statusLabels = [
                            'pending' => '⏳ Menunggu Respons',
                            'accepted' => '✓ Diterima',
                            'countered' => '↔️ Ditawar Balik',
                            'rejected' => '✗ Ditolak'
                        ];
                        echo $statusLabels[$nego['status']] ?? $nego['status'];
                        ?>
                    </span>
                </div>
                
                <!-- Body -->
                <div class="nego-body">
                    <img src="<?= base_url('img/' . $nego['product_photo']) ?>" 
                         alt="<?= $nego['product_name'] ?>" 
                         class="nego-product-image">
                    
                    <div class="nego-info">
                        <div class="nego-product-name"><?= esc($nego['product_name']) ?></div>
                        <div class="nego-seller">
                            <i class="bi bi-shop"></i>
                            <span>Penjual: <?= esc($nego['seller_name']) ?></span>
                        </div>
                        
                        <!-- Prices -->
                        <div class="nego-prices">
                            <div class="price-item">
                                <span class="price-label">Harga Asli</span>
                                <span class="price-value">Rp <?= number_format($nego['original_price'], 0, ',', '.') ?></span>
                            </div>
                            
                            <div class="price-item">
                                <span class="price-label">Tawaran Anda</span>
                                <span class="price-value highlight">Rp <?= number_format($nego['offer_price'], 0, ',', '.') ?></span>
                            </div>
                            
                            <?php if ($nego['counter_price']): ?>
                            <div class="price-item">
                                <span class="price-label">Tawaran Penjual</span>
                                <span class="price-value success">Rp <?= number_format($nego['counter_price'], 0, ',', '.') ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <div class="price-item">
                                <span class="price-label">Hemat</span>
                                <span class="price-value" style="color: #10b981;">
                                    <?php
                                    $saved = $nego['status'] == 'accepted' 
                                        ? $nego['original_price'] - $nego['offer_price']
                                        : ($nego['counter_price'] ? $nego['original_price'] - $nego['counter_price'] : 0);
                                    ?>
                                    Rp <?= number_format($saved, 0, ',', '.') ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Messages -->
                <?php if ($nego['buyer_message']): ?>
                <div class="nego-messages">
                    <div class="message-label">📝 Pesan Anda:</div>
                    <div class="message-text"><?= nl2br(esc($nego['buyer_message'])) ?></div>
                </div>
                <?php endif; ?>
                
                <?php if ($nego['seller_message']): ?>
                <div class="nego-messages <?= $nego['status'] ?>">
                    <div class="message-label">💬 Balasan Penjual:</div>
                    <div class="message-text"><?= nl2br(esc($nego['seller_message'])) ?></div>
                </div>
                <?php endif; ?>
                
                <!-- Expiry Warning -->
                <?php if (in_array($nego['status'], ['accepted', 'countered']) && $nego['expires_at']): ?>
                    <?php
                    $expiryTime = strtotime($nego['expires_at']);
                    $now = time();
                    $hoursLeft = ($expiryTime - $now) / 3600;
                    ?>
                    <?php if ($hoursLeft > 0 && $hoursLeft < 24): ?>
                    <div class="nego-messages" style="background: #fee2e2; border-left-color: #ef4444; margin-top: 16px;">
                        <div class="message-label">⚠️ Perhatian:</div>
                        <div class="message-text">
                            Tawaran ini akan kadaluarsa dalam <?= ceil($hoursLeft) ?> jam. 
                            Segera checkout untuk mengamankan harga ini!
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
                
                <!-- Footer Actions -->
                <div class="nego-footer">
                    <?php if ($nego['status'] == 'accepted'): ?>
                        <a href="<?= base_url('transaction/checkout/' . $nego['product_id'] . '?nego_id=' . $nego['id']) ?>" 
                           class="btn-nego-action btn-checkout-nego">
                            <i class="bi bi-cart-check"></i>
                            <span>Checkout Sekarang</span>
                        </a>
                    <?php elseif ($nego['status'] == 'countered'): ?>
                        <?php if ($nego['nego_count'] < 3): ?>
                        <button class="btn-nego-action btn-counter-nego" 
                                data-bs-toggle="modal" 
                                data-bs-target="#counterModal<?= $nego['id'] ?>">
                            <i class="bi bi-arrow-repeat"></i>
                            <span>Nego Lagi</span>
                        </button>
                        <?php endif; ?>
                        <a href="<?= base_url('transaction/checkout/' . $nego['product_id'] . '?nego_id=' . $nego['id']) ?>" 
                           class="btn-nego-action btn-checkout-nego">
                            <i class="bi bi-cart-check"></i>
                            <span>Terima & Checkout</span>
                        </a>
                    <?php elseif ($nego['status'] == 'pending'): ?>
                        <span style="color: #94a3b8; font-size: 14px;">Menunggu respons penjual...</span>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Counter Modal -->
            <?php if ($nego['status'] == 'countered' && $nego['nego_count'] < 3): ?>
            <div class="modal fade modal-nego" id="counterModal<?= $nego['id'] ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Nego Lagi (<?= $nego['nego_count'] + 1 ?>/3)</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: brightness(0) invert(1);"></button>
                        </div>
                        <div class="modal-body" style="padding: 28px;">
                            <div class="nego-price-display">
                                <div class="nego-price-row">
                                    <span class="nego-price-label">Tawaran Penjual</span>
                                    <span class="nego-price-value">Rp <?= number_format($nego['counter_price'], 0, ',', '.') ?></span>
                                </div>
                            </div>
                            
                            <div class="form-group-custom" style="margin-bottom: 20px;">
                                <label class="form-label-custom">Tawaran Baru Anda</label>
                                <input type="number" id="newOffer<?= $nego['id'] ?>" class="nego-offer-input" 
                                       placeholder="Masukkan tawaran baru" 
                                       max="<?= $nego['counter_price'] - 1000 ?>">
                            </div>
                            
                            <div class="form-group-custom">
                                <label class="form-label-custom">Pesan (Opsional)</label>
                                <textarea id="newMessage<?= $nego['id'] ?>" class="form-control-custom" rows="3" 
                                          placeholder="Sampaikan pesan Anda..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer-custom">
                            <button type="button" class="btn-modal btn-secondary-custom" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn-modal btn-primary-custom" 
                                    onclick="submitCounterOffer(<?= $nego['id'] ?>)">Kirim Tawaran</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
function submitCounterOffer(negoId) {
    const newOffer = document.getElementById('newOffer' + negoId).value;
    const message = document.getElementById('newMessage' + negoId).value;
    
    if (!newOffer || newOffer <= 0) {
        alert('Tawaran baru harus diisi!');
        return;
    }
    
    fetch('<?= base_url("negotiation/counter-offer") ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            nego_id: negoId,
            new_offer: newOffer,
            message: message
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
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