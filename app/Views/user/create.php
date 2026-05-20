<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="page-title">
    <div><h4><i class="bi bi-person-plus me-2 text-primary"></i><?= esc($title) ?></h4></div>
    <a href="<?= base_url('admin/user') ?>" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
</div>
<div class="row justify-content-center"><div class="col-md-7">
<div class="card">
<div class="card-header"><i class="bi bi-plus-circle me-2"></i>Form Tambah User</div>
<div class="card-body">
<form action="<?= base_url('admin/user/store') ?>" method="POST"><?= csrf_field() ?>
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Username <span class="text-danger">*</span></label>
        <input type="text" name="username" class="form-control" value="<?= old('username') ?>" placeholder="Minimal 3 karakter" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Role <span class="text-danger">*</span></label>
        <select name="role" class="form-select" required>
            <option value="">-- Pilih Role --</option>
            <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="kasir" <?= old('role') === 'kasir' ? 'selected' : '' ?>>Kasir</option>
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
        <input type="text" name="nama" class="form-control" value="<?= old('nama') ?>" required>
    </div>
    <div class="col-12">
        <label class="form-label">Password <span class="text-danger">*</span></label>
        <div class="input-group">
            <input type="password" name="password" id="pwd" class="form-control" placeholder="Minimal 6 karakter" required>
            <button type="button" class="input-group-text" onclick="togglePass()"><i class="bi bi-eye" id="eyeI"></i></button>
        </div>
    </div>
</div>
<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan User</button>
    <a href="<?= base_url('admin/user') ?>" class="btn btn-outline-secondary">Batal</a>
</div>
</form>
</div></div>
</div></div>
<script>
function togglePass() {
    const p = document.getElementById('pwd');
    const i = document.getElementById('eyeI');
    p.type = p.type === 'password' ? 'text' : 'password';
    i.className = p.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
<?= $this->endSection() ?>
