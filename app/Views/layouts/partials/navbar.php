<nav class="topbar">
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>

    <div class="topbar-left">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <i class="bi bi-house-fill me-1"></i>
                    <a href="#"><?= strtoupper(session()->get('role') ?? '') ?></a>
                </li>
                <li class="breadcrumb-item active"><?= esc($title ?? '') ?></li>
            </ol>
        </nav>
    </div>

    <div class="topbar-right d-flex align-items-center gap-3">
        <!-- Date/Time -->
        <span class="text-muted small d-none d-md-block">
            <i class="bi bi-calendar3 me-1"></i>
            <?= date('d M Y') ?>
        </span>

        <!-- User Dropdown -->
        <div class="dropdown">
            <button class="btn btn-sm topbar-user-btn dropdown-toggle" data-bs-toggle="dropdown">
                <div class="topbar-avatar">
                    <i class="bi bi-person-fill"></i>
                </div>
                <span class="d-none d-sm-inline"><?= esc(session()->get('nama')) ?></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                <li>
                    <span class="dropdown-item-text small text-muted">
                        Login sebagai <strong><?= strtoupper(session()->get('role')) ?></strong>
                    </span>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>" onclick="return confirm('Yakin ingin logout?')">
                        <i class="bi bi-box-arrow-left me-2"></i>Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
