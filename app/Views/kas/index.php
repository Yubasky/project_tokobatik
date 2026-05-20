<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-title d-print-none">
    <div>
        <h4><i class="bi bi-journal-text me-2 text-warning"></i><?= esc($title) ?></h4>
        <div class="title-meta"><?= date('F Y') ?></div>
    </div>
    <button onclick="window.print()" class="btn btn-outline-primary">
        <i class="bi bi-printer me-1"></i> Cetak Laporan
    </button>
</div>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card" style="--stat-color: #10b981; --stat-bg: rgba(16,185,129,0.1)">
            <div class="stat-icon"><i class="bi bi-arrow-down-circle-fill"></i></div>
            <div class="stat-value">Rp <?= number_format($totalPemasukan, 0, ',', '.') ?></div>
            <div class="stat-label">Total Pemasukan Bulan Ini</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="--stat-color: #ef4444; --stat-bg: rgba(239,68,68,0.1)">
            <div class="stat-icon"><i class="bi bi-arrow-up-circle-fill"></i></div>
            <div class="stat-value">Rp <?= number_format($totalPengeluaran, 0, ',', '.') ?></div>
            <div class="stat-label">Total Pengeluaran Bulan Ini</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="--stat-color: #f59e0b; --stat-bg: rgba(245,158,11,0.1)">
            <div class="stat-icon"><i class="bi bi-wallet2"></i></div>
            <div class="stat-value <?= $saldo >= 0 ? 'saldo-positif' : 'saldo-negatif' ?>">
                Rp <?= number_format(abs($saldo), 0, ',', '.') ?>
            </div>
            <div class="stat-label">Saldo Kas Terkini (Keseluruhan)</div>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form action="<?= base_url($role . '/kas/filter') ?>" method="POST" class="row g-3 align-items-end">
            <?= csrf_field() ?>
            <div class="col-md-4">
                <label class="form-label">Tanggal Dari</label>
                <input type="date" name="dari" class="form-control" value="<?= esc($dari) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Tanggal Sampai</label>
                <input type="date" name="sampai" class="form-control" value="<?= esc($sampai) ?>">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                <a href="<?= base_url($role . '/kas') ?>" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Riwayat Kas -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-list-ul me-2"></i>Riwayat Buku Kas</span>
        <?php if ($dari || $sampai): ?>
        <span class="badge bg-primary">
            <?= $dari ? date('d/m/Y', strtotime($dari)) : '...' ?> s/d <?= $sampai ? date('d/m/Y', strtotime($sampai)) : '...' ?>
        </span>
        <?php endif; ?>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. Ref</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Debet (+)</th>
                        <th>Kredit (-)</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($riwayat)): ?>
                    <tr><td colspan="7" class="text-center text-muted py-5">
                        <i class="bi bi-journal fs-2 d-block mb-2"></i>Belum ada data kas
                    </td></tr>
                    <?php else: ?>
                    <?php foreach ($riwayat as $i => $r): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <span class="badge <?= strpos($r['noref'], 'IN-') === 0 ? 'bg-success' : 'bg-danger' ?> bg-opacity-75">
                                <?= esc($r['noref'] ?? '-') ?>
                            </span>
                        </td>
                        <td><?= date('d/m/Y', strtotime($r['tanggal'])) ?></td>
                        <td><?= esc($r['keterangan']) ?></td>
                        <td class="jumlah-masuk">
                            <?= $r['jumlah'] > 0 ? 'Rp ' . number_format($r['jumlah'], 0, ',', '.') : '-' ?>
                        </td>
                        <td class="jumlah-keluar">
                            <?= $r['jumlah'] < 0 ? 'Rp ' . number_format(abs($r['jumlah']), 0, ',', '.') : '-' ?>
                        </td>
                        <td class="fw-bold <?= $r['saldo_berjalan'] >= 0 ? 'saldo-positif' : 'saldo-negatif' ?>">
                            Rp <?= number_format(abs($r['saldo_berjalan']), 0, ',', '.') ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <tr style="background: rgba(99,102,241,0.08);">
                        <td colspan="6" class="text-end fw-bold text-muted">SALDO AKHIR</td>
                        <td class="fw-bold fs-5 <?= $saldo >= 0 ? 'saldo-positif' : 'saldo-negatif' ?>">
                            Rp <?= number_format(abs($saldo), 0, ',', '.') ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
@media print {
    body.light-theme { background-color: white !important; }
    .sidebar, .topbar, form.row.g-3.align-items-end { display: none !important; }
    .main-content { margin-left: 0 !important; padding: 0 !important; border: none !important; }
    .page-content { padding: 0 !important; margin: 0 !important; }
    .card { box-shadow: none !important; border: 1px solid #ddd !important; border-radius: 0 !important; margin-bottom: 20px !important; }
    .stat-card { border: 1px solid #ddd !important; }
    
    /* Ensure colors print correctly */
    .badge { border: 1px solid #666; color: black !important; }
    .stat-value { color: black !important; }
    .saldo-positif, .saldo-negatif { color: black !important; }
    
    table { width: 100% !important; border-collapse: collapse !important; }
    th, td { border: 1px solid #ddd !important; padding: 8px !important; }
}
</style>

<?= $this->endSection() ?>
