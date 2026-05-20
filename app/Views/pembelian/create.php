<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-title">
    <div><h4><i class="bi bi-box-arrow-in-down me-2 text-danger"></i><?= esc($title) ?></h4></div>
    <a href="<?= base_url($role . '/pembelian') ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<form action="<?= base_url($role . '/pembelian/store') ?>" method="POST" id="formPembelian">
<?= csrf_field() ?>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card fade-in-up">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-cart-check me-2"></i>Daftar Barang Dibeli</span>
                <button type="button" class="btn btn-sm btn-primary" onclick="addPembelianRow(<?= htmlspecialchars(json_encode($produk)) ?>)">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Baris
                </button>
            </div>
            <div class="card-body">
                <div id="itemsContainer">
                    <!-- Dynamic rows go here -->
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card fade-in-up" style="animation-delay: 0.1s;">
            <div class="card-header"><i class="bi bi-info-circle me-2"></i>Info Pembelian</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Tanggal Beli <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan / Nama Supplier</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Beli dari Supplier A">
                </div>
                
                <div class="total-section mt-4 text-center pb-3">
                    <div class="text-muted mb-2 font-weight-bold">Total Pembayaran</div>
                    <h2 class="text-danger fw-bold m-0" id="grandTotal">Rp 0</h2>
                    <small>Akan mengurangi saldo kas</small>
                </div>

                <button type="submit" class="btn btn-danger w-100 mt-4 btn-lg">
                    <i class="bi bi-save me-2"></i>Simpan Pembelian
                </button>
            </div>
        </div>
    </div>
</div>
</form>

<script>
    // JS Logic specific to purchasing
    let itemCountRestock = 0;

    function addPembelianRow(produkList) {
        itemCountRestock++;
        const container = document.getElementById('itemsContainer');
        if (!container) return;

        const options = produkList.map(p =>
            `<option value="${p.id_produk}">${p.nama_produk}</option>`
        ).join('');

        const row = document.createElement('div');
        row.className = 'item-row';
        row.id = 'pembelian-item-' + itemCountRestock;
        row.innerHTML = `
            <div class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Produk</label>
                    <select name="produk_id[]" class="form-select" required>
                        <option value="">-- Pilih Produk --</option>
                        ${options}
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Harga Beli/Pcs</label>
                    <input type="number" name="harga_beli[]" class="form-control px-2 text-end text-danger fw-bold harga-beli-input" value="0" min="0" step="500" onchange="hitungSubtotalPembelian(this)" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Jumlah Masuk</label>
                    <input type="number" name="jumlah[]" class="form-control px-2 text-center text-primary fw-bold qty-beli-input" value="1" min="1" onchange="hitungSubtotalPembelian(this)" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Subtotal</label>
                    <input type="text" class="form-control px-2 text-end text-danger fw-bold subtotal-beli-display" readonly placeholder="Rp 0">
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-outline-danger btn-sm w-100" title="Hapus" onclick="document.getElementById('${row.id}').remove(); hitungTotalPembelian();">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(row);
        hitungTotalPembelian();
    }

    function hitungSubtotalPembelian(inputElement) {
        const row = inputElement.closest('.item-row');
        const harga = parseFloat(row.querySelector('.harga-beli-input').value) || 0;
        const qty = parseInt(row.querySelector('.qty-beli-input').value) || 0;
        
        const subtotal = harga * qty;
        row.querySelector('.subtotal-beli-display').value = formatRupiah(subtotal);
        hitungTotalPembelian();
    }

    function hitungTotalPembelian() {
        let total = 0;
        document.querySelectorAll('#itemsContainer .item-row').forEach(row => {
            const harga = parseFloat(row.querySelector('.harga-beli-input').value) || 0;
            const qty = parseInt(row.querySelector('.qty-beli-input').value) || 0;
            total += (harga * qty);
        });
        document.getElementById('grandTotal').textContent = formatRupiah(total);
    }

    // Initialize 1 row
    document.addEventListener('DOMContentLoaded', () => {
        addPembelianRow(<?= json_encode($produk) ?>);
    });
</script>

<?= $this->endSection() ?>
