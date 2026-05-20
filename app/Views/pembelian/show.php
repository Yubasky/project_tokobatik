<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-title d-print-none">
    <div>
        <h4><i class="bi bi-receipt me-2 text-primary"></i><?= esc($title) ?></h4>
        <div class="title-meta"><?= date('d M Y H:i', strtotime($pembelian['created_at'])) ?></div>
    </div>
    <div>
        <button onclick="window.print()" class="btn btn-outline-primary me-2">
            <i class="bi bi-printer me-1"></i> Cetak
        </button>
        <a href="<?= base_url($role . '/pembelian') ?>" class="btn btn-outline-secondary">
            Kembali
        </a>
    </div>
</div>

<div class="card invoice-card fade-in-up">
    <div class="card-body p-5">
        <!-- Header Struk -->
        <div class="d-flex justify-content-between align-items-start mb-5 border-bottom pb-4">
            <div>
                <h2 class="fw-bold mb-1 gradient-text">WAYANG BATIK</h2>
                <div class="text-muted small">Nota Pembelian Stok (Kulakan)</div>
            </div>
            <div class="text-end">
                <h5 class="fw-bold text-dark mb-1">INVOICE PEMBELIAN</h5>
                <div class="text-muted small">ID: #<?= str_pad($pembelian['id_pembelian'], 5, '0', STR_PAD_LEFT) ?></div>
                <div class="text-muted small">Ref: <?= esc($pembelian['keterangan'] ?? '-') ?></div>
            </div>
        </div>

        <!-- Info Pembeli/Kasir -->
        <div class="row mb-5">
            <div class="col-sm-6">
                <div class="text-muted small fw-bold text-uppercase mb-2">Tanggal Belanja</div>
                <h6 class="fw-bold mb-0 text-dark"><?= date('d F Y', strtotime($pembelian['tanggal'])) ?></h6>
            </div>
            <div class="col-sm-6 text-end">
                <div class="text-muted small fw-bold text-uppercase mb-2">Operator (Admin)</div>
                <h6 class="fw-bold mb-0 text-dark"><?= esc($pembelian['nama_user'] ?? 'Sistem') ?></h6>
            </div>
        </div>

        <!-- Tabel Item -->
        <table class="table table-borderless mb-4">
            <thead class="border-bottom">
                <tr>
                    <th class="text-muted text-uppercase small">Produk</th>
                    <th class="text-end text-muted text-uppercase small" width="15%">Harga/Pcs</th>
                    <th class="text-center text-muted text-uppercase small" width="10%">Qty Masuk</th>
                    <th class="text-end text-muted text-uppercase small" width="20%">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detail as $d): ?>
                <tr class="border-bottom">
                    <td class="py-3">
                        <div class="fw-bold text-dark"><?= esc($d['nama_produk']) ?></div>
                        <small class="text-muted"><?= esc($d['kode_produk'] ?? 'Kode N/A') ?></small>
                    </td>
                    <td class="text-end py-3">Rp <?= number_format($d['harga_beli_satuan'], 0, ',', '.') ?></td>
                    <td class="text-center py-3">
                        <span class="badge bg-primary px-2 rounded-pill"><?= $d['jumlah'] ?></span>
                    </td>
                    <td class="text-end py-3 fw-bold text-dark">Rp <?= number_format($d['subtotal'], 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Summary -->
        <div class="row justify-content-end">
            <div class="col-md-5">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted">Total Pembayaran</span>
                    <span class="fw-bold text-danger fs-5">Rp <?= number_format($pembelian['total_biaya'], 0, ',', '.') ?></span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted">Status Kas</span>
                    <span class="badge bg-danger">Terpotong Otomatis</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body.light-theme { background-color: white !important; }
    .sidebar, .topbar { display: none !important; }
    .main-content { margin-left: 0 !important; padding: 0 !important; border: none !important; }
    .page-content { padding: 0 !important; }
    .card { box-shadow: none !important; border: 1px solid #ddd !important; }
}
</style>

<?= $this->endSection() ?>
