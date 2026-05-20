<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- Page Title -->
<div class="page-title">
    <div>
        <h4><i class="bi bi-speedometer2 me-2 text-primary"></i><?= esc($title) ?></h4>
        <div class="title-meta">Ringkasan data <?= date('F Y') ?></div>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card" style="--stat-color: #6366f1; --stat-bg: rgba(99,102,241,0.1)">
            <div class="stat-icon"><i class="bi bi-cart-check-fill"></i></div>
            <div class="stat-value"><?= 'Rp ' . number_format($totalPenjualanHariIni, 0, ',', '.') ?></div>
            <div class="stat-label">Penjualan Hari Ini</div>
            <div class="stat-change"><i class="bi bi-calendar-day me-1"></i><?= date('d M Y') ?></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card" style="--stat-color: #10b981; --stat-bg: rgba(16,185,129,0.1)">
            <div class="stat-icon"><i class="bi bi-arrow-down-circle-fill"></i></div>
            <div class="stat-value"><?= 'Rp ' . number_format($totalPemasukan, 0, ',', '.') ?></div>
            <div class="stat-label">Total Pemasukan Bulan Ini</div>
            <div class="stat-change"><i class="bi bi-graph-up me-1"></i>Bulan <?= date('F') ?></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card" style="--stat-color: #ef4444; --stat-bg: rgba(239,68,68,0.1)">
            <div class="stat-icon"><i class="bi bi-arrow-up-circle-fill"></i></div>
            <div class="stat-value"><?= 'Rp ' . number_format($totalPengeluaran, 0, ',', '.') ?></div>
            <div class="stat-label">Total Pengeluaran Bulan Ini</div>
            <div class="stat-change"><i class="bi bi-graph-down me-1"></i>Bulan <?= date('F') ?></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card" style="--stat-color: #f59e0b; --stat-bg: rgba(245,158,11,0.1)">
            <div class="stat-icon"><i class="bi bi-wallet2"></i></div>
            <div class="stat-value <?= $saldoKas >= 0 ? 'saldo-positif' : 'saldo-negatif' ?>">
                <?= 'Rp ' . number_format(abs($saldoKas), 0, ',', '.') ?>
            </div>
            <div class="stat-label">Saldo Kas Terkini</div>
            <div class="stat-change">
                <i class="bi bi-<?= $saldoKas >= 0 ? 'check-circle' : 'exclamation-triangle' ?> me-1"></i>
                <?= $saldoKas >= 0 ? 'Kas Positif' : 'Kas Negatif' ?>
            </div>
        </div>
    </div>
</div>

<!-- Second Row: Info Cards -->
<?php if ($role === 'admin'): ?>
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center gap-4">
                <div class="stat-icon" style="--stat-color: #06b6d4; --stat-bg: rgba(6,182,212,0.1); margin-bottom: 0;">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div>
                    <div class="stat-value"><?= number_format($totalProduk) ?></div>
                    <div class="stat-label">Total Produk</div>
                </div>
                <div class="ms-auto">
                    <a href="<?= base_url('admin/produk') ?>" class="btn btn-outline-primary btn-sm">Kelola</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center gap-4">
                <div class="stat-icon" style="--stat-color: #8b5cf6; --stat-bg: rgba(139,92,246,0.1); margin-bottom: 0;">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <div class="stat-value"><?= number_format($totalPelanggan) ?></div>
                    <div class="stat-label">Total Pelanggan</div>
                </div>
                <div class="ms-auto">
                    <a href="<?= base_url($role . '/pelanggan') ?>" class="btn btn-outline-primary btn-sm">Kelola</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Transaksi Terbaru -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-clock-history me-2"></i>Transaksi Terbaru</span>
        <a href="<?= base_url($role . '/transaksi') ?>" class="btn btn-sm btn-outline-primary">
            Lihat Semua
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pelanggan</th>
                        <th>Kasir</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($transaksiTerbaru)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Belum ada transaksi
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($transaksiTerbaru as $t): ?>
                    <tr>
                        <td><span class="badge bg-secondary">#<?= $t['id_transaksi'] ?></span></td>
                        <td>
                            <div class="fw-semibold"><?= esc($t['nama_pelanggan']) ?></div>
                        </td>
                        <td><?= esc($t['nama_kasir']) ?></td>
                        <td><?= date('d/m/Y', strtotime($t['tanggal'])) ?></td>
                        <td class="fw-bold text-success">Rp <?= number_format($t['total'], 0, ',', '.') ?></td>
                        <td>
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i><?= esc($t['status']) ?>
                            </span>
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
