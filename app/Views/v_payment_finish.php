<?= $this->extend('layout_user') ?>
<?= $this->section('content') ?>

<div class="payment-result-container">
    <div class="payment-result-card">
        <div class="result-icon success">
            <i class="bi bi-check-circle"></i>
        </div>
        
        <h1>Pembayaran Sedang Diproses</h1>
        <p>Terima kasih! Pembayaran Anda sedang kami verifikasi.</p>
        
        <?php if (isset($transaction)): ?>
        <div class="order-info-box">
            <div class="info-row">
                <span>Order ID</span>
                <strong><?= $transaction['transaction_code'] ?></strong>
            </div>
            <div class="info-row">
                <span>Total</span>
                <strong>Rp <?= number_format($transaction['total_amount'], 0, ',', '.') ?></strong>
            </div>
            <?php if (isset($payment) && $payment['payment_channel']): ?>
            <div class="info-row">
                <span>Metode Pembayaran</span>
                <strong><?= $payment['payment_channel'] ?></strong>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="action-buttons">
            <a href="<?= base_url('transaction/detail/' . $transaction['id']) ?>" class="btn-primary-result">
                Lihat Detail Pesanan
            </a>
            <a href="<?= base_url('transaction/my-orders') ?>" class="btn-secondary-result">
                Lihat Semua Pesanan
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.payment-result-container {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.payment-result-card {
    max-width: 500px;
    width: 100%;
    background: white;
    border-radius: 16px;
    padding: 48px 32px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.result-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
}

.result-icon.success {
    background: #d1fae5;
    color: #10b981;
}

.payment-result-card h1 {
    font-size: 24px;
    font-weight: 700;
    margin: 0 0 12px 0;
    color: #1e293b;
}

.payment-result-card > p {
    color: #64748b;
    margin: 0 0 32px 0;
}

.order-info-box {
    background: #f8fafc;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 32px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #e2e8f0;
}

.info-row:last-child {
    border-bottom: none;
}

.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.btn-primary-result, .btn-secondary-result {
    padding: 14px 24px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-primary-result {
    background: #3b82f6;
    color: white;
}

.btn-primary-result:hover {
    background: #2563eb;
    transform: translateY(-2px);
}

.btn-secondary-result {
    background: #f1f5f9;
    color: #475569;
}

.btn-secondary-result:hover {
    background: #e2e8f0;
}
</style>

<?= $this->endSection() ?>