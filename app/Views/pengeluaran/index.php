<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-title">
    <div>
        <h4><i class="bi bi-arrow-up-circle-fill me-2 text-danger"></i><?= esc($title) ?></h4>
        <div class="title-meta">Total: <?= count($pengeluaran) ?> entri</div>
    </div>
    <a href="<?= base_url($role . '/pengeluaran/create') ?>" class="btn btn-danger">
        <i class="bi bi-plus-lg"></i> Catat Pengeluaran
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
                    <?php if (empty($pengeluaran)): ?>
                    <tr><td colspan="6" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>Belum ada data pengeluaran
                    </td></tr>
                    <?php else: ?>
                    <?php foreach ($pengeluaran as $i => $p): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= date('d/m/Y', strtotime($p['tanggal'])) ?></td>
                        <td><?= esc($p['keterangan']) ?></td>
                        <td>
                            <?php if ($p['kategori']): ?>
                            <span class="badge bg-danger bg-opacity-25 text-danger"><?= esc($p['kategori']) ?></span>
                            <?php else: ?><span class="text-muted">-</span><?php endif; ?>
                        </td>
                        <td class="fw-bold jumlah-keluar">- Rp <?= number_format($p['jumlah'], 0, ',', '.') ?></td>
                        <td>
                            <a href="<?= base_url($role . '/pengeluaran/edit/' . $p['id_pengeluaran']) ?>" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="<?= base_url($role . '/pengeluaran/delete/' . $p['id_pengeluaran']) ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Hapus pengeluaran ini? Data kas akan ikut dihapus.')">
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
