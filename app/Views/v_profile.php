<?= $this->extend('layout_user') ?>
<?= $this->section('content') ?>

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