<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="table-responsive">
    <table class="table">
        <thead></thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>No Hp</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $index => $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['hp'] ?></td>
                    <td><?= $user['role'] ?></td>
                    <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#editModal<?= $user['id'] ?>"><i class="bi bi-pencil-square"></i></button>
                        <a href="<?= base_url("manage_user/delete/" . $user['id']) ?>" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></a>
                    </td>
                </tr>
                <div class="modal fade" id="editModal<?= $user['id'] ?>" tabindex="-1" role="dialog"
                    aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="<?= base_url("manage_user/edit/" . $user['id']) ?>" method="post">
                                <?= csrf_field(); ?>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            value="<?= $user['username'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="<?= $user['email'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="hp">No Hp</label>
                                        <input type="text" class="form-control" id="hp" name="hp" value="<?= $user['hp'] ?>"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check" name="check" value="1">
                                            <label class="form-check-label" for="check">
                                                Ceklis jika ingin mengganti Password
                                            </label>
                                        </div>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select class="form-control" id="role" name="role" required>
                                            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin
                                            </option>
                                            <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
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