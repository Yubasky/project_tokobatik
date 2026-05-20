<?php
$role    = $role ?? session()->get('role');
$prefix  = ($role === 'admin') ? '/admin' : '/kasir';
$current = current_url();

function isActive(string $path): string {
    return (strpos(current_url(), $path) !== false) ? 'active' : '';
}
?>
<div class="sidebar" id="sidebar">
    <!-- Brand -->
    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="bi bi-grid-3x3-gap-fill"></i>
        </div>
        <div class="brand-text">
            <span class="brand-name">Wayang Batik</span>
            <span class="brand-sub">Manajemen Sistem</span>
        </div>
    </div>

    <!-- User Info -->
    <div class="sidebar-user">
        <div class="user-avatar">
            <i class="bi bi-person-fill"></i>
        </div>
        <div class="user-info">
            <span class="user-name"><?= esc(session()->get('nama')) ?></span>
            <span class="user-role badge <?= $role === 'admin' ? 'bg-primary' : 'bg-success' ?>">
                <?= strtoupper($role) ?>
            </span>
        </div>
    </div>

    <div class="sidebar-divider"></div>

    <!-- Navigation -->
    <nav class="sidebar-nav">
        <div class="nav-label">MENU UTAMA</div>

        <a href="<?= base_url($prefix . '/dashboard') ?>" class="nav-item <?= isActive($prefix . '/dashboard') ?>">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>

        <a href="<?= base_url($prefix . '/transaksi') ?>" class="nav-item <?= isActive($prefix . '/transaksi') ?>">
            <i class="bi bi-cart3"></i>
            <span>Penjualan</span>
        </a>

        <?php if ($role === 'admin'): ?>
        <a href="<?= base_url('admin/pembelian') ?>" class="nav-item <?= isActive('/admin/pembelian') ?>">
            <i class="bi bi-box-arrow-in-down"></i>
            <span>Pembelian / Restock</span>
        </a>
        <?php endif; ?>

        <div class="nav-label mt-2">KEUANGAN</div>

        <a href="<?= base_url($prefix . '/pemasukan') ?>" class="nav-item <?= isActive($prefix . '/pemasukan') ?>">
            <i class="bi bi-arrow-down-circle-fill text-success"></i>
            <span>Pemasukan</span>
        </a>

        <a href="<?= base_url($prefix . '/pengeluaran') ?>" class="nav-item <?= isActive($prefix . '/pengeluaran') ?>">
            <i class="bi bi-arrow-up-circle-fill text-danger"></i>
            <span>Pengeluaran</span>
        </a>

        <a href="<?= base_url($prefix . '/kas') ?>" class="nav-item <?= isActive($prefix . '/kas') ?>">
            <i class="bi bi-journal-text"></i>
            <span>Laporan Kas</span>
        </a>

        <div class="nav-label mt-2">DATA MASTER</div>

        <?php if ($role === 'admin'): ?>
        <a href="<?= base_url('admin/produk') ?>" class="nav-item <?= isActive('/admin/produk') ?>">
            <i class="bi bi-box-seam"></i>
            <span>Produk</span>
        </a>
        <?php endif; ?>

        <a href="<?= base_url($prefix . '/pelanggan') ?>" class="nav-item <?= isActive($prefix . '/pelanggan') ?>">
            <i class="bi bi-people-fill"></i>
            <span>Pelanggan</span>
        </a>

        <?php if ($role === 'admin'): ?>
        <a href="<?= base_url('admin/user') ?>" class="nav-item <?= isActive('/admin/user') ?>">
            <i class="bi bi-person-gear"></i>
            <span>Manajemen User</span>
        </a>
        <?php endif; ?>
    </nav>

    <div class="sidebar-footer">
        <a href="<?= base_url('logout') ?>" class="nav-item text-danger" onclick="return confirm('Yakin ingin logout?')">
            <i class="bi bi-box-arrow-left"></i>
            <span>Logout</span>
        </a>
    </div>
</div>
