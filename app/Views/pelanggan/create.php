<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="page-title">
    <div><h4><i class="bi bi-people-fill me-2 text-primary"></i><?= esc($title) ?></h4></div>
    <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
</div>
<div class="row justify-content-center"><div class="col-md-7">
<div class="card"><div class="card-header"><i class="bi bi-plus-circle me-2"></i>Form Tambah Pelanggan</div>
<div class="card-body">
<form action="<?= base_url('admin/pelanggan/store') ?>" method="POST"><?= csrf_field() ?>
<div class="mb-3">
    <label class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
    <input type="text" name="nama_pelanggan" class="form-control" value="<?= old('nama_pelanggan') ?>" required>
</div>
<div class="mb-3">
    <label class="form-label">Telepon</label>
    <input type="text" name="telepon" class="form-control" value="<?= old('telepon') ?>" placeholder="08xx-xxxx-xxxx">
</div>
<div class="mb-3">
    <label class="form-label">Alamat</label>
    <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap pelanggan"><?= old('alamat') ?></textarea>
</div>
<div class="d-flex gap-2 mt-3">
    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan</button>
    <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-outline-secondary">Batal</a>
</div>
</form>
</div></div>
</div></div>
<?= $this->endSection() ?>
