<?= $this->extend('layout_user') ?>
<?= $this->section('content') ?>

<style>
    .page-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .page-title-section h1 {
        font-size: 32px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 8px 0;
    }
    
    .page-title-section p {
        color: #64748b;
        margin: 0;
    }
    
    .btn-add-product {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 28px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-add-product:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }
    
    .products-table-wrapper {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    
    .table-custom {
        width: 100%;
        margin: 0;
    }
    
    .table-custom thead {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }
    
    .table-custom th {
        padding: 18px 20px;
        font-weight: 700;
        color: #475569;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }
    
    .table-custom td {
        padding: 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .table-custom tbody tr {
        transition: background 0.2s ease;
    }
    
    .table-custom tbody tr:hover {
        background: #f8fafc;
    }
    
    .product-info {
        display: flex;
        gap: 16px;
        align-items: start;
    }
    
    .product-thumb {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid #e2e8f0;
    }
    
    .product-details h6 {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 8px 0;
    }
    
    .product-details p {
        font-size: 14px;
        color: #64748b;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .price-badge {
        font-size: 18px;
        font-weight: 700;
        color: #667eea;
    }
    
    .status-badge {
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
    }
    
    .status-available {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-sold {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .action-buttons {
        display: flex;
        gap: 8px;
    }
    
    .btn-action {
        padding: 10px 14px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 16px;
    }
    
    .btn-edit {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .btn-edit:hover {
        background: #bfdbfe;
    }
    
    .btn-delete {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .btn-delete:hover {
        background: #fecaca;
    }
    
    .modal-custom .modal-content {
        border: none;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }
    
    .modal-custom .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px 20px 0 0;
        padding: 24px 28px;
        border: none;
    }
    
    .modal-custom .modal-title {
        font-weight: 700;
        font-size: 20px;
    }
    
    .modal-custom .btn-close {
        filter: brightness(0) invert(1);
    }
    
    .modal-custom .modal-body {
        padding: 28px;
    }
    
    .form-group-custom {
        margin-bottom: 20px;
    }
    
    .form-label-custom {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 8px;
        display: block;
        font-size: 14px;
    }
    
    .form-control-custom {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 15px;
        transition: all 0.3s ease;
    }
    
    .form-control-custom:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }
    
    .modal-footer-custom {
        padding: 20px 28px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }
    
    .btn-modal {
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-secondary-custom {
        background: #f1f5f9;
        color: #475569;
    }
    
    .btn-primary-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }
    
    .alert-custom {
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .alert-info-custom {
        background: #dbeafe;
        color: #1e40af;
        border-left: 4px solid #3b82f6;
    }
    
    .alert-danger-custom {
        background: #fee2e2;
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }
    
    @media (max-width: 768px) {
        .page-header-custom {
            flex-direction: column;
            align-items: stretch;
        }
        
        .products-table-wrapper {
            overflow-x: auto;
        }
        
        .table-custom {
            min-width: 800px;
        }
    }
</style>

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