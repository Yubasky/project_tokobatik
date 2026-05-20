<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Butik Batik') ?> | Toko Batik</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Custom Dark Theme -->
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body class="dark-theme">

<!-- Sidebar -->
<?= view('layouts/partials/sidebar') ?>

<!-- Main Content -->
<div class="main-content" id="mainContent">
    <!-- Topbar -->
    <?= view('layouts/partials/navbar') ?>

    <!-- Page Content -->
    <div class="page-content">
        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-check-circle-fill"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong><i class="bi bi-exclamation-circle-fill me-1"></i>Validasi Gagal:</strong>
            <ul class="mb-0 mt-1">
                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                <li><?= esc($err) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </div>

    <!-- Footer -->
    <?= view('layouts/partials/footer') ?>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<!-- Custom JS -->
<script src="<?= base_url('assets/js/app.js') ?>"></script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
