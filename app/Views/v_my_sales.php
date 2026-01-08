<?= $this->extend('layout_user') ?>
<?= $this->section('content') ?>

<style>
    .sales-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }
    
    .stat-card-sales {
        background: white;
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        text-align: center;
    }
    
    .stat-icon-sales {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 24px;
    }
    
    .stat-icon-sales.pending {
        background: #fef3c7;
        color: #f59e0b;
    }
    
    .stat-icon-sales.revenue {
        background: #d1fae5;
        color: #10b981;
    }
    
    .stat-icon-sales.completed {
        background: #dbeafe;
        color: #3b82f6;
    }
    
    .stat-value-sales {
        font-size: 28px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 4px;
    }
    
    .stat-label-sales {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
    }
    
    .buyer-info-card {
        background: #f8fafc;
        padding: 16px;
        border-radius: 12px;
        margin-top: 16px;
        border-left: 4px solid #667eea;
    }
    
    .buyer-info-title {
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .buyer-details {
        font-size: 14px;
        color: #475569;
        line-height: 1.8;
    }
    
    .buyer-details strong {
        color: #1e293b;
    }
    
    .shipping-address-box {
        background: white;
        border: 2px solid #e2e8f0;
        padding: 16px;
        border-radius: 12px;
        margin-top: 12px;
    }
    
    .address-label-box {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    
    .address-text {
        font-size: 14px;
        color: #1e293b;
        line-height: 1.6;
    }
    
    .action-required-badge {
        display: inline-block;
        padding: 6px 14px;
        background: #ef4444;
        color: white;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }
    
    .btn-confirm-payment {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
    }
    
    .btn-confirm-payment:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        color: white;
    }
    
    .btn-input-resi {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border: none;
    }
    
    .btn-input-resi:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        color: white;
    }
    
    .payment-proof-box {
        margin-top: 16px;
        text-align: center;
    }
    
    .payment-proof-img {
        max-width: 300px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .payment-proof-img:hover {
        transform: scale(1.05);
    }
</style>

<div class="orders-container">
    <div class="page-header-orders">
        <h1>
            Penjualan Saya
            <?php if ($newOrdersCount > 0): ?>
            <span class="requests-badge"><?= $newOrdersCount ?> Pesanan Baru</span>
            <?php endif; ?>
        </h1>
        <p>Kelola semua pesanan dari pembeli</p>
    </div>
    
    <!-- Sales Stats -->
    <div class="sales-stats">
        <div class="stat-card-sales">
            <div class="stat-icon-sales pending">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div class="stat-value-sales"><?= $newOrdersCount ?></div>
            <div class="stat-label-sales">Pesanan Baru</div>
        </div>
        
        <div class="stat-card-sales">
            <div class="stat-icon-sales revenue">
                <i class="bi bi-cash-stack"></i>
            </div>
            <div class="stat-value-sales">
                <?php
                $totalRevenue = 0;
                foreach ($transactions as $trx) {
                    if (in_array($trx['status'], ['paid', 'processed', 'shipped', 'completed'])) {
                        $totalRevenue += $trx['product_price'];
                    }
                }
                echo 'Rp ' . number_format($totalRevenue, 0, ',', '.');
                ?>
            </div>
            <div class="stat-label-sales">Total Pendapatan</div>
        </div>
        
        <div class="stat-card-sales">
            <div class="stat-icon-sales completed">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-value-sales">
                <?php
                $completedCount = 0;
                foreach ($transactions as $trx) {
                    if ($trx['status'] == 'completed') $completedCount++;
                }
                echo $completedCount;
                ?>
            </div>
            <div class="stat-label-sales">Transaksi Selesai</div>
        </div>
    </div>
    
    <!-- Tabs -->
    <div class="tabs-container">
        <a href="<?= base_url('transaction/my-sales') ?>" 
           class="tab-btn <?= $activeTab == 'all' ? 'active' : '' ?>">
            Semua
        </a>
        <a href="<?= base_url('transaction/my-sales?status=paid') ?>" 
           class="tab-btn <?= $activeTab == 'paid' ? 'active' : '' ?>">
            Perlu Konfirmasi <?= $newOrdersCount > 0 ? "($newOrdersCount)" : '' ?>
        </a>
        <a href="<?= base_url('transaction/my-sales?status=processed') ?>" 
           class="tab-btn <?= $activeTab == 'processed' ? 'active' : '' ?>">
            Perlu Dikirim
        </a>
        <a href="<?= base_url('transaction/my-sales?status=shipped') ?>" 
           class="tab-btn <?= $activeTab == 'shipped' ? 'active' : '' ?>">
            Dalam Pengiriman
        </a>
        <a href="<?= base_url('transaction/my-sales?status=completed') ?>" 
           class="tab-btn <?= $activeTab == 'completed' ? 'active' : '' ?>">
            Selesai
        </a>
    </div>
    
    <!-- Sales List -->
    <?php if (empty($transactions)): ?>
        <div class="empty-state">
            <i class="bi bi-shop"></i>
            <h3>Belum Ada Penjualan</h3>
            <p>Belum ada pesanan dari pembeli</p>
        </div>
    <?php else: ?>
        <div class="orders-list">
            <?php foreach ($transactions as $trx): ?>
            <div class="order-card">
                <!-- Header -->
                <div class="order-header">
                    <div>
                        <div class="order-code"><?= $trx['transaction_code'] ?></div>
                        <div class="order-date"><?= date('d M Y, H:i', strtotime($trx['created_at'])) ?></div>
                    </div>
                    <div style="text-align: right;">
                        <span class="status-badge status-<?= $trx['status'] ?>">
                            <?php
                            $statusLabels = [
                                'pending' => 'Belum Bayar',
                                'paid' => 'Menunggu Konfirmasi',
                                'processed' => 'Sedang Diproses',
                                'shipped' => 'Dalam Pengiriman',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan'
                            ];
                            echo $statusLabels[$trx['status']] ?? $trx['status'];
                            ?>
                        </span>
                        <?php if ($trx['status'] == 'paid'): ?>
                        <div style="margin-top: 8px;">
                            <span class="action-required-badge">⚠️ Perlu Tindakan</span>
                        </div>
                        <?php elseif ($trx['status'] == 'processed'): ?>
                        <div style="margin-top: 8px;">
                            <span class="action-required-badge" style="background: #3b82f6;">📦 Input Resi</span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Body -->
                <div class="order-body">
                    <img src="<?= base_url('img/' . $trx['product_photo']) ?>" 
                         alt="<?= $trx['product_name'] ?>" 
                         class="product-image-order">
                    
                    <div class="product-info-order">
                        <div class="product-name-order"><?= esc($trx['product_name']) ?></div>
                        
                        <div class="seller-info-order">
                            <i class="bi bi-box-seam"></i>
                            <span>Harga Produk: <strong>Rp <?= number_format($trx['product_price'], 0, ',', '.') ?></strong></span>
                        </div>
                        <div class="seller-info-order">
                            <i class="bi bi-truck"></i>
                            <span>Ongkir: Rp <?= number_format($trx['shipping_cost'], 0, ',', '.') ?> (<?= $trx['courier_name'] ?>)</span>
                        </div>
                        
                        <!-- Buyer Info -->
                        <div class="buyer-info-card">
                            <div class="buyer-info-title">
                                <i class="bi bi-person-circle"></i>
                                <span>Informasi Pembeli</span>
                            </div>
                            <div class="buyer-details">
                                <strong><?= esc($trx['buyer_name']) ?></strong><br>
                                <i class="bi bi-telephone"></i> <?= esc($trx['buyer_phone']) ?>
                            </div>
                            
                            <div class="shipping-address-box">
                                <div class="address-label-box">📍 Alamat Pengiriman</div>
                                <div class="address-text">
                                    <strong><?= esc($trx['shipping_name']) ?></strong><br>
                                    <?= esc($trx['shipping_phone']) ?><br>
                                    <?= esc($trx['shipping_address']) ?><br>
                                    <?= esc($trx['shipping_city_name']) ?>, <?= esc($trx['shipping_province']) ?> 
                                    <?= esc($trx['shipping_postal_code']) ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Payment Proof -->
                        <?php if ($trx['payment_proof'] && $trx['status'] == 'paid'): ?>
                        <div class="payment-proof-box">
                            <div class="address-label-box">💳 Bukti Pembayaran</div>
                            <img src="<?= base_url('img/payments/' . $trx['payment_proof']) ?>" 
                                 alt="Payment Proof" 
                                 class="payment-proof-img"
                                 onclick="window.open(this.src, '_blank')">
                        </div>
                        <?php endif; ?>
                        
                        <!-- Tracking Info -->
                        <?php if ($trx['tracking_number']): ?>
                        <div class="seller-info-order" style="margin-top: 12px; padding: 12px; background: #dbeafe; border-radius: 8px;">
                            <i class="bi bi-truck"></i>
                            <span>Resi: <strong><?= $trx['tracking_number'] ?></strong></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Amount -->
                <div class="order-amount">
                    <span class="total-label">Total yang Diterima</span>
                    <span class="total-value">Rp <?= number_format($trx['total_amount'], 0, ',', '.') ?></span>
                </div>
                
                <!-- Footer Actions -->
                <div class="order-footer">
                    <a href="<?= base_url('transaction/detail/' . $trx['id']) ?>" class="btn-order-action btn-detail">
                        <i class="bi bi-eye"></i>
                        <span>Detail</span>
                    </a>
                    
                    <?php if ($trx['status'] == 'paid'): ?>
                    <form action="<?= base_url('transaction/confirm-payment/' . $trx['id']) ?>" method="post" style="display: inline;">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn-order-action btn-confirm-payment"
                                onclick="return confirm('Konfirmasi pembayaran ini?')">
                            <i class="bi bi-check-circle"></i>
                            <span>Konfirmasi Pembayaran</span>
                        </button>
                    </form>
                    <?php elseif ($trx['status'] == 'processed'): ?>
                    <button class="btn-order-action btn-input-resi" 
                            data-bs-toggle="modal" 
                            data-bs-target="#resiModal<?= $trx['id'] ?>">
                        <i class="bi bi-box-seam"></i>
                        <span>Input Resi</span>
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Resi Modal -->
            <?php if ($trx['status'] == 'processed'): ?>
            <div class="modal fade modal-nego" id="resiModal<?= $trx['id'] ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Input Nomor Resi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: brightness(0) invert(1);"></button>
                        </div>
                        <div class="modal-body" style="padding: 28px;">
                            <div style="background: #f8fafc; padding: 16px; border-radius: 12px; margin-bottom: 20px;">
                                <div style="font-size: 13px; color: #64748b; margin-bottom: 4px;">Kurir</div>
                                <div style="font-size: 16px; font-weight: 700; color: #1e293b;">
                                    <?= $trx['courier_name'] ?> - <?= $trx['courier_service'] ?>
                                </div>
                            </div>
                            
                            <div class="form-group-custom">
                                <label class="form-label-custom">Nomor Resi</label>
                                <input type="text" id="trackingNumber<?= $trx['id'] ?>" class="form-control-custom" 
                                       placeholder="Masukkan nomor resi pengiriman" required>
                                <small style="color: #64748b; font-size: 13px; display: block; margin-top: 8px;">
                                    Pastikan nomor resi yang diinput sudah benar
                                </small>
                            </div>
                        </div>
                        <div class="modal-footer-custom">
                            <button type="button" class="btn-modal btn-secondary-custom" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn-modal btn-primary-custom" 
                                    onclick="submitResi(<?= $trx['id'] ?>)">Simpan Resi</button>
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
function submitResi(transactionId) {
    const trackingNumber = document.getElementById('trackingNumber' + transactionId).value;
    
    if (!trackingNumber) {
        alert('Nomor resi harus diisi!');
        return;
    }
    
    fetch('<?= base_url("transaction/input-resi") ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            transaction_id: transactionId,
            tracking_number: trackingNumber
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