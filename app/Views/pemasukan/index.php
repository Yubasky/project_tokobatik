<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-title">
    <div>
        <h4><i class="bi bi-arrow-down-circle-fill me-2 text-success"></i><?= esc($title) ?></h4>
        <div class="title-meta">Total: <?= count($pemasukan) ?> entri</div>
    </div>
    <a href="<?= base_url($role . '/pemasukan/create') ?>" class="btn btn-success">
        <i class="bi bi-plus-lg"></i> Catat Pemasukan
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pemasukan)): ?>
                    <tr><td colspan="6" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>Belum ada data pemasukan
                    </td></tr>
                    <?php else: ?>
                    <?php foreach ($pemasukan as $i => $p): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= date('d/m/Y', strtotime($p['tanggal'])) ?></td>
                        <td><?= esc($p['keterangan']) ?></td>
                        <td>
                            <?php if ($p['kategori']): ?>
                            <span class="badge bg-success bg-opacity-25 text-success"><?= esc($p['kategori']) ?></span>
                            <?php else: ?><span class="text-muted">-</span><?php endif; ?>
                        </td>
                        <td class="fw-bold jumlah-masuk">+ Rp <?= number_format($p['jumlah'], 0, ',', '.') ?></td>
                        <td>
                            <a href="<?= base_url($role . '/pemasukan/edit/' . $p['id_pemasukan']) ?>" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="<?= base_url($role . '/pemasukan/delete/' . $p['id_pemasukan']) ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Hapus pemasukan ini? Data kas akan ikut dihapus.')">
                                <i class="bi bi-trash"></i>
                            </a>
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
