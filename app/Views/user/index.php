<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-title">
    <div>
        <h4><i class="bi bi-person-gear me-2 text-primary"></i><?= esc($title) ?></h4>
        <div class="title-meta">Total: <?= count($users) ?> pengguna</div>
    </div>
    <a href="<?= base_url('admin/user/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah User
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Role</th>
                        <th>Dibuat</th>
                        <th style="width:130px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                    <tr><td colspan="6" class="text-center text-muted py-5">Belum ada user</td></tr>
                    <?php else: ?>
                    <?php foreach ($users as $i => $u): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-sm" style="background:rgba(99,102,241,0.15);color:#6366f1;">
                                    <?= strtoupper(substr($u['username'], 0, 1)) ?>
                                </div>
                                <code><?= esc($u['username']) ?></code>
                            </div>
                        </td>
                        <td class="fw-semibold"><?= esc($u['nama']) ?></td>
                        <td>
                            <span class="badge <?= $u['role'] === 'admin' ? 'bg-primary' : 'bg-success' ?>">
                                <?= strtoupper($u['role']) ?>
                            </span>
                        </td>
                        <td><?= $u['created_at'] ? date('d/m/Y', strtotime($u['created_at'])) : '-' ?></td>
                        <td>
                            <a href="<?= base_url('admin/user/edit/' . $u['id']) ?>" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <?php if ($u['id'] !== (int)session()->get('id')): ?>
                            <a href="<?= base_url('admin/user/delete/' . $u['id']) ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Hapus user <?= esc($u['username']) ?>?')">
                                <i class="bi bi-trash"></i>
                            </a>
                            <?php else: ?>
                            <button class="btn btn-secondary btn-sm" disabled title="Tidak bisa hapus akun sendiri">
                                <i class="bi bi-lock"></i>
                            </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
