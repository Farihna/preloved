<?= $this->extend('layout_user') ?>
<?= $this->section('content') ?>

<style>
    .requests-badge {
        display: inline-block;
        padding: 6px 14px;
        background: #ef4444;
        color: white;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        margin-left: 12px;
    }
    
    .buyer-info-section {
        background: #f8fafc;
        padding: 16px;
        border-radius: 12px;
        margin-bottom: 16px;
    }
    
    .buyer-info-header {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .buyer-detail {
        font-size: 14px;
        color: #64748b;
        line-height: 1.8;
    }
    
    .action-group {
        display: flex;
        gap: 12px;
    }
    
    .btn-accept {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
    }
    
    .btn-accept:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        color: white;
    }
    
    .btn-counter {
        background: white;
        color: #3b82f6;
        border: 2px solid #3b82f6;
    }
    
    .btn-counter:hover {
        background: #3b82f6;
        color: white;
    }
    
    .btn-reject {
        background: white;
        color: #ef4444;
        border: 2px solid #ef4444;
    }
    
    .btn-reject:hover {
        background: #ef4444;
        color: white;
    }
</style>

<div class="offers-container">
    <div class="page-header-orders">
        <h1>
            Request Nego
            <?php if ($pendingCount > 0): ?>
            <span class="requests-badge"><?= $pendingCount ?> Baru</span>
            <?php endif; ?>
        </h1>
        <p>Kelola tawaran harga dari pembeli</p>
    </div>
    
    <!-- Tabs -->
    <div class="tabs-container">
        <a href="<?= base_url('negotiation/requests') ?>" 
           class="tab-btn <?= $activeTab == 'all' ? 'active' : '' ?>">
            Semua
        </a>
        <a href="<?= base_url('negotiation/requests?status=pending') ?>" 
           class="tab-btn <?= $activeTab == 'pending' ? 'active' : '' ?>">
            Menunggu Respons <?= $pendingCount > 0 ? "($pendingCount)" : '' ?>
        </a>
        <a href="<?= base_url('negotiation/requests?status=accepted') ?>" 
           class="tab-btn <?= $activeTab == 'accepted' ? 'active' : '' ?>">
            Diterima
        </a>
        <a href="<?= base_url('negotiation/requests?status=countered') ?>" 
           class="tab-btn <?= $activeTab == 'countered' ? 'active' : '' ?>">
            Ditawar Balik
        </a>
        <a href="<?= base_url('negotiation/requests?status=rejected') ?>" 
           class="tab-btn <?= $activeTab == 'rejected' ? 'active' : '' ?>">
            Ditolak
        </a>
    </div>
    
    <!-- Negotiations List -->
    <?php if (empty($negotiations)): ?>
        <div class="empty-state">
            <i class="bi bi-chat-left-dots"></i>
            <h3>Belum Ada Request</h3>
            <p>Belum ada tawaran harga dari pembeli</p>
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
                            'pending' => '⏳ Menunggu Respons Anda',
                            'accepted' => '✓ Anda Terima',
                            'countered' => '↔️ Anda Tawar Balik',
                            'rejected' => '✗ Anda Tolak'
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
                        
                        <!-- Buyer Info -->
                        <div class="buyer-info-section">
                            <div class="buyer-info-header">
                                <i class="bi bi-person-circle"></i>
                                <span>Informasi Pembeli</span>
                            </div>
                            <div class="buyer-detail">
                                <strong><?= esc($nego['buyer_name']) ?></strong><br>
                                <i class="bi bi-telephone"></i> <?= esc($nego['buyer_phone']) ?>
                            </div>
                        </div>
                        
                        <!-- Prices -->
                        <div class="nego-prices">
                            <div class="price-item">
                                <span class="price-label">Harga Produk Anda</span>
                                <span class="price-value">Rp <?= number_format($nego['original_price'], 0, ',', '.') ?></span>
                            </div>
                            
                            <div class="price-item">
                                <span class="price-label">Tawaran Pembeli</span>
                                <span class="price-value highlight">Rp <?= number_format($nego['offer_price'], 0, ',', '.') ?></span>
                            </div>
                            
                            <?php if ($nego['counter_price']): ?>
                            <div class="price-item">
                                <span class="price-label">Tawaran Anda</span>
                                <span class="price-value success">Rp <?= number_format($nego['counter_price'], 0, ',', '.') ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <div class="price-item">
                                <span class="price-label">Selisih</span>
                                <span class="price-value" style="color: #ef4444;">
                                    - Rp <?= number_format($nego['original_price'] - $nego['offer_price'], 0, ',', '.') ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Messages -->
                <?php if ($nego['buyer_message']): ?>
                <div class="nego-messages">
                    <div class="message-label">📝 Pesan Pembeli:</div>
                    <div class="message-text"><?= nl2br(esc($nego['buyer_message'])) ?></div>
                </div>
                <?php endif; ?>
                
                <?php if ($nego['seller_message']): ?>
                <div class="nego-messages <?= $nego['status'] ?>">
                    <div class="message-label">💬 Balasan Anda:</div>
                    <div class="message-text"><?= nl2br(esc($nego['seller_message'])) ?></div>
                </div>
                <?php endif; ?>
                
                <!-- Footer Actions -->
                <div class="nego-footer">
                    <?php if ($nego['status'] == 'pending'): ?>
                        <div class="action-group" style="width: 100%; justify-content: flex-end;">
                            <!-- Accept -->
                            <form action="<?= base_url('negotiation/accept/' . $nego['id']) ?>" method="post" style="display: inline;">
                                <?= csrf_field() ?>
                                <input type="hidden" name="message" value="Tawaran Anda diterima! Silakan lakukan checkout.">
                                <button type="submit" class="btn-nego-action btn-accept" 
                                        onclick="return confirm('Terima tawaran Rp <?= number_format($nego['offer_price'], 0, ',', '.') ?>?')">
                                    <i class="bi bi-check-circle"></i>
                                    <span>Terima</span>
                                </button>
                            </form>
                            
                            <!-- Counter -->
                            <button class="btn-nego-action btn-counter" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#counterSellerModal<?= $nego['id'] ?>">
                                <i class="bi bi-arrow-repeat"></i>
                                <span>Tawar Balik</span>
                            </button>
                            
                            <!-- Reject -->
                            <button class="btn-nego-action btn-reject" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#rejectModal<?= $nego['id'] ?>">
                                <i class="bi bi-x-circle"></i>
                                <span>Tolak</span>
                            </button>
                        </div>
                    <?php else: ?>
                        <span style="color: #94a3b8; font-size: 14px;">
                            <?php
                            if ($nego['status'] == 'accepted') echo 'Menunggu pembeli checkout...';
                            elseif ($nego['status'] == 'countered') echo 'Menunggu respons pembeli...';
                            elseif ($nego['status'] == 'rejected') echo 'Nego telah ditolak';
                            ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Counter Modal (Seller) -->
            <div class="modal fade modal-nego" id="counterSellerModal<?= $nego['id'] ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tawar Balik Pembeli</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: brightness(0) invert(1);"></button>
                        </div>
                        <form action="<?= base_url('negotiation/counter/' . $nego['id']) ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="modal-body" style="padding: 28px;">
                                <div class="nego-price-display">
                                    <div class="nego-price-row">
                                        <span class="nego-price-label">Harga Asli</span>
                                        <span class="nego-price-value">Rp <?= number_format($nego['original_price'], 0, ',', '.') ?></span>
                                    </div>
                                    <div class="nego-price-row">
                                        <span class="nego-price-label">Tawaran Pembeli</span>
                                        <span class="nego-price-value">Rp <?= number_format($nego['offer_price'], 0, ',', '.') ?></span>
                                    </div>
                                </div>
                                
                                <div class="form-group-custom" style="margin-bottom: 20px;">
                                    <label class="form-label-custom">Harga Counter Anda</label>
                                    <input type="number" name="counter_price" class="nego-offer-input" 
                                           placeholder="Masukkan harga counter" 
                                           min="<?= $nego['offer_price'] + 1000 ?>"
                                           max="<?= $nego['original_price'] - 1000 ?>"
                                           required>
                                    <small style="color: #64748b; font-size: 13px; display: block; margin-top: 8px;">
                                        Harus lebih tinggi dari tawaran pembeli dan lebih rendah dari harga asli
                                    </small>
                                </div>
                                
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Pesan untuk Pembeli</label>
                                    <textarea name="message" class="form-control-custom" rows="3" 
                                              placeholder="Sampaikan alasan counter harga..."></textarea>
                                </div>
                            </div>
                            <div class="modal-footer-custom">
                                <button type="button" class="btn-modal btn-secondary-custom" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn-modal btn-primary-custom">Kirim Counter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Reject Modal -->
            <div class="modal fade modal-nego" id="rejectModal<?= $nego['id'] ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                            <h5 class="modal-title">Tolak Tawaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: brightness(0) invert(1);"></button>
                        </div>
                        <form action="<?= base_url('negotiation/reject/' . $nego['id']) ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="modal-body" style="padding: 28px;">
                                <p style="color: #64748b; margin-bottom: 20px;">
                                    Anda yakin ingin menolak tawaran ini? Pembeli tidak akan bisa melakukan checkout.
                                </p>
                                
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Alasan Penolakan (Opsional)</label>
                                    <textarea name="message" class="form-control-custom" rows="3" 
                                              placeholder="Sampaikan alasan penolakan..."></textarea>
                                </div>
                            </div>
                            <div class="modal-footer-custom">
                                <button type="button" class="btn-modal btn-secondary-custom" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn-modal" style="background: #ef4444; color: white;">Tolak Tawaran</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>