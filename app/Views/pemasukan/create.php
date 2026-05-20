<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="page-title">
    <div><h4><i class="bi bi-arrow-down-circle-fill me-2 text-success"></i><?= esc($title) ?></h4></div>
    <a href="<?= base_url($role . '/pemasukan') ?>" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
</div>
<div class="row justify-content-center"><div class="col-md-7">
<div class="card">
<div class="card-header"><i class="bi bi-plus-circle me-2 text-success"></i>Form Catat Pemasukan</div>
<div class="card-body">
<div class="alert alert-success d-flex gap-2 align-items-center mb-4">
    <i class="bi bi-info-circle-fill"></i>
    <small>Pemasukan akan otomatis tercatat di Buku Kas sebagai transaksi positif.</small>
</div>
<form action="<?= base_url($role . '/pemasukan/store') ?>" method="POST"><?= csrf_field() ?>
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
        <input type="date" name="tanggal" class="form-control" value="<?= old('tanggal', date('Y-m-d')) ?>" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Kategori</label>
        <select name="kategori" class="form-select">
            <option value="">-- Pilih Kategori --</option>
            <?php foreach (['Penjualan', 'Transfer', 'Lainnya'] as $k): ?>
            <option value="<?= $k ?>" <?= old('kategori') === $k ? 'selected' : '' ?>><?= $k ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">Keterangan <span class="text-danger">*</span></label>
        <input type="text" name="keterangan" class="form-control" value="<?= old('keterangan') ?>" placeholder="Contoh: Penjualan tunai batik" required>
    </div>
    <div class="col-12">
        <label class="form-label">Jumlah (Rp) <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text">Rp</span>
            <input type="number" name="jumlah" class="form-control" value="<?= old('jumlah') ?>" min="0" placeholder="0" required>
        </div>
    </div>
</div>
<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-success"><i class="bi bi-save me-1"></i> Simpan & Catat ke Kas</button>
    <a href="<?= base_url($role . '/pemasukan') ?>" class="btn btn-outline-secondary">Batal</a>
</div>
</form>
</div></div>
</div></div>
<?= $this->endSection() ?>
