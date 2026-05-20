<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-title">
    <div><h4><i class="bi bi-cart-plus me-2 text-primary"></i><?= esc($title) ?></h4></div>
    <a href="<?= base_url($role . '/transaksi') ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<form action="<?= base_url($role . '/transaksi/store') ?>" method="POST" id="formTransaksi">
<?= csrf_field() ?>

<div class="row g-4">
    <!-- Kiri: Form Header -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header"><i class="bi bi-info-circle me-2"></i>Informasi Transaksi</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Pelanggan <span class="text-danger">*</span></label>
                    <select name="id_pelanggan" class="form-select" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        <?php foreach ($pelanggan as $p): ?>
                        <option value="<?= $p['id_pelanggan'] ?>" <?= old('id_pelanggan') == $p['id_pelanggan'] ? 'selected' : '' ?>>
                            <?= esc($p['nama_pelanggan']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control"
                           value="<?= old('tanggal', date('Y-m-d')) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="2"
                              placeholder="Catatan transaksi..."><?= old('keterangan') ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Kanan: Item Produk -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-box-seam me-2"></i>Daftar Produk</span>
                <button type="button" class="btn btn-success btn-sm"
                        onclick='addItemRow(<?= json_encode($produk) ?>)'>
                    <i class="bi bi-plus-lg me-1"></i> Tambah Produk
                </button>
            </div>
            <div class="card-body">
                <div id="itemsContainer">
                    <!-- Items akan ditambah via JS -->
                </div>
                <div id="emptyItems" class="text-center text-muted py-4">
                    <i class="bi bi-cart-plus fs-2 d-block mb-2"></i>
                    Klik "Tambah Produk" untuk mulai input
                </div>
            </div>
        </div>

        <!-- Total Section -->
        <div class="total-section mt-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Grand Total</div>
                    <div id="grandTotal" class="fs-2 fw-bold text-primary">Rp 0</div>
                </div>
                <button type="submit" class="btn btn-primary btn-lg" id="btnSubmit">
                    <i class="bi bi-save me-2"></i> Simpan Transaksi
                </button>
            </div>
        </div>
    </div>
</div>

</form>

<script>
// Observer untuk sembunyikan/tampilkan pesan kosong
const observer = new MutationObserver(function() {
    const container = document.getElementById('itemsContainer');
    const emptyMsg  = document.getElementById('emptyItems');
    if (container && emptyMsg) {
        emptyMsg.style.display = container.children.length === 0 ? 'block' : 'none';
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('itemsContainer');
    if (container) {
        observer.observe(container, { childList: true });
    }

    // Tambah 1 row otomatis
    setTimeout(function() {
        addItemRow(<?= json_encode($produk) ?>);
    }, 100);
});
</script>

<?= $this->endSection() ?>
