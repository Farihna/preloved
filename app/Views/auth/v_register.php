<?= $this->extend('/auth/layout_clear') ?>
<?= $this->section('content') ?>

<?php
$username = [
    'name' => 'username',
    'id' => 'username',
    'class' => 'form-control',
];

$email = [
    'name' => 'email',
    'id' => 'email',
    'class' => 'form-control',
];

$hp = [
    'name' => 'hp',
    'id' => 'hp',
    'class' => 'form-control',
    'required'      => true,
    'oninput'       => "this.value = this.value.replace(/[^0-9]/g, '');",
    'maxlength'     => 15,
];

$password = [
    'name' => 'password',
    'id' => 'password',
    'class' => 'form-control',
];

$password_confirm = [
    'name' => 'password_confirm',
    'id' => 'password_confirm',
    'class' => 'form-control',
];

?>

<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                <div class="d-flex justify-content-center py-4">
                    <a href="index.html" class="logo d-flex align-items-center w-auto">
                        <img src="assets/img/logo.png" alt="">
                        <span class="d-none d-lg-block"><img src="<?= base_url('img/logo_preloved_dark.png')?>" alt="" class="image-fluid"></span>
                    </a>
                </div><!-- End Logo -->

                <div class="card mb-3">

                    <div class="card-body">

                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                            <p class="text-center small">Enter your personal details to create account</p>
                        </div>

                        <?php
                        // Displaying errors
                        if (session()->getFlashData('failed')) {
                            ?>
                            <div class="col-12 alert alert-danger" role="alert">
                                <hr>
                                <p class="mb-0">
                                    <?= session()->getFlashData('failed') ?>
                                </p>
                            </div>
                            <?php
                        }
                        ?>

                        <?= form_open('register', 'class = "row g-3 needs-validation"') ?>

                        <div class="col-12">
                            <label for="username" class="form-label">Username</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                <?= form_input($username) ?>
                                <div class="invalid-feedback">Please choose a username.</div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label">Your Email</label>
                            <?= form_input($email) ?>
                            <div class="invalid-feedback">Please enter a valid Email address!</div>
                        </div>

                        <div class="col-12">
                            <div class="col-12">
                                <label for="hp" class="form-label">Phone Number (HP)</label>

                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">+62</span>

                                    <?= form_input($hp) ?>

                                    <div class="invalid-feedback">Please enter your phone number!</div>
                                </div>
                            </div>

                            <script>
                                document.getElementById('hp').addEventListener('change', function () {
                                    if (this.value.startsWith('0')) {
                                        alert("Nomor telepon tidak boleh diawali dengan '0'. Harap masukkan setelah kode negara.");
                                        this.value = this.value.substring(1); // Hapus '0' di awal
                                    }
                                });
                            </script>

                            <div class="col-12">
                                <label for="password" class="form-label">Password</label>
                                <?= form_password($password) ?>
                                <div class="invalid-feedback">Please enter your password!</div>
                            </div>

                            <div class="col-12">
                                <label for="password_confirm" class="form-label">Confirm Password</label>
                                <?= form_password($password_confirm) ?>
                                <div class="invalid-feedback">Please confirm your password!</div>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" name="terms" type="checkbox" value="1"
                                        id="acceptTerms" required>
                                    <label class="form-check-label" for="acceptTerms">I agree and accept the <a
                                            href="#">terms and conditions</a></label>
                                    <div class="invalid-feedback">You must agree before submitting.</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <?= form_submit('submit', 'Create Account', ['class' => 'btn btn-primary w-100']) ?>
                            </div>
                            <div class="col-12">
                                <p class="small mb-0">Already have an account? <a href="<?= base_url('login') ?>">Log
                                        in</a></p>
                            </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
                <div class="credits">
                    <!-- All the links in the footer should remain intact. -->
                    <!-- You can delete the links only if you purchased the pro version. -->
                    <!-- Licensing information: https://bootstrapmade.com/license/ -->
                    <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                    Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                </div>
            </div>
        </div>

</section>


<?= $this->endSection() ?>