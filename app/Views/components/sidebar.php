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