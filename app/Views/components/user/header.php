<style>
    .header-user {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 0;
        z-index: 1000;
        padding: 16px 0;
    }
    
    .header-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 32px;
    }
    
    .header-logo img {
        height: 40px;
        filter: brightness(0) invert(1);
    }
    
    .header-nav {
        display: flex;
        align-items: center;
        gap: 8px;
        flex: 1;
        max-width: 600px;
    }
    
    .nav-link {
        padding: 10px 20px;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
        font-size: 15px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .nav-link:hover {
        background: rgba(255, 255, 255, 0.15);
    }
    
    .nav-link.active {
        background: rgba(255, 255, 255, 0.25);
    }
    
    .header-actions {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    
    .user-profile-dropdown {
        position: relative;
    }
    
    .user-profile-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px 16px;
        background: rgba(255, 255, 255, 0.15);
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.3s ease;
        color: white;
    }
    
    .user-profile-btn:hover {
        background: rgba(255, 255, 255, 0.25);
        border-color: rgba(255, 255, 255, 0.5);
    }
    
    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid white;
    }
    
    .user-name {
        font-weight: 600;
        font-size: 14px;
    }
    
    .dropdown-menu-custom {
        position: absolute;
        top: calc(100% + 12px);
        right: 0;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        min-width: 220px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
    }
    
    .dropdown-menu-custom.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    
    .dropdown-header-custom {
        padding: 16px;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .dropdown-header-custom h6 {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 4px 0;
    }
    
    .dropdown-header-custom span {
        font-size: 13px;
        color: #64748b;
    }
    
    .dropdown-item-custom {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        color: #475569;
        text-decoration: none;
        transition: all 0.2s ease;
        font-size: 14px;
    }
    
    .dropdown-item-custom:hover {
        background: #f8fafc;
        color: #667eea;
    }
    
    .dropdown-item-custom i {
        font-size: 18px;
        width: 20px;
        text-align: center;
    }
    
    .dropdown-divider-custom {
        height: 1px;
        background: #e2e8f0;
        margin: 8px 0;
    }
    
    .mobile-menu-toggle {
        display: none;
        background: rgba(255, 255, 255, 0.15);
        border: none;
        color: white;
        font-size: 24px;
        padding: 8px 12px;
        border-radius: 8px;
        cursor: pointer;
    }
    
    @media (max-width: 768px) {
        .header-nav {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            flex-direction: column;
            padding: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 100%;
        }
        
        .header-nav.show {
            display: flex;
        }
        
        .nav-link {
            width: 100%;
            justify-content: flex-start;
        }
        
        .mobile-menu-toggle {
            display: block;
        }
        
        .user-name {
            display: none;
        }
    }
</style>

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
            <a href="produk" class="nav-link <?php echo (uri_string() == 'produk') ? 'active' : '' ?>">
                <i class="bi bi-box-seam-fill"></i>
                <span>My Products</span>
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
                    <a href="profile" class="dropdown-item-custom">
                        <i class="bi bi-person-circle"></i>
                        <span>My Profile</span>
                    </a>
                    <div class="dropdown-divider-custom"></div>
                    <a href="logout" class="dropdown-item-custom">
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