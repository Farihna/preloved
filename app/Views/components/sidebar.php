<style>
    .sidebar-admin {
        position: fixed;
        left: 0;
        top: 0;
        width: 280px;
        height: 100vh;
        background: #1e293b;
        padding: 24px 0;
        z-index: 1000;
        overflow-y: auto;
        transition: all 0.3s ease;
    }
    
    .sidebar-logo {
        padding: 0 24px 24px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        margin-bottom: 24px;
    }
    
    .sidebar-logo img {
        height: 36px;
        filter: brightness(0) invert(1);
    }
    
    .sidebar-nav {
        padding: 0 16px;
    }
    
    .nav-section-title {
        padding: 16px 16px 8px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
    }
    
    .nav-item-admin {
        margin-bottom: 4px;
    }
    
    .nav-link-admin {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        color: #cbd5e1;
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.3s ease;
        font-size: 15px;
        font-weight: 500;
    }
    
    .nav-link-admin:hover {
        background: rgba(255, 255, 255, 0.05);
        color: white;
    }
    
    .nav-link-admin.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
    
    .nav-link-admin i {
        font-size: 20px;
        width: 24px;
        text-align: center;
    }
    
    .sidebar-toggle-mobile {
        display: none;
        position: fixed;
        bottom: 24px;
        right: 24px;
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 50%;
        color: white;
        font-size: 24px;
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
        cursor: pointer;
        z-index: 999;
    }
    
    @media (max-width: 768px) {
        .sidebar-admin {
            transform: translateX(-100%);
        }
        
        .sidebar-admin.show {
            transform: translateX(0);
        }
        
        .sidebar-toggle-mobile {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    }
</style>

<aside class="sidebar-admin" id="sidebarAdmin">
    <div class="sidebar-logo">
        <img src="<?= base_url('img/logo_preloved_light.png')?>" alt="Preloved">
    </div>
    
    <nav class="sidebar-nav">
        <div class="nav-section-title">Main</div>
        
        <div class="nav-item-admin">
            <a href="dashboard" class="nav-link-admin <?= (uri_string() == 'dashboard') ? 'active' : '' ?>">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </div>
        
        <div class="nav-section-title">Management</div>
        
        <div class="nav-item-admin">
            <a href="produk" class="nav-link-admin <?= (uri_string() == 'produk') ? 'active' : '' ?>">
                <i class="bi bi-box-seam"></i>
                <span>Products</span>
            </a>
        </div>
        
        <div class="nav-item-admin">
            <a href="manage_user" class="nav-link-admin <?= (uri_string() == 'manage_user') ? 'active' : '' ?>">
                <i class="bi bi-people"></i>
                <span>Users</span>
            </a>
        </div>
    </nav>
</aside>

<button class="sidebar-toggle-mobile" id="sidebarToggle">
    <i class="bi bi-list"></i>
</button>

<script>
    const sidebar = document.getElementById('sidebarAdmin');
    const toggleBtn = document.getElementById('sidebarToggle');
    
    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('show');
    });
    
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 768 && 
            !sidebar.contains(e.target) && 
            !toggleBtn.contains(e.target)) {
            sidebar.classList.remove('show');
        }
    });
</script>