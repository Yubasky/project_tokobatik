<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-title">
    <div>
        <h4><i class="bi bi-people-fill me-2 text-primary"></i><?= esc($title) ?></h4>
        <div class="title-meta">Total: <?= count($pelanggan) ?> pelanggan</div>
    </div>
    <?php if ($role === 'admin'): ?>
    <a href="<?= base_url('admin/pelanggan/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Pelanggan
    </a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <?php if ($role === 'admin'): ?>
                        <th style="width:130px">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pelanggan)): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="bi bi-people fs-2 d-block mb-2"></i>Belum ada data pelanggan
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($pelanggan as $i => $p): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-sm" style="background:rgba(99,102,241,0.15);color:#6366f1;font-size:14px;font-weight:700;">
                                    <?= strtoupper(substr($p['nama_pelanggan'], 0, 1)) ?>
                                </div>
                                <span class="fw-semibold"><?= esc($p['nama_pelanggan']) ?></span>
                            </div>
                        </td>
                        <td><?= esc($p['telepon'] ?? '-') ?></td>
                        <td><small><?= esc($p['alamat'] ?? '-') ?></small></td>
                        <?php if ($role === 'admin'): ?>
                        <td>
                            <a href="<?= base_url('admin/pelanggan/edit/' . $p['id_pelanggan']) ?>" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="<?= base_url('admin/pelanggan/delete/' . $p['id_pelanggan']) ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin hapus pelanggan ini?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
