<?= $this->extend('/auth/layout_clear') ?>
<?= $this->section('content') ?>

<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 0;
    }
    
    .register-container {
        width: 100%;
        max-width: 500px;
        padding: 20px;
    }
    
    .register-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }
    
    .register-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 40px 30px;
        text-align: center;
        color: white;
    }
    
    .register-header img {
        max-width: 180px;
        margin-bottom: 16px;
        filter: brightness(0) invert(1);
    }
    
    .register-header h5 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    
    .register-header p {
        font-size: 14px;
        opacity: 0.9;
        margin: 0;
    }
    
    .register-body {
        padding: 40px 30px;
    }
    
    .form-group {
        margin-bottom: 20px;
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
    
    .input-prefix {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        font-weight: 600;
        z-index: 10;
        font-size: 15px;
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
    
    .form-control-phone {
        padding-left: 56px;
    }
    
    .form-control-custom:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }
    
    .checkbox-custom {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin: 24px 0;
    }
    
    .checkbox-custom input[type="checkbox"] {
        width: 20px;
        height: 20px;
        margin-top: 2px;
        cursor: pointer;
        accent-color: #667eea;
    }
    
    .checkbox-custom label {
        font-size: 14px;
        color: #475569;
        cursor: pointer;
        margin: 0;
    }
    
    .checkbox-custom label a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
    }
    
    .btn-register {
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
    }
    
    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    }
    
    .login-link {
        text-align: center;
        padding: 20px 0 0;
        border-top: 1px solid #e2e8f0;
        margin-top: 24px;
    }
    
    .login-link a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
    }
    
    .alert-custom {
        padding: 14px 16px;
        border-radius: 12px;
        margin-bottom: 20px;
        border-left: 4px solid #ef4444;
        background: #fef2f2;
        color: #991b1b;
        font-size: 14px;
    }
    
    .footer-text {
        text-align: center;
        margin-top: 24px;
        color: white;
        font-size: 13px;
        opacity: 0.9;
    }
</style>

<div class="register-container">
    <div class="register-card">
        <div class="register-header">
            <img src="<?= base_url('img/logo_preloved_light.png')?>" alt="Preloved">
            <h5>Create Account</h5>
            <p>Join our preloved community today</p>
        </div>
        
        <div class="register-body">
            <?php if (session()->getFlashData('failed')): ?>
                <div class="alert-custom">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <?= session()->getFlashData('failed') ?>
                </div>
            <?php endif; ?>
            
            <?= form_open('register') ?>
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <div class="input-group-custom">
                        <i class="bi bi-person-fill input-icon"></i>
                        <input type="text" name="username" class="form-control-custom" placeholder="Choose a username" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope-fill input-icon"></i>
                        <input type="email" name="email" class="form-control-custom" placeholder="your@email.com" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <div class="input-group-custom">
                        <span class="input-prefix">+62</span>
                        <input type="text" name="hp" id="hp" class="form-control-custom form-control-phone" 
                               placeholder="8123456789" maxlength="15" 
                               oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-group-custom">
                        <i class="bi bi-lock-fill input-icon"></i>
                        <input type="password" name="password" class="form-control-custom" placeholder="Create a strong password" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <div class="input-group-custom">
                        <i class="bi bi-lock-fill input-icon"></i>
                        <input type="password" name="password_confirm" class="form-control-custom" placeholder="Re-enter your password" required>
                    </div>
                </div>
                
                <div class="checkbox-custom">
                    <input type="checkbox" name="terms" value="1" id="terms" required>
                    <label for="terms">
                        I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                    </label>
                </div>
                
                <button type="submit" name="submit" class="btn-register">
                    Create Account
                </button>
            <?= form_close() ?>
            
            <div class="login-link">
                Already have an account? <a href="<?= base_url('login') ?>">Sign In</a>
            </div>
        </div>
    </div>
    
    <div class="footer-text">
        &copy; <?= date('Y') ?> Preloved-U. All rights reserved.
    </div>
</div>

<script>
document.getElementById('hp').addEventListener('change', function () {
    if (this.value.startsWith('0')) {
        alert("Phone number should not start with '0'. Please enter after country code.");
        this.value = this.value.substring(1);
    }
});
</script>

<?= $this->endSection() ?>