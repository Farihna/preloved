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
        font-size: 14px;
    }
    
    .table-admin tbody tr {
        transition: background 0.2s ease;
    }
    
    .table-admin tbody tr:hover {
        background: #f8fafc;
    }
    
    .user-cell {
        font-weight: 600;
        color: #1e293b;
    }
    
    .role-badge {
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }
    
    .role-admin {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
        color: #667eea;
    }
    
    .role-user {
        background: rgba(100, 116, 139, 0.1);
        color: #475569;
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
        text-decoration: none;
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
    
    .checkbox-custom {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }
    
    .checkbox-custom input {
        width: 18px;
        height: 18px;
        accent-color: #667eea;
        cursor: pointer;
    }
    
    .checkbox-custom label {
        font-size: 14px;
        color: #64748b;
        margin: 0;
        cursor: pointer;
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
    
    @media (max-width: 768px) {
        .table-container {
            overflow-x: auto;
        }
        
        .table-admin {
            min-width: 800px;
        }
    }
</style>

<div class="page-header-flex">
    <div class="page-title-group">
        <h1>User Management</h1>
        <p>Manage all users and their roles</p>
    </div>
</div>

<div class="table-container">
    <table class="table-admin">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($user as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td class="user-cell"><?= $user['username'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['hp'] ?></td>
                    <td>
                        <span class="role-badge role-<?= $user['role'] ?>">
                            <?= ucfirst($user['role']) ?>
                        </span>
                    </td>
                    <td>
                        <div class="action-btns">
                            <button type="button" class="btn-icon btn-edit-icon" data-bs-toggle="modal" data-bs-target="#editModal<?= $user['id'] ?>">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <a href="<?= base_url("manage_user/delete/" . $user['id']) ?>" class="btn-icon btn-delete-icon" onclick="return confirm('Delete this user?')">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                
                <!-- Edit Modal -->
                <div class="modal fade modal-custom" id="editModal<?= $user['id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="<?= base_url("manage_user/edit/" . $user['id']) ?>" method="post">
                                <?= csrf_field(); ?>
                                <div class="modal-body">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Username</label>
                                        <input type="text" class="form-control-custom" name="username" value="<?= $user['username'] ?>" required>
                                    </div>
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Email</label>
                                        <input type="email" class="form-control-custom" name="email" value="<?= $user['email'] ?>" required>
                                    </div>
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Phone Number</label>
                                        <input type="text" class="form-control-custom" name="hp" value="<?= $user['hp'] ?>" required>
                                    </div>
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Password</label>
                                        <div class="checkbox-custom">
                                            <input type="checkbox" id="check<?= $user['id'] ?>" name="check" value="1">
                                            <label for="check<?= $user['id'] ?>">Check to change password</label>
                                        </div>
                                        <input type="password" class="form-control-custom" name="password" placeholder="Leave empty to keep current password">
                                    </div>
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Role</label>
                                        <select class="form-control-custom" name="role" required>
                                            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                            <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                                        </select>
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

<?= $this->endSection() ?>