<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-title">
    <div>
        <h4><i class="bi bi-cart3 me-2 text-primary"></i><?= esc($title) ?></h4>
        <div class="title-meta">Total: <?= count($transaksi) ?> transaksi</div>
    </div>
    <a href="<?= base_url($role . '/transaksi/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Transaksi Baru
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pelanggan</th>
                        <th>Kasir</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($transaksi)): ?>
                    <tr><td colspan="7" class="text-center text-muted py-5">
                        <i class="bi bi-cart-x fs-2 d-block mb-2"></i>Belum ada transaksi
                    </td></tr>
                    <?php else: ?>
                    <?php foreach ($transaksi as $t): ?>
                    <tr>
                        <td><span class="badge bg-secondary">#<?= $t['id_transaksi'] ?></span></td>
                        <td class="fw-semibold"><?= esc($t['nama_pelanggan']) ?></td>
                        <td><?= esc($t['nama_kasir']) ?></td>
                        <td><?= date('d/m/Y', strtotime($t['tanggal'])) ?></td>
                        <td class="fw-bold text-success">Rp <?= number_format($t['total'], 0, ',', '.') ?></td>
                        <td><span class="badge bg-success"><?= esc($t['status']) ?></span></td>
                        <td>
                            <a href="<?= base_url($role . '/transaksi/show/' . $t['id_transaksi']) ?>" class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                            <?php if ($role === 'admin'): ?>
                            <a href="<?= base_url('admin/transaksi/delete/' . $t['id_transaksi']) ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Hapus transaksi ini? Stok akan dikembalikan.')">
                                <i class="bi bi-trash"></i>
                            </a>
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
