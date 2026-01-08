<?= $this->extend('layout_admin') ?>
<?= $this->section('content') ?>

<style>
    .page-header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .page-title-group h1 {
        font-size: 28px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 6px 0;
    }
    
    .page-title-group p {
        color: #64748b;
        margin: 0;
        font-size: 14px;
    }
    
    .header-actions {
        display: flex;
        gap: 12px;
    }
    
    .btn-primary-admin {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .btn-primary-admin:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        color: white;
    }
    
    .btn-success-admin {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .btn-success-admin:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        color: white;
    }
    
    .table-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    
    .table-admin {
        width: 100%;
        margin: 0;
    }
    
    .table-admin thead {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }
    
    .table-admin th {
        padding: 16px 20px;
        font-weight: 700;
        color: #475569;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }
    
    .table-admin td {
        padding: 18px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .table-admin tbody tr {
        transition: background 0.2s ease;
    }
    
    .table-admin tbody tr:hover {
        background: #f8fafc;
    }
    
    .product-cell {
        display: flex;
        gap: 16px;
        align-items: center;
    }
    
    .product-img {
        width: 70px;
        height: 70px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid #e2e8f0;
    }
    
    .product-info-text h6 {
        font-size: 15px;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 6px 0;
    }
    
    .product-info-text p {
        font-size: 13px;
        color: #64748b;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .product-info-text .author {
        font-weight: 600;
        color: #667eea;
        margin-top: 4px;
    }
    
    .price-text {
        font-size: 16px;
        font-weight: 700;
        color: #667eea;
    }
    
    .badge-status {
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }
    
    .badge-available {
        background: #d1fae5;
        color: #065f46;
    }
    
    .badge-unavailable {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .action-btns {
        display: flex;
        gap: 8px;
    }
    
    .btn-icon {
        padding: 8px 12px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 16px;
    }
    
    .btn-edit-icon {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .btn-edit-icon:hover {
        background: #bfdbfe;
    }
    
    .btn-delete-icon {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .btn-delete-icon:hover {
        background: #fecaca;
    }
    
    .alert-admin {
        padding: 14px 18px;
        border-radius: 12px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
    }
    
    .alert-info-admin {
        background: #dbeafe;
        color: #1e40af;
        border-left: 4px solid #3b82f6;
    }
    
    .alert-danger-admin {
        background: #fee2e2;
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }
    
    @media (max-width: 768px) {
        .table-container {
            overflow-x: auto;
        }
        
        .table-admin {
            min-width: 900px;
        }
    }
</style>

<?php if (session()->getFlashData('success')): ?>
    <div class="alert-admin alert-info-admin">
        <i class="bi bi-check-circle-fill"></i>
        <span><?= session()->getFlashData('success') ?></span>
    </div>
<?php endif; ?>

<?php if (session()->getFlashData('failed')): ?>
    <div class="alert-admin alert-danger-admin">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <span><?= session()->getFlashData('failed') ?></span>
    </div>
<?php endif; ?>

<div class="page-header-flex">
    <div class="page-title-group">
        <h1>Product Management</h1>
        <p>Manage all products in the platform</p>
    </div>
    <div class="header-actions">
        <button type="button" class="btn-primary-admin" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Add Product</span>
        </button>
        <a href="<?= base_url() ?>produk/download" class="btn-success-admin">
            <i class="bi bi-download"></i>
            <span>Export</span>
        </a>
    </div>
</div>

<div class="table-container">
    <table class="table-admin datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Product Details</th>
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
                        <div class="product-cell">
                            <?php if ($produk['foto'] != '' && file_exists("img/" . $produk['foto'])): ?>
                                <img src="<?= base_url('img/' . $produk['foto']) ?>" class="product-img" alt="<?= $produk['nama'] ?>">
                            <?php endif; ?>
                            <div class="product-info-text">
                                <h6><?= $produk['nama'] ?></h6>
                                <p><?= $produk['deskripsi'] ?></p>
                                <p class="author">By: <?= $produk['username'] ?></p>
                            </div>
                        </div>
                    </td>
                    <td><span class="price-text">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></span></td>
                    <td>
                        <span class="badge-status <?= $produk['status'] == 1 ? 'badge-available' : 'badge-unavailable' ?>">
                            <?= $produk['status'] == 1 ? 'Available' : 'Not Available' ?>
                        </span>
                    </td>
                    <td>
                        <div class="action-btns">
                            <button type="button" class="btn-icon btn-edit-icon" data-bs-toggle="modal" data-bs-target="#editModal-<?= $produk['id'] ?>">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <a href="<?= base_url('produk/delete/' . $produk['id']) ?>" class="btn-icon btn-delete-icon" onclick="return confirm('Delete this product?')">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                
                <!-- Edit Modal (sama seperti user, dengan styling yang sama) -->
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
                                            <option value="0" <?= $produk['status'] == 0 ? 'selected' : '' ?>>Unavailable</option>
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