<?= $this->extend('layout_user') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashData('success')): ?>
    <div class="alert-custom alert-info-custom">
        <i class="bi bi-check-circle-fill"></i>
        <span><?= session()->getFlashData('success') ?></span>
    </div>
<?php endif; ?>

<?php if (session()->getFlashData('failed')): ?>
    <div class="alert-custom alert-danger-custom">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <span><?= session()->getFlashData('failed') ?></span>
    </div>
<?php endif; ?>

<div class="page-header-custom">
    <div class="page-title-section">
        <h1>My Products</h1>
        <p>Manage your preloved items</p>
    </div>
    <button type="button" class="btn-add-product" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="bi bi-plus-circle-fill"></i>
        <span>Add New Product</span>
    </button>
</div>

<div class="products-table-wrapper">
    <table class="table-custom">
        <thead>
            <tr>
                <th>No</th>
                <th>Product</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($product as $index => $produk): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td>
                        <div class="product-info">
                            <?php if ($produk['foto'] != '' && file_exists("img/" . $produk['foto'])): ?>
                                <img src="<?= base_url('img/' . $produk['foto']) ?>" class="product-thumb" alt="<?= $produk['nama'] ?>">
                            <?php endif; ?>
                            <div class="product-details">
                                <h6><?= $produk['nama'] ?></h6>
                                <p><?= $produk['deskripsi'] ?></p>
                            </div>
                        </div>
                    </td>
                    <td><span class="price-badge">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></span></td>
                    <td>
                        <span class="status-badge <?= $produk['status'] == 1 ? 'status-available' : 'status-sold' ?>">
                            <?= $produk['status'] == 1 ? 'Available' : 'Sold' ?>
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button type="button" class="btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#editModal-<?= $produk['id'] ?>">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <a href="<?= base_url('produk/delete/' . $produk['id']) ?>" class="btn-action btn-delete" onclick="return confirm('Delete this product?')">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                
                <!-- Edit Modal -->
                <div class="modal fade modal-custom" id="editModal-<?= $produk['id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="<?= base_url('produk/edit/' . $produk['id']) ?>" method="post" enctype="multipart/form-data">
                                <?= csrf_field(); ?>
                                <div class="modal-body">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Product Name</label>
                                        <input type="text" name="nama" class="form-control-custom" value="<?= $produk['nama'] ?>" required>
                                    </div>
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Description</label>
                                        <input type="text" name="deskripsi" class="form-control-custom" value="<?= $produk['deskripsi'] ?>" required>
                                    </div>
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Price</label>
                                        <input type="text" name="harga" class="form-control-custom" value="<?= $produk['harga'] ?>" required>
                                    </div>
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Status</label>
                                        <select class="form-control-custom" name="status">
                                            <option value="1" <?= $produk['status'] == 1 ? 'selected' : '' ?>>Available</option>
                                            <option value="0" <?= $produk['status'] == 0 ? 'selected' : '' ?>>Sold</option>
                                        </select>
                                    </div>
                                    <div class="form-group-custom">
                                        <?php if ($produk['foto']): ?>
                                            <img src="<?= base_url('img/' . $produk['foto']) ?>" width="100" style="border-radius: 8px; margin-bottom: 12px;">
                                        <?php endif; ?>
                                        <label class="form-label-custom">Photo</label>
                                        <input type="file" class="form-control-custom" name="foto">
                                        <input type="hidden" name="check" value="1">
                                    </div>
                                </div>
                                <div class="modal-footer-custom">
                                    <button type="button" class="btn-modal btn-secondary-custom" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn-modal btn-primary-custom">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div class="modal fade modal-custom" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('produk') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <input type="hidden" name="id_user" value="<?= session()->get('user_id') ?>">
                    <div class="form-group-custom">
                        <label class="form-label-custom">Product Name</label>
                        <input type="text" name="nama" class="form-control-custom" placeholder="Enter product name" required>
                    </div>
                    <div class="form-group-custom">
                        <label class="form-label-custom">Description</label>
                        <input type="text" name="deskripsi" class="form-control-custom" placeholder="Enter description" required>
                    </div>
                    <div class="form-group-custom">
                        <label class="form-label-custom">Price</label>
                        <input type="text" name="harga" class="form-control-custom" placeholder="Enter price" required>
                    </div>
                    <input type="hidden" name="status" value="1">
                    <div class="form-group-custom">
                        <label class="form-label-custom">Photo</label>
                        <input type="file" class="form-control-custom" name="foto">
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-modal btn-secondary-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-modal btn-primary-custom">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>