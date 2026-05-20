<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>

<div class="auth-page">
    <div class="auth-card">
        <!-- Logo -->
        <div class="auth-logo">
            <i class="bi bi-grid-3x3-gap-fill"></i>
        </div>

        <div class="text-center mb-4">
            <h3 class="fw-bold gradient-text">Wayang Batik</h3>
            <p class="text-muted small">Sistem Manajemen Penjualan</p>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <?= session()->getFlashdata('error') ?>
        </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-check-circle-fill"></i>
            <?= session()->getFlashdata('success') ?>
        </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="<?= base_url('login') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" class="form-control <?= session()->getFlashdata('errors') ? 'is-invalid' : '' ?>"
                           id="username" name="username"
                           value="<?= old('username') ?>"
                           placeholder="Masukkan username" required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" id="password"
                           name="password" placeholder="Masukkan password" required>
                    <button type="button" class="input-group-text" onclick="togglePassword()">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-lg">
                <i class="bi bi-box-arrow-in-right me-1"></i>
                Masuk
            </button>
        </form>
    </div>
</div>

<style>
.auth-page {
    background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.6)), url('<?= base_url("assets/images/login-bg.png") ?>');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
}
.auth-card {
    background: rgba(255, 255, 255, 0.92) !important;
    backdrop-filter: blur(8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.3) !important;
    border: 1px solid rgba(255,255,255,0.4);
}
</style>

<script>
function togglePassword() {
    const pwd = document.getElementById('password');
    const eye = document.getElementById('eyeIcon');
    if (pwd.type === 'password') {
        pwd.type = 'text';
        eye.className = 'bi bi-eye-slash';
    } else {
        pwd.type = 'password';
        eye.className = 'bi bi-eye';
    }
}
</script>

<?= $this->endSection() ?>
