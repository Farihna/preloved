<?= $this->extend('/auth/layout_clear') ?>
<?= $this->section('content') ?>

<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
    
    .login-container {
        width: 100%;
        max-width: 440px;
        padding: 20px;
    }
    
    .login-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }
    
    .login-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 40px 30px;
        text-align: center;
        color: white;
    }
    
    .login-header img {
        max-width: 200px;
        margin-bottom: 16px;
        filter: brightness(0) invert(1);
    }
    
    .login-header h5 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    
    .login-header p {
        font-size: 14px;
        opacity: 0.9;
        margin: 0;
    }
    
    .login-body {
        padding: 40px 30px;
    }
    
    .form-group {
        margin-bottom: 24px;
    }
    
    .form-label {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 8px;
        font-size: 14px;
        display: block;
    }
    
    .input-group-custom {
        position: relative;
    }
    
    .input-group-custom .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 18px;
        z-index: 10;
    }
    
    .form-control-custom {
        width: 100%;
        padding: 14px 16px 14px 48px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #f8fafc;
    }
    
    .form-control-custom:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }
    
    .btn-login {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 12px;
        color: white;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 8px;
    }
    
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    }
    
    .divider {
        text-align: center;
        margin: 24px 0;
        position: relative;
    }
    
    .divider::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 1px;
        background: #e2e8f0;
    }
    
    .divider span {
        background: white;
        padding: 0 16px;
        position: relative;
        color: #64748b;
        font-size: 14px;
    }
    
    .register-link {
        text-align: center;
        padding: 20px 0 0;
        border-top: 1px solid #e2e8f0;
        margin-top: 24px;
    }
    
    .register-link a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }
    
    .register-link a:hover {
        color: #764ba2;
    }
    
    .alert-custom {
        padding: 14px 16px;
        border-radius: 12px;
        margin-bottom: 20px;
        border-left: 4px solid #ef4444;
        background: #fef2f2;
        color: #991b1b;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .footer-text {
        text-align: center;
        margin-top: 24px;
        color: white;
        font-size: 13px;
        opacity: 0.9;
    }
    
    .footer-text a {
        color: white;
        text-decoration: underline;
    }
</style>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <img src="<?php echo base_url('img/logo_preloved_light.png') ?>" alt="Preloved">
            <h5>Welcome Back!</h5>
            <p>Sign in to continue to your account</p>
        </div>
        
        <div class="login-body">
            <?php if (session()->getFlashData('failed')): ?>
                <div class="alert-custom">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span><?= session()->getFlashData('failed') ?></span>
                </div>
            <?php endif; ?>
            
            <?= form_open('login') ?>
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <div class="input-group-custom">
                        <i class="bi bi-person-fill input-icon"></i>
                        <input type="text" name="username" class="form-control-custom" placeholder="Enter your username" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-group-custom">
                        <i class="bi bi-lock-fill input-icon"></i>
                        <input type="password" name="password" class="form-control-custom" placeholder="Enter your password" required>
                    </div>
                </div>
                
                <button type="submit" name="submit" class="btn-login">
                    Sign In
                </button>
            <?= form_close() ?>
            
            <div class="register-link">
                Don't have an account? <a href="<?= base_url('register') ?>">Create Account</a>
            </div>
        </div>
    </div>
    
    <div class="footer-text">
        &copy; <?= date('Y') ?> Preloved-U. All rights reserved.
    </div>
</div>

<?= $this->endSection() ?>