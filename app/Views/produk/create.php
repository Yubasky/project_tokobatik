<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-title">
    <div>
        <h4><i class="bi bi-box-seam me-2 text-primary"></i><?= esc($title) ?></h4>
    </div>
    <a href="<?= base_url('admin/produk') ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-plus-circle me-2"></i>Form Tambah Produk
            </div>
            <div class="card-body">
                <form action="<?= base_url('admin/produk/store') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="nama_produk" class="form-control"
                                   value="<?= old('nama_produk') ?>" placeholder="Contoh: Batik Tulis Mega Mendung" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <select name="kategori" class="form-select">
                                <option value="">-- Pilih Kategori --</option>
                                <?php $kats = ['Batik Tulis', 'Batik Cap', 'Batik Print', 'Batik Kombinasi', 'Batik Kontemporer'];
                                foreach ($kats as $k): ?>
                                <option value="<?= $k ?>" <?= old('kategori') === $k ? 'selected' : '' ?>><?= $k ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="harga" class="form-control"
                                   value="<?= old('harga') ?>" min="0" step="500" placeholder="150000" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stok" class="form-control"
                                   value="<?= old('stok', 0) ?>" min="0" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3"
                                      placeholder="Deskripsi produk batik..."><?= old('deskripsi') ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Gambar Produk</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*" onchange="previewGambar(this)">
                            <div class="mt-2" id="previewContainer" style="display:none;">
                                <img id="imgPreview" class="img-preview" alt="Preview">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Produk
                        </button>
                        <a href="<?= base_url('admin/produk') ?>" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewGambar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imgPreview').src = e.target.result;
            document.getElementById('previewContainer').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?= $this->endSection() ?>
