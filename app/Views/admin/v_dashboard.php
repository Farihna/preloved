<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <i class="bi bi-people-fill fs-1 rounded-1"></i>
                            <p class="card-category">Users</p>
                            <h4 class="card-title"><?= $userCount ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <i class="bi bi-box-seam-fill fs-1 rounded-1"></i>
                            <p class="card-category">Products</p>
                            <h4 class="card-title"><?= $productCount ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endsection() ?>