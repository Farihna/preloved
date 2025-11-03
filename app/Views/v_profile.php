<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="col-xl-8">
            <div class="card">
            <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <!-- <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li> -->

                </ul>
                <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                    <h5 class="card-title">Profile Details</h5>
                    
                    <div class="row">
                        <div class="col-lg-3 col-md-3 ">
                            <img src="<?php echo base_url('img/' . ($profile['img_profile'] == '' ? 'no_profile.jpg' : $profile['img_profile'])) ?>" alt="Profile" class="rounded-pill mb-4"  width="120" height="120">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-md-4 label ">Username</div>
                        <div class="col-lg-9 col-md-8"><?= $profile['username'] ?></div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-md-4 label">Email</div>
                        <div class="col-lg-9 col-md-8"><?= $profile['email'] ?></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-3 col-md-4 label">Nomor HP</div>
                        <div class="col-lg-9 col-md-8"><?= $profile['hp'] ?></div>
                    </div>
                    

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                    <!-- Profile Edit Form -->
                    <form action="<?= base_url('profile/edit/' . $profile['id']) ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>

                    <div class="row mb-3">
                        <label for="img_profile" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                        <div class="col-md-8 col-lg-9">
                            <img src="<?= base_url('img/' . $profile['img_profile']) ?>" alt="Profile" width="100" class="mb-2">

                            <input name="img_profile" type="file" class="form-control" id="img_profile">
                            <div class="small fst-italic mt-2">Upload foto baru (Maks 1MB, JPG/PNG)</div>
                            
                            <input type="hidden" name="check" value="1"> 
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Username</label>
                        <div class="col-md-8 col-lg-9">
                        <input name="username" type="text" class="form-control" id="username" value="<?= $profile['username'] ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="Phone" class="col-md-4 col-lg-3 col-form-label">No Hp</label>
                        <div class="col-md-8 col-lg-9" style="display: flex; align-items: center;">
                        <span style="background:#f0f0f0; padding:6px 8px; border:1px solid #ced4da; border-right:none; border-radius:6px 0 0 6px;">+62</span>
                        <input name="hp" type="text" class="form-control" id="hp" placeholder="8123456789" style="border-radius:0 6px 6px 0;"  value="<?= isset($profile['hp']) ? preg_replace('/^\+62/', '', $profile['hp']) : '' ?>" require>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                        <div class="col-md-8 col-lg-9">
                        <input name="email" type="email" class="form-control" id="email" value="<?= $profile['email'] ?>">
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                    </form><!-- End Profile Edit Form -->

                </div>

                <!-- Change Password Form -->
                <!-- <div class="tab-pane fade pt-3" id="profile-change-password">
                    <form>
                    <div class="row mb-3">
                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                        <div class="col-md-8 col-lg-9">
                        <input name="password" type="password" class="form-control" id="currentPassword">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                        <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" class="form-control" id="newPassword">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                        <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                    </form>
                </div> -->
                <!-- End Change Password Form -->

                </div><!-- End Bordered Tabs -->

            </div>
            </div>

        </div>
</div>

<script>
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