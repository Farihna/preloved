<?= $this->extend('layout_user') ?>
<?= $this->section('content') ?>

<style>
    .orders-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .page-header-orders {
        margin-bottom: 32px;
    }
    
    .page-header-orders h1 {
        font-size: 32px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 8px;
    }
    
    .page-header-orders p {
        color: #64748b;
        font-size: 16px;
    }
    
    .tabs-container {
        background: white;
        border-radius: 16px;
        padding: 8px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        display: flex;
        gap: 8px;
        overflow-x: auto;
    }
    
    .tab-btn {
        padding: 12px 24px;
        background: none;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        color: #64748b;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
    }
    
    .tab-btn:hover {
        background: #f8fafc;
        color: #667eea;
    }
    
    .tab-btn.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .orders-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    
    .order-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .order-card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }
    
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 16px;
        border-bottom: 2px solid #f1f5f9;
        margin-bottom: 16px;
    }
    
    .order-code {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
    }
    
    .order-date {
        font-size: 13px;
        color: #64748b;
        margin-top: 4px;
    }
    
    .status-badge {
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
    }
    
    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }
    
    .status-paid {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .status-processed {
        background: #e0e7ff;
        color: #3730a3;
    }
    
    .status-shipped {
        background: #ddd6fe;
        color: #5b21b6;
    }
    
    .status-completed {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .order-body {
        display: flex;
        gap: 20px;
        margin-bottom: 16px;
    }
    
    .product-image-order {
        width: 100px;
        height: 100px;
        border-radius: 12px;
        object-fit: cover;
    }
    
    .product-info-order {
        flex: 1;
    }
    
    .product-name-order {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
    }
    
    .seller-info-order {
        font-size: 14px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 12px;
    }
    
    .order-amount {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .total-label {
        color: #64748b;
        font-size: 14px;
    }
    
    .total-value {
        font-size: 24px;
        font-weight: 800;
        color: #667eea;
    }
    
    .order-footer {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 16px;
        border-top: 2px solid #f1f5f9;
    }
    
    .btn-order-action {
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-detail {
        background: #f8fafc;
        color: #475569;
        border: 2px solid #e2e8f0;
    }
    
    .btn-detail:hover {
        background: #f1f5f9;
        color: #1e293b;
    }
    
    .btn-pay {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
    }
    
    .btn-pay:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        color: white;
    }
    
    .btn-cancel {
        background: white;
        color: #ef4444;
        border: 2px solid #ef4444;
    }
    
    .btn-cancel:hover {
        background: #ef4444;
        color: white;
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
        .order-body {
            flex-direction: column;
        }
        
        .order-footer {
            flex-direction: column;
        }
        
        .btn-order-action {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="orders-container">
    <div class="page-header-orders">
        <h1>Pesanan Saya</h1>
        <p>Kelola semua pesanan Anda di sini</p>
    </div>
    
    <!-- Tabs -->
    <div class="tabs-container">
        <a href="<?= base_url('transaction/my-orders') ?>" 
           class="tab-btn <?= $activeTab == 'all' ? 'active' : '' ?>">
            Semua
        </a>
        <a href="<?= base_url('transaction/my-orders?status=pending') ?>" 
           class="tab-btn <?= $activeTab == 'pending' ? 'active' : '' ?>">
            Belum Bayar
        </a>
        <a href="<?= base_url('transaction/my-orders?status=paid') ?>" 
           class="tab-btn <?= $activeTab == 'paid' ? 'active' : '' ?>">
            Menunggu Konfirmasi
        </a>
        <a href="<?= base_url('transaction/my-orders?status=processed') ?>" 
           class="tab-btn <?= $activeTab == 'processed' ? 'active' : '' ?>">
            Diproses
        </a>
        <a href="<?= base_url('transaction/my-orders?status=shipped') ?>" 
           class="tab-btn <?= $activeTab == 'shipped' ? 'active' : '' ?>">
            Dikirim
        </a>
        <a href="<?= base_url('transaction/my-orders?status=completed') ?>" 
           class="tab-btn <?= $activeTab == 'completed' ? 'active' : '' ?>">
            Selesai
        </a>
        <a href="<?= base_url('transaction/my-orders?status=cancelled') ?>" 
           class="tab-btn <?= $activeTab == 'cancelled' ? 'active' : '' ?>">
            Dibatalkan
        </a>
    </div>
    
    <!-- Orders List -->
    <?php if (empty($transactions)): ?>
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <h3>Belum Ada Pesanan</h3>
            <p>Yuk mulai belanja produk preloved favorit kamu!</p>
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
                </div>
                
                <!-- Body -->
                <div class="order-body">
                    <img src="<?= base_url('img/' . $trx['product_photo']) ?>" 
                         alt="<?= $trx['product_name'] ?>" 
                         class="product-image-order">
                    
                    <div class="product-info-order">
                        <div class="product-name-order"><?= esc($trx['product_name']) ?></div>
                        <div class="seller-info-order">
                            <i class="bi bi-shop"></i>
                            <span><?= esc($trx['seller_name']) ?></span>
                        </div>
                        <div class="seller-info-order">
                            <i class="bi bi-truck"></i>
                            <span><?= $trx['courier_name'] ?> - <?= $trx['courier_service'] ?></span>
                        </div>
                        <?php if ($trx['tracking_number']): ?>
                        <div class="seller-info-order">
                            <i class="bi bi-box-seam"></i>
                            <span>Resi: <strong><?= $trx['tracking_number'] ?></strong></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Amount -->
                <div class="order-amount">
                    <span class="total-label">Total Pembayaran</span>
                    <span class="total-value">Rp <?= number_format($trx['total_amount'], 0, ',', '.') ?></span>
                </div>
                
                <!-- Footer Actions -->
                <div class="order-footer">
                    <a href="<?= base_url('transaction/detail/' . $trx['id']) ?>" class="btn-order-action btn-detail">
                        <i class="bi bi-eye"></i>
                        <span>Detail</span>
                    </a>
                    
                    <?php if ($trx['status'] == 'pending'): ?>
                    <a href="<?= base_url('transaction/detail/' . $trx['id']) ?>" class="btn-order-action btn-pay">
                        <i class="bi bi-credit-card"></i>
                        <span>Bayar Sekarang</span>
                    </a>
                    <a href="<?= base_url('transaction/cancel/' . $trx['id']) ?>" 
                       class="btn-order-action btn-cancel"
                       onclick="return confirm('Yakin batalkan pesanan ini?')">
                        <i class="bi bi-x-circle"></i>
                        <span>Batalkan</span>
                    </a>
                    <?php elseif ($trx['status'] == 'shipped'): ?>
                    <a href="<?= base_url('transaction/complete/' . $trx['id']) ?>" 
                       class="btn-order-action btn-pay"
                       onclick="return confirm('Konfirmasi pesanan sudah diterima?')">
                        <i class="bi bi-check-circle"></i>
                        <span>Pesanan Diterima</span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>