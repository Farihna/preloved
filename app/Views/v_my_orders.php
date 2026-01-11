<?= $this->extend('layout_user') ?>
<?= $this->section('content') ?>


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
                    <a href="<?= base_url('payment/page/' . $trx['id']) ?>" class="btn-order-action btn-pay">
                        <i class="bi bi-credit-card"></i>
                        <span>Bayar Sekarang</span>
                    </a>
                    <form action="<?= base_url('transaction/cancel/' . $trx['id']) ?>" method="post" style="display: inline;">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn-order-action btn-cancel"
                                onclick="return confirm('Yakin batalkan pesanan ini?')">
                            <i class="bi bi-x-circle"></i>
                            <span>Batalkan</span>
                        </button>
                    </form>
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