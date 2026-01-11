<?= $this->extend('layout_user') ?>
<?= $this->section('content') ?>

<div class="wallet-container">
    <div class="wallet-header">
        <h1>Dompet Saya</h1>
        <div class="balance-card">
            <div class="balance-label">Saldo Tersedia</div>
            <div class="balance-amount">Rp <?= number_format($wallet['balance'], 0, ',', '.') ?></div>
        </div>
    </div>
    
    <div class="wallet-actions">
        <button class="btn-wallet-action" data-bs-toggle="modal" data-bs-target="#withdrawModal">
            <i class="bi bi-cash-stack"></i>
            <span>Tarik Saldo</span>
        </button>
    </div>
    
    <div class="wallet-history">
        <h2>Riwayat Transaksi</h2>
        
        <?php if (empty($history)): ?>
        <div class="empty-state">
            <i class="bi bi-wallet2"></i>
            <p>Belum ada riwayat transaksi</p>
        </div>
        <?php else: ?>
        <div class="history-list">
            <?php foreach ($history as $item): ?>
            <div class="history-item <?= $item['type'] ?>">
                <div class="history-icon">
                    <i class="bi <?= $item['type'] == 'credit' ? 'bi-arrow-down-circle' : 'bi-arrow-up-circle' ?>"></i>
                </div>
                <div class="history-info">
                    <div class="history-desc"><?= esc($item['description']) ?></div>
                    <div class="history-date"><?= date('d M Y, H:i', strtotime($item['created_at'])) ?></div>
                </div>
                <div class="history-amount <?= $item['type'] ?>">
                    <?= $item['type'] == 'credit' ? '+' : '-' ?> Rp <?= number_format($item['amount'], 0, ',', '.') ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Withdraw Modal -->
<div class="modal fade" id="withdrawModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tarik Saldo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Jumlah Penarikan</label>
                    <input type="number" class="form-control" id="withdrawAmount" placeholder="Masukkan jumlah">
                    <small class="text-muted">Saldo tersedia: Rp <?= number_format($wallet['balance'], 0, ',', '.') ?></small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Bank</label>
                    <select class="form-select" id="withdrawBank">
                        <option value="BCA">BCA</option>
                        <option value="BNI">BNI</option>
                        <option value="BRI">BRI</option>
                        <option value="Mandiri">Mandiri</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nomor Rekening</label>
                    <input type="text" class="form-control" id="withdrawAccount" placeholder="Nomor rekening">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitWithdraw()">Tarik Saldo</button>
            </div>
        </div>
    </div>
</div>

<style>
.wallet-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 24px;
}

.wallet-header {
    margin-bottom: 32px;
}

.balance-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 32px;
    border-radius: 16px;
    margin-top: 16px;
}

.balance-label {
    font-size: 14px;
    opacity: 0.9;
    margin-bottom: 8px;
}

.balance-amount {
    font-size: 36px;
    font-weight: 700;
}

.wallet-actions {
    display: flex;
    gap: 12px;
    margin-bottom: 32px;
}

.btn-wallet-action {
    flex: 1;
    padding: 16px;
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-wallet-action:hover {
    border-color: #3b82f6;
    background: #eff6ff;
}

.wallet-history h2 {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 16px;
}

.history-list {
    background: white;
    border-radius: 12px;
    overflow: hidden;
}

.history-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px;
    border-bottom: 1px solid #f1f5f9;
}

.history-item:last-child {
    border-bottom: none;
}

.history-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.history-item.credit .history-icon {
    background: #d1fae5;
    color: #10b981;
}

.history-item.debit .history-icon {
    background: #fee2e2;
    color: #ef4444;
}

.history-info {
    flex: 1;
}

.history-desc {
    font-weight: 600;
    margin-bottom: 4px;
}

.history-date {
    font-size: 13px;
    color: #64748b;
}

.history-amount {
    font-size: 18px;
    font-weight: 700;
}

.history-amount.credit {
    color: #10b981;
}

.history-amount.debit {
    color: #ef4444;
}
</style>

<?= $this->endSection() ?>