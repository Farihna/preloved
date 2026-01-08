<header class="header-user">
    <div class="header-container">
        <a href="/" class="header-logo">
            <img src="<?= base_url('img/logo_preloved_light.png')?>" alt="Preloved">
        </a>
        
        <button class="mobile-menu-toggle" id="mobileMenuToggle">
            <i class="bi bi-list"></i>
        </button>
        
        <nav class="header-nav" id="headerNav">
            <a href="/" class="nav-link <?php echo (uri_string() == '') ? 'active' : '' ?>">
                <i class="bi bi-house-door-fill"></i>
                <span>Home</span>
            </a>
            <a href="<?= base_url('produk') ?>" class="nav-link <?= (uri_string() == 'produk') ? 'active' : '' ?>">
                <i class="bi bi-box-seam-fill"></i>
                <span>Produk</span>
            </a>

            <a href="<?= base_url('transaction/my-orders') ?>" 
            class="nav-link <?= (uri_string() == 'transaction/my-orders') ? 'active' : '' ?>">
                <i class="bi bi-cart-check"></i>
                <span>Pesanan</span>
            </a>

            <a href="<?= base_url('transaction/my-sales') ?>" 
            class="nav-link <?= (uri_string() == 'transaction/my-sales') ? 'active' : '' ?>">
                <i class="bi bi-cash-stack"></i>
                <span>Penjualan</span>
            </a>
            <a href="<?= base_url('negotiation/my-offers') ?>" 
            class="nav-link <?= (uri_string() == 'negotiation/my-offers') ? 'active' : '' ?>">
                <i class="bi bi-tag"></i>
                <span>Tawaran</span>
            </a>

            <a href="<?= base_url('negotiation/requests') ?>" 
            class="nav-link <?= (uri_string() == 'negotiation/requests') ? 'active' : '' ?>">
                <i class="bi bi-chat-dots"></i>
                <span>Nego</span>
            </a>
        </nav>
        
        <div class="header-actions">
            <div class="user-profile-dropdown">
                <div class="user-profile-btn" id="userProfileBtn">
                    <img src="<?= base_url('img/' . (session()->get('img_profile') ?? 'no_profile.jpg')) ?>" 
                         alt="Profile" class="user-avatar">
                    <span class="user-name"><?= session()->get('username'); ?></span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                
                <div class="dropdown-menu-custom" id="dropdownMenu">
                    <div class="dropdown-header-custom">
                        <h6><?= session()->get('username'); ?></h6>
                        <span>User Account</span>
                    </div>
                    <a href="<?= base_url('profile') ?>" class="dropdown-item-custom">
                        <i class="bi bi-person-circle"></i>
                        <span>My Profile</span>
                    </a>
                    <div class="dropdown-divider-custom"></div>
                    <a href="<?= base_url('logout') ?>" class="dropdown-item-custom">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Sign Out</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    // User dropdown toggle
    const userBtn = document.getElementById('userProfileBtn');
    const dropdown = document.getElementById('dropdownMenu');
    
    userBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdown.classList.toggle('show');
    });
    
    document.addEventListener('click', (e) => {
        if (!userBtn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.remove('show');
        }
    });
    
    // Mobile menu toggle
    const mobileToggle = document.getElementById('mobileMenuToggle');
    const headerNav = document.getElementById('headerNav');
    
    mobileToggle.addEventListener('click', () => {
        headerNav.classList.toggle('show');
    });
</script>