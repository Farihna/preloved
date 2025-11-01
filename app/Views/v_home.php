<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<?php
if (session()->getFlashData('success')) {
?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>
<!-- Table with stripped rows -->
<div class="row">
    <?php foreach ($product as $key => $item) : ?>
        <div class="col-lg-6">
            <?php
            echo form_hidden('id', $item['id']);
            echo form_hidden('nama', $item['nama']);
            echo form_hidden('harga', $item['harga']);
            echo form_hidden('foto', $item['foto']);
            ?>
            <div class="card">
                <div class="card-body">
                    <img src="<?php echo base_url() . "img/" . $item['foto'] ?>" alt="..." width="300px">
                    <h5 class="card-title"><?php echo $item['nama'] ?><br><?php echo number_to_currency($item['harga'], 'IDR') ?></h5>
                    <p><?php echo $item['deskripsi'] ?></p>
                    <div class="container">
                        <div class="row">
                            <div class="col"><span class="badge bg-danger fs-6 ms-auto"><?= $item['status'] == 0 ? 'Sold' : '' ?></span></div>
                        </div>
                        <div class="row">
                            <div class="col  mt-5"><a class="btn btn-outline-primary" href="https://wa.me/+62<?= session()->get('hp'); ?>?text=Halo!%20Saya%20ingin%20beli">Hubungi Penjual</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>
<!-- End Table with stripped rows -->
<?= $this->endSection() ?>