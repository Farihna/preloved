<?= $this->extend('layout_admin') ?>
<?= $this->section('content') ?>

<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 2px solid transparent;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        border-color: #667eea;
    }
    
    .stat-card.products::before {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    
    .stat-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        font-size: 28px;
    }
    
    .stat-card.users .stat-icon {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        color: #667eea;
    }
    
    .stat-card.products .stat-icon {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.1) 100%);
        color: #10b981;
    }
    
    .stat-label {
        font-size: 14px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    
    .stat-value {
        font-size: 36px;
        font-weight: 800;
        color: #1e293b;
        line-height: 1;
    }
    
    .welcome-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 40px;
        color: white;
        margin-bottom: 32px;
        box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
    }
    
    .welcome-card h2 {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 12px;
    }
    
    .welcome-card p {
        font-size: 16px;
        opacity: 0.95;
        margin: 0;
    }
    
    .quick-actions {
        background: white;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }
    
    .quick-actions h3 {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
    }
    
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }
    
    .action-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 24px;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        color: #475569;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .action-btn:hover {
        background: #667eea;
        border-color: #667eea;
        color: white;
        transform: translateY(-2px);
    }
    
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .welcome-card {
            padding: 28px;
        }
        
        .welcome-card h2 {
            font-size: 24px;
        }
    }
</style>

<div class="welcome-card">
    <h2>Welcome back, <?= session()->get('username'); ?>! 👋</h2>
    <p>Here's what's happening with your platform today.</p>
</div>

<div class="stats-grid">
    <div class="stat-card users">
        <div class="stat-icon">
            <i class="bi bi-people-fill"></i>
        </div>
        <div class="stat-label">Total Users</div>
        <!-- usercount -->
    </div>
    
    <div class="stat-card products">
        <div class="stat-icon">
            <i class="bi bi-box-seam-fill"></i>
        </div>
        <div class="stat-label">Total Products</div>
        <!-- product count -->
    </div>
</div>

<div class="quick-actions">
    <h3>Quick Actions</h3>
    <div class="action-buttons">
        <a href="manage_user" class="action-btn">
            <i class="bi bi-people"></i>
            <span>Manage Users</span>
        </a>
        <a href="produk" class="action-btn">
            <i class="bi bi-box-seam"></i>
            <span>Manage Products</span>
        </a>
    </div>
</div>

<?= $this->endSection() ?>