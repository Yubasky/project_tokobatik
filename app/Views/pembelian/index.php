<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-title">
    <div>
        <h4><i class="bi bi-box-arrow-in-down me-2 text-danger"></i><?= esc($title) ?></h4>
        <div class="title-meta">Total: <?= count($pembelian) ?> histori</div>
    </div>
    <a href="<?= base_url($role . '/pembelian/create') ?>" class="btn btn-danger">
        <i class="bi bi-plus-lg"></i> Catat Pembelian Stok
    </a>
</div>

<div class="card fade-in-up">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="dataTable">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Operator</th>
                        <th>Total Biaya</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($pembelian as $p): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('d/m/Y', strtotime($p['tanggal'])) ?></td>
                        <td><?= esc($p['keterangan'] ?? 'Beli Stok') ?></td>
                        <td><span class="badge bg-secondary"><?= esc($p['nama_user'] ?? 'System') ?></span></td>
                        <td class="fw-bold text-danger">Rp <?= number_format($p['total_biaya'], 0, ',', '.') ?></td>
                        <td class="text-center">
                            <a href="<?= base_url($role . '/pembelian/show/' . $p['id_pembelian']) ?>" class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="<?= base_url($role . '/pembelian/delete/' . $p['id_pembelian']) ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Hapus/Void riwayat belanja ini? (Stok akan ditarik kembali dan Kas dikembalikan)')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($pembelian)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada riwayat pembelian stok.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
