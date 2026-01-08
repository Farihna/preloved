<?= $this->extend('layout_user') ?>
<?= $this->section('content') ?>

<style>
    .profile-container {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .profile-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 40px;
        text-align: center;
        color: white;
    }
    
    .profile-avatar-wrapper {
        margin-bottom: 20px;
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 5px solid white;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        object-fit: cover;
    }
    
    .profile-name {
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }
    
    .profile-role {
        font-size: 16px;
        opacity: 0.9;
    }
    
    .profile-tabs {
        display: flex;
        border-bottom: 2px solid #f1f5f9;
        background: #f8fafc;
    }
    
    .tab-button {
        flex: 1;
        padding: 20px;
        background: none;
        border: none;
        font-size: 16px;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        position: relative;
        transition: all 0.3s ease;
    }
    
    .tab-button:hover {
        color: #667eea;
        background: white;
    }
    
    .tab-button.active {
        color: #667eea;
        background: white;
    }
    
    .tab-button.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .tab-content {
        padding: 40px;
    }
    
    .tab-pane {
        display: none;
    }
    
    .tab-pane.active {
        display: block;
    }
    
    .info-row {
        display: flex;
        padding: 20px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-label {
        flex: 0 0 200px;
        font-weight: 600;
        color: #475569;
    }
    
    .info-value {
        flex: 1;
        color: #1e293b;
    }
    
    .form-group-profile {
        margin-bottom: 24px;
    }
    
    .form-label-profile {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 8px;
        display: block;
    }
    
    .form-control-profile {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s ease;
    }
    
    .form-control-profile:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }
    
    .input-group-profile {
        display: flex;
        align-items: center;
    }
    
    .input-prefix-profile {
        padding: 14px 16px;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-right: none;
        border-radius: 12px 0 0 12px;
        font-weight: 600;
        color: #64748b;
    }
    
    .input-group-profile .form-control-profile {
        border-radius: 0 12px 12px 0;
    }
    
    .avatar-upload-section {
        display: flex;
        align-items: center;
        gap: 24px;
        margin-bottom: 32px;
    }
    
    .avatar-preview {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e2e8f0;
    }
    
    .avatar-upload-info p {
        margin: 0 0 8px 0;
        color: #64748b;
        font-size: 14px;
    }
    
    .btn-save-profile {
        padding: 14px 32px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-save-profile:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }
    
    @media (max-width: 768px) {
        .profile-tabs {
            flex-direction: column;
        }
        
        .info-row {
            flex-direction: column;
            gap: 8px;
        }
        
        .info-label {
            flex: none;
        }
        
        .avatar-upload-section {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<div class="profile-container">
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-avatar-wrapper">
                <img src="<?= base_url('img/' . ($profile['img_profile'] ?: 'no_profile.jpg')) ?>" 
                     alt="Profile" class="profile-avatar">
            </div>
            <h1 class="profile-name"><?= $profile['username'] ?></h1>
            <p class="profile-role">User Account</p>
        </div>
        
        <div class="profile-tabs">
            <button class="tab-button active" data-tab="overview">Overview</button>
            <button class="tab-button" data-tab="edit">Edit Profile</button>
        </div>
        
        <div class="tab-content">
            <!-- Overview Tab -->
            <div class="tab-pane active" id="overview">
                <div class="info-row">
                    <div class="info-label">Username</div>
                    <div class="info-value"><?= $profile['username'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email</div>
                    <div class="info-value"><?= $profile['email'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Phone Number</div>
                    <div class="info-value"><?= $profile['hp'] ?></div>
                </div>
            </div>
            
            <!-- Edit Tab -->
            <div class="tab-pane" id="edit">
                <form action="<?= base_url('profile/edit/' . $profile['id']) ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    
                    <div class="avatar-upload-section">
                        <img src="<?= base_url('img/' . ($profile['img_profile'] ?: 'no_profile.jpg')) ?>" 
                             alt="Profile" class="avatar-preview">
                        <div class="avatar-upload-info">
                            <p><strong>Change Profile Picture</strong></p>
                            <input type="file" name="img_profile" class="form-control-profile">
                            <input type="hidden" name="check" value="1">
                            <p style="margin-top: 8px; font-size: 13px;">Max 1MB, JPG/PNG</p>
                        </div>
                    </div>
                    
                    <div class="form-group-profile">
                        <label class="form-label-profile">Username</label>
                        <input type="text" name="username" class="form-control-profile" value="<?= $profile['username'] ?>" required>
                    </div>
                    
                    <div class="form-group-profile">
                        <label class="form-label-profile">Email</label>
                        <input type="email" name="email" class="form-control-profile" value="<?= $profile['email'] ?>" required>
                    </div>
                    
                    <div class="form-group-profile">
                        <label class="form-label-profile">Phone Number</label>
                        <div class="input-group-profile">
                            <span class="input-prefix-profile">+62</span>
                            <input type="text" name="hp" id="hp" class="form-control-profile" 
                                   value="<?= isset($profile['hp']) ? preg_replace('/^\+62/', '', $profile['hp']) : '' ?>" 
                                   placeholder="8123456789" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-save-profile">
                        <i class="bi bi-save"></i> Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Tab switching
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', () => {
            const tabName = button.dataset.tab;
            
            document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));
            
            button.classList.add('active');
            document.getElementById(tabName).classList.add('active');
        });
    });
    
    // Phone input validation
    const hpInput = document.getElementById('hp');
    hpInput.addEventListener('input', function(e) {
        let val = e.target.value;
        val = val.replace(/[^0-9]/g, '');
        if (val.startsWith('0')) {
            val = val.substring(1);
        }
        e.target.value = val;
    });
</script>

<?= $this->endSection() ?>