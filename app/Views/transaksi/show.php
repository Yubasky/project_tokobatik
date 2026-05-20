<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-title">
    <div>
        <h4><i class="bi bi-receipt me-2 text-info"></i><?= esc($title) ?></h4>
    </div>
    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-printer me-1"></i> Cetak
        </button>
        <a href="/<?= $role ?>/transaksi" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Informasi Transaksi</div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr>
                        <td class="text-muted" style="width:40%">ID Transaksi</td>
                        <td><strong>#<?= $transaksi['id_transaksi'] ?></strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Pelanggan</td>
                        <td><strong><?= esc($transaksi['nama_pelanggan']) ?></strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Telepon</td>
                        <td><?= esc($transaksi['telepon'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Kasir</td>
                        <td><?= esc($transaksi['nama_kasir']) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tanggal</td>
                        <td><?= date('d M Y', strtotime($transaksi['tanggal'])) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td><span class="badge bg-success"><?= esc($transaksi['status']) ?></span></td>
                    </tr>
                    <?php if ($transaksi['keterangan']): ?>
                    <tr>
                        <td class="text-muted">Keterangan</td>
                        <td><?= esc($transaksi['keterangan']) ?></td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Detail Produk</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($detail as $i => $d): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td>
                                    <div class="fw-semibold"><?= esc($d['nama_produk']) ?></div>
                                    <small class="text-muted"><?= esc($d['kategori'] ?? '') ?></small>
                                </td>
                                <td>Rp <?= number_format($d['harga_satuan'], 0, ',', '.') ?></td>
                                <td><?= $d['jumlah'] ?> pcs</td>
                                <td class="fw-bold">Rp <?= number_format($d['subtotal'], 0, ',', '.') ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">TOTAL</td>
                                <td class="fw-bold fs-5 text-success">
                                    Rp <?= number_format($transaksi['total'], 0, ',', '.') ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="alert alert-info mt-3 d-flex align-items-center gap-2">
            <i class="bi bi-info-circle-fill fs-5"></i>
            <div>
                <strong>Catatan:</strong> Hasil penjualan ini belum otomatis masuk ke buku kas.
                Jika pembayaran telah diterima, catat sebagai <strong>Pemasukan</strong> secara manual.
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
