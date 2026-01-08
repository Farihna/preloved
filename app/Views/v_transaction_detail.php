<?= $this->extend('layout_user') ?>
<?= $this->section('content') ?>

<style>
    .detail-container {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .detail-header-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px;
        border-radius: 20px;
        margin-bottom: 32px;
        box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
    }
    
    .detail-header-section h1 {
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 8px;
    }
    
    .detail-header-section p {
        opacity: 0.9;
        font-size: 14px;
        margin: 0;
    }
    
    .status-timeline {
        background: white;
        padding: 32px;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
    }
    
    .timeline-item {
        display: flex;
        gap: 20px;
        position: relative;
        padding-bottom: 32px;
    }
    
    .timeline-item:last-child {
        padding-bottom: 0;
    }
    
    .timeline-item::after {
        content: '';
        position: absolute;
        left: 19px;
        top: 40px;
        bottom: 0;
        width: 2px;
        background: #e2e8f0;
    }
    
    .timeline-item:last-child::after {
        display: none;
    }
    
    .timeline-item.active::after {
        background: #667eea;
    }
    
    .timeline-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
        background: #f1f5f9;
        color: #94a3b8;
        border: 3px solid white;
        box-shadow: 0 0 0 2px #e2e8f0;
        position: relative;
        z-index: 1;
    }
    
    .timeline-item.active .timeline-icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 0 0 2px #667eea;
    }
    
    .timeline-content {
        flex: 1;
    }
    
    .timeline-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }
    
    .timeline-date {
        font-size: 13px;
        color: #64748b;
    }
    
    .detail-section {
        background: white;
        padding: 28px;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
    }
    
    .section-title-detail {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .section-title-detail i {
        color: #667eea;
        font-size: 24px;
    }
    
    .product-detail-box {
        display: flex;
        gap: 20px;
        padding: 20px;
        background: #f8fafc;
        border-radius: 12px;
    }
    
    .product-image-detail {
        width: 120px;
        height: 120px;
        border-radius: 12px;
        object-fit: cover;
    }
    
    .product-info-detail h4 {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 12px;
    }
    
    .product-meta-detail {
        font-size: 14px;
        color: #64748b;
        line-height: 1.8;
    }
    
    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-label {
        color: #64748b;
        font-size: 14px;
    }
    
    .info-value {
        font-weight: 600;
        color: #1e293b;
        text-align: right;
    }
    
    .info-row.total {
        border-top: 2px solid #e2e8f0;
        padding-top: 16px;
        margin-top: 8px;
    }
    
    .info-row.total .info-label {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
    }
    
    .info-row.total .info-value {
        font-size: 24px;
        font-weight: 800;
        color: #667eea;
    }
    
    .contact-box {
        display: flex;
        gap: 16px;
        padding: 16px;
        background: #f8fafc;
        border-radius: 12px;
        border-left: 4px solid #667eea;
    }
    
    .contact-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .contact-info h5 {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }
    
    .contact-info p {
        font-size: 14px;
        color: #64748b;
        margin: 0;
    }
    
    .upload-proof-box {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 32px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .upload-proof-box:hover {
        border-color: #667eea;
        background: #f8fafc;
    }
    
    .upload-proof-box i {
        font-size: 48px;
        color: #94a3b8;
        margin-bottom: 16px;
    }
    
    .upload-proof-box.has-file {
        border-color: #10b981;
        background: #d1fae5;
    }
    
    .action-buttons-detail {
        display: flex;
        gap: 12px;
        margin-top: 24px;
    }
    
    .btn-action-detail {
        flex: 1;
        padding: 16px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        border: none;
    }
    
    .btn-primary-detail {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .btn-primary-detail:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
        color: white;
    }
    
    .btn-success-detail {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    
    .btn-success-detail:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
        color: white;
    }
    
    .btn-danger-detail {
        background: white;
        color: #ef4444;
        border: 2px solid #ef4444;
    }
    
    .btn-danger-detail:hover {
        background: #ef4444;
        color: white;
    }
    
    @media (max-width: 768px) {
        .product-detail-box {
            flex-direction: column;
        }
        
        .action-buttons-detail {
            flex-direction: column;
        }
    }
</style>

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