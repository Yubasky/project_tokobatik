<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-title">
    <div>
        <h4><i class="bi bi-box-seam me-2 text-warning"></i><?= esc($title) ?></h4>
    </div>
    <a href="<?= base_url('admin/produk') ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-pencil-square me-2"></i>Edit Produk: <?= esc($produk['nama_produk']) ?>
            </div>
            <div class="card-body">
                <form action="<?= base_url('admin/produk/update/' . $produk['id_produk']) ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="nama_produk" class="form-control"
                                   value="<?= old('nama_produk', $produk['nama_produk']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <select name="kategori" class="form-select">
                                <option value="">-- Pilih Kategori --</option>
                                <?php $kats = ['Batik Tulis', 'Batik Cap', 'Batik Print', 'Batik Kombinasi', 'Batik Kontemporer'];
                                foreach ($kats as $k): ?>
                                <option value="<?= $k ?>" <?= old('kategori', $produk['kategori']) === $k ? 'selected' : '' ?>><?= $k ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="harga" class="form-control"
                                   value="<?= old('harga', $produk['harga']) ?>" min="0" step="500" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stok" class="form-control"
                                   value="<?= old('stok', $produk['stok']) ?>" min="0" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3"><?= old('deskripsi', $produk['deskripsi']) ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Gambar Produk</label>
                            <?php if ($produk['gambar']): ?>
                            <div class="mb-2">
                                <img src="<?= base_url('uploads/produk/' . $produk['gambar']) ?>"
                                     class="img-preview" alt="Gambar saat ini">
                                <small class="text-muted d-block mt-1">Gambar saat ini</small>
                            </div>
                            <?php endif; ?>
                            <input type="file" name="gambar" class="form-control" accept="image/*" onchange="previewGambar(this)">
                            <div class="mt-2" id="previewContainer" style="display:none;">
                                <img id="imgPreview" class="img-preview" alt="Preview baru">
                                <small class="text-muted d-block mt-1">Gambar baru</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save me-1"></i> Perbarui Produk
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
