<?= $this->extend('layout_user') ?>
<?= $this->section('content') ?>

<div class="detail-container">
    <!-- Header -->
    <div class="detail-header-section">
        <h1><?= $transaction['transaction_code'] ?></h1>
        <p>
            Dibuat pada <?= date('d F Y, H:i', strtotime($transaction['created_at'])) ?> WIB
        </p>
    </div>
    
    <!-- Status Timeline -->
    <div class="status-timeline">
        <div class="section-title-detail">
            <i class="bi bi-clock-history"></i>
            <span>Status Pesanan</span>
        </div>
        
        <?php
        $statuses = [
            'pending' => ['icon' => 'bi-cart-plus', 'title' => 'Pesanan Dibuat', 'active' => true],
            'paid' => ['icon' => 'bi-credit-card', 'title' => 'Pembayaran Diterima', 'active' => false],
            'processed' => ['icon' => 'bi-box-seam', 'title' => 'Pesanan Diproses', 'active' => false],
            'shipped' => ['icon' => 'bi-truck', 'title' => 'Pesanan Dikirim', 'active' => false],
            'completed' => ['icon' => 'bi-check-circle', 'title' => 'Pesanan Selesai', 'active' => false]
        ];
        
        $currentStatusReached = false;
        foreach ($statuses as $key => $status) {
            if ($transaction['status'] == $key) {
                $currentStatusReached = true;
                $status['active'] = true;
            } elseif ($currentStatusReached) {
                $status['active'] = false;
            } else {
                $status['active'] = true;
            }
            
            $activeClass = $status['active'] ? 'active' : '';
            ?>
            <div class="timeline-item <?= $activeClass ?>">
                <div class="timeline-icon">
                    <i class="bi <?= $status['icon'] ?>"></i>
                </div>
                <div class="timeline-content">
                    <div class="timeline-title"><?= $status['title'] ?></div>
                    <div class="timeline-date">
                        <?php
                        if ($key == 'pending') echo date('d M Y, H:i', strtotime($transaction['created_at']));
                        elseif ($key == 'paid' && $transaction['payment_date']) echo date('d M Y, H:i', strtotime($transaction['payment_date']));
                        elseif ($key == 'completed' && $transaction['completed_at']) echo date('d M Y, H:i', strtotime($transaction['completed_at']));
                        elseif ($status['active']) echo date('d M Y, H:i', strtotime($transaction['updated_at']));
                        else echo '-';
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    
    <!-- Product Info -->
    <div class="detail-section">
        <div class="section-title-detail">
            <i class="bi bi-box-seam"></i>
            <span>Detail Produk</span>
        </div>
        
        <div class="product-detail-box">
            <img src="<?= base_url('img/' . $transaction['product_photo']) ?>" 
                 alt="<?= $transaction['product_name'] ?>" 
                 class="product-image-detail">
            
            <div class="product-info-detail">
                <h4><?= esc($transaction['product_name']) ?></h4>
                <div class="product-meta-detail">
                    <?= nl2br(esc($transaction['product_desc'])) ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Shipping Info -->
    <div class="detail-section">
        <div class="section-title-detail">
            <i class="bi bi-truck"></i>
            <span>Informasi Pengiriman</span>
        </div>
        
        <div class="info-row">
            <span class="info-label">Penerima</span>
            <span class="info-value"><?= esc($transaction['shipping_name']) ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">No. Telepon</span>
            <span class="info-value"><?= esc($transaction['shipping_phone']) ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Alamat</span>
            <span class="info-value" style="max-width: 60%;">
                <?= esc($transaction['shipping_address']) ?>,<br>
                <?= esc($transaction['shipping_city_name']) ?>, <?= esc($transaction['shipping_province']) ?> 
                <?= esc($transaction['shipping_postal_code']) ?>
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Kurir</span>
            <span class="info-value"><?= $transaction['courier_name'] ?> - <?= $transaction['courier_service'] ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Estimasi</span>
            <span class="info-value"><?= $transaction['estimated_delivery'] ?></span>
        </div>
        <?php if ($transaction['tracking_number']): ?>
        <div class="info-row">
            <span class="info-label">No. Resi</span>
            <span class="info-value" style="color: #667eea; font-weight: 700;">
                <?= $transaction['tracking_number'] ?>
            </span>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Payment Summary -->
    <div class="detail-section">
        <div class="section-title-detail">
            <i class="bi bi-receipt"></i>
            <span>Rincian Pembayaran</span>
        </div>
        
        <div class="info-row">
            <span class="info-label">Harga Produk</span>
            <span class="info-value">Rp <?= number_format($transaction['product_price'], 0, ',', '.') ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Ongkos Kirim</span>
            <span class="info-value">Rp <?= number_format($transaction['shipping_cost'], 0, ',', '.') ?></span>
        </div>
        <div class="info-row total">
            <span class="info-label">Total Pembayaran</span>
            <span class="info-value">Rp <?= number_format($transaction['total_amount'], 0, ',', '.') ?></span>
        </div>
    </div>
    
    <!-- Contact Info -->
    <div class="detail-section">
        <div class="section-title-detail">
            <i class="bi bi-person-circle"></i>
            <span><?= $isBuyer ? 'Informasi Penjual' : 'Informasi Pembeli' ?></span>
        </div>
        
        <div class="contact-box">
            <img src="<?= base_url('img/no_profile.jpg') ?>" alt="Profile" class="contact-avatar">
            <div class="contact-info">
                <h5><?= $isBuyer ? esc($transaction['seller_name']) : esc($transaction['buyer_name']) ?></h5>
                <p>
                    <i class="bi bi-envelope"></i> 
                    <?= $isBuyer ? esc($transaction['seller_email']) : esc($transaction['buyer_email']) ?>
                </p>
                <?php if (!$isBuyer): ?>
                <p>
                    <i class="bi bi-telephone"></i> 
                    <?= esc($transaction['buyer_phone']) ?>
                </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Payment Proof (for buyer - pending status) -->
    <?php if ($isBuyer && $transaction['status'] == 'pending'): ?>
    <div class="detail-section">
        <div class="section-title-detail">
            <i class="bi bi-credit-card"></i>
            <span>Upload Bukti Pembayaran</span>
        </div>
        
        <form id="uploadProofForm" enctype="multipart/form-data">
            <input type="hidden" name="transaction_id" value="<?= $transaction['id'] ?>">
            <label for="paymentProof" class="upload-proof-box" id="uploadBox">
                <i class="bi bi-cloud-upload"></i>
                <div>
                    <strong>Klik untuk upload bukti transfer</strong><br>
                    <small style="color: #94a3b8;">Format: JPG, PNG (Max 2MB)</small>
                </div>
                <input type="file" id="paymentProof" name="payment_proof" accept="image/*" style="display: none;" onchange="previewFile(this)">
            </label>
            <div id="uploadPreview" style="display: none; margin-top: 16px; text-align: center;">
                <img id="previewImage" style="max-width: 300px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            </div>
        </form>
        
        <div class="action-buttons-detail">
            <button type="button" class="btn-action-detail btn-primary-detail" onclick="submitPaymentProof()">
                <i class="bi bi-check-circle"></i>
                <span>Konfirmasi Pembayaran</span>
            </button>
            <a href="<?= base_url('transaction/cancel/' . $transaction['id']) ?>" 
               class="btn-action-detail btn-danger-detail"
               onclick="return confirm('Yakin batalkan pesanan?')">
                <i class="bi bi-x-circle"></i>
                <span>Batalkan Pesanan</span>
            </a>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- View Payment Proof (for seller) -->
    <?php if (!$isBuyer && $transaction['payment_proof']): ?>
    <div class="detail-section">
        <div class="section-title-detail">
            <i class="bi bi-credit-card"></i>
            <span>Bukti Pembayaran</span>
        </div>
        
        <div style="text-align: center;">
            <img src="<?= base_url('img/payments/' . $transaction['payment_proof']) ?>" 
                 alt="Payment Proof" 
                 style="max-width: 400px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); cursor: pointer;"
                 onclick="window.open(this.src, '_blank')">
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Action Buttons -->
    <?php if ($isBuyer && $transaction['status'] == 'shipped'): ?>
    <div class="action-buttons-detail">
        <a href="<?= base_url('transaction/complete/' . $transaction['id']) ?>" 
           class="btn-action-detail btn-success-detail"
           onclick="return confirm('Konfirmasi pesanan sudah diterima?')">
            <i class="bi bi-check-circle"></i>
            <span>Pesanan Diterima</span>
        </a>
    </div>
    <?php endif; ?>
</div>

<script>
function previewFile(input) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImage').src = e.target.result;
            document.getElementById('uploadPreview').style.display = 'block';
            document.getElementById('uploadBox').classList.add('has-file');
        }
        reader.readAsDataURL(file);
    }
}

function submitPaymentProof() {
    const form = document.getElementById('uploadProofForm');
    const formData = new FormData(form);
    
    const fileInput = document.getElementById('paymentProof');
    if (!fileInput.files[0]) {
        alert('Silakan pilih file bukti pembayaran terlebih dahulu');
        return;
    }
    
    document.getElementById('loadingOverlay').style.display = 'flex';
    
    fetch('<?= base_url("transaction/payment-proof") ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('loadingOverlay').style.display = 'none';
        
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        document.getElementById('loadingOverlay').style.display = 'none';
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
}
</script>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay" style="display: none;">
    <div class="loading-spinner">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p style="margin-top: 16px; color: #64748b;">Sedang memproses...</p>
    </div>
</div>

<?= $this->endSection() ?>