<?= $this->extend('layout_user') ?>
<?= $this->section('content') ?>

<div class="payment-container">
    <div class="payment-card">
        <div class="payment-header">
            <h1>Pembayaran</h1>
            <p>Order #<?= $transaction['transaction_code'] ?></p>
        </div>
        
        <div class="payment-summary">
            <div class="summary-item">
                <img src="<?= base_url('img/' . $transaction['product_photo']) ?>" 
                     alt="<?= $transaction['product_name'] ?>" 
                     class="product-thumb-payment">
                <div class="product-info-payment">
                    <h3><?= esc($transaction['product_name']) ?></h3>
                    <p>Rp <?= number_format($transaction['product_price'], 0, ',', '.') ?></p>
                </div>
            </div>
            
            <div class="payment-details">
                <div class="detail-row">
                    <span>Harga Produk</span>
                    <span>Rp <?= number_format($transaction['product_price'], 0, ',', '.') ?></span>
                </div>
                <div class="detail-row">
                    <span>Ongkos Kirim (<?= $transaction['courier_name'] ?>)</span>
                    <span>Rp <?= number_format($transaction['shipping_cost'], 0, ',', '.') ?></span>
                </div>
                <div class="detail-row total">
                    <span>Total Pembayaran</span>
                    <span>Rp <?= number_format($transaction['total_amount'], 0, ',', '.') ?></span>
                </div>
            </div>
        </div>
        
        <div class="payment-method-section">
            <h2>Pilih Metode Pembayaran</h2>
            
            <button class="btn-payment-midtrans" id="btnPayMidtrans">
                <i class="bi bi-credit-card"></i>
                <div>
                    <div class="payment-method-title">Bayar dengan Midtrans</div>
                    <div class="payment-method-desc">Kartu Kredit, Virtual Account, E-Wallet, QRIS</div>
                </div>
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
        
        <div class="payment-info">
            <i class="bi bi-shield-check"></i>
            <p>Pembayaran Anda aman dan terenkripsi</p>
        </div>
    </div>
</div>

<div class="loading-overlay" id="loadingOverlay" style="display: none;">
    <div class="loading-spinner">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p style="margin-top: 16px; color: #fff;">Memproses pembayaran...</p>
    </div>
</div>

<script type="text/javascript" 
        src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="<?= \App\Libraries\MidtransConfig::get()->clientKey ?>">
</script>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const transactionId = <?= $transaction['id'] ?>;
        const btnPay = document.getElementById('btnPayMidtrans');
        const loadingOverlay = document.getElementById('loadingOverlay');
        
        // Check if snap is loaded
        if (typeof snap === 'undefined') {
            console.error('Midtrans Snap.js not loaded!');
            alert('Gagal memuat sistem pembayaran. Silakan refresh halaman.');
            return;
        }
        
        btnPay.addEventListener('click', function() {
            loadingOverlay.style.display = 'flex';
            
            // Create Snap Token
            fetch('<?= base_url("payment/create-snap-token") ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    transaction_id: transactionId
                })
            })
            .then(response => response.json())
            .then(data => {
                loadingOverlay.style.display = 'none';
                
                console.log('Snap Token Response:', data);
                
                if (data.success && data.snap_token) {
                    // Open Midtrans Snap
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            console.log('Payment success:', result);
                            window.location.href = '<?= base_url("payment/finish") ?>?order_id=' + data.order_id + '&status_code=200&transaction_status=settlement';
                        },
                        onPending: function(result) {
                            console.log('Payment pending:', result);
                            window.location.href = '<?= base_url("payment/finish") ?>?order_id=' + data.order_id + '&status_code=201&transaction_status=pending';
                        },
                        onError: function(result) {
                            console.log('Payment error:', result);
                            alert('Pembayaran gagal: ' + (result.status_message || 'Terjadi kesalahan'));
                            window.location.href = '<?= base_url("payment/error") ?>?order_id=' + data.order_id;
                        },
                        onClose: function() {
                            console.log('Payment popup closed');
                            alert('Anda menutup halaman pembayaran sebelum menyelesaikan transaksi');
                            window.location.href = '<?= base_url("payment/unfinish") ?>?order_id=' + data.order_id;
                        }
                    });
                } else {
                    alert('Gagal memproses pembayaran: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                loadingOverlay.style.display = 'none';
                console.error('Error:', error);
                alert('Terjadi kesalahan koneksi. Silakan coba lagi.');
            });
        });
    });
</script>

<style>
.payment-container {
    max-width: 600px;
    margin: 40px auto;
    padding: 0 20px;
}

.payment-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    overflow: hidden;
}

.payment-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 32px;
    text-align: center;
}

.payment-header h1 {
    margin: 0 0 8px 0;
    font-size: 28px;
    font-weight: 700;
}

.payment-header p {
    margin: 0;
    opacity: 0.9;
}

.payment-summary {
    padding: 24px;
}

.summary-item {
    display: flex;
    gap: 16px;
    align-items: center;
    padding-bottom: 24px;
    border-bottom: 2px solid #f1f5f9;
    margin-bottom: 24px;
}

.product-thumb-payment {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 12px;
}

.product-info-payment h3 {
    margin: 0 0 8px 0;
    font-size: 16px;
    font-weight: 600;
}

.product-info-payment p {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    color: #3b82f6;
}

.payment-details {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    color: #64748b;
}

.detail-row.total {
    padding-top: 12px;
    border-top: 2px solid #f1f5f9;
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
}

.payment-method-section {
    padding: 24px;
    background: #f8fafc;
}

.payment-method-section h2 {
    font-size: 16px;
    font-weight: 600;
    margin: 0 0 16px 0;
    color: #1e293b;
}

.btn-payment-midtrans {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px;
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-payment-midtrans:hover {
    border-color: #3b82f6;
    background: #eff6ff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
}

.btn-payment-midtrans > i:first-child {
    font-size: 32px;
    color: #3b82f6;
}

.payment-method-title {
    font-weight: 600;
    font-size: 16px;
    color: #1e293b;
    text-align: left;
}

.payment-method-desc {
    font-size: 13px;
    color: #64748b;
    text-align: left;
    margin-top: 4px;
}

.btn-payment-midtrans > i:last-child {
    margin-left: auto;
    color: #94a3b8;
}

.payment-info {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 20px;
    color: #64748b;
    font-size: 14px;
}

.payment-info i {
    color: #10b981;
    font-size: 20px;
}

.loading-spinner {
    text-align: center;
}
</style>

<?= $this->endSection() ?>