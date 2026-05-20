/**
 * Butik Batik - Main JS
 */

// ─── Sidebar Toggle ─────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    const sidebar  = document.getElementById('sidebar');
    const main     = document.getElementById('mainContent');
    const toggle   = document.getElementById('sidebarToggle');

    if (toggle && sidebar && main) {
        toggle.addEventListener('click', function () {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('mobile-open');
            } else {
                sidebar.classList.toggle('collapsed');
                main.classList.toggle('expanded');
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            }
        });

        // Restore state
        if (window.innerWidth > 768 && localStorage.getItem('sidebarCollapsed') === 'true') {
            sidebar.classList.add('collapsed');
            main.classList.add('expanded');
        }
    }

    // Auto-dismiss alerts after 5s
    const alerts = document.querySelectorAll('.alert.alert-dismissible');
    alerts.forEach(function (alert) {
        setTimeout(function () {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            if (bsAlert) bsAlert.close();
        }, 5000);
    });
});

// ─── Rupiah Formatter ────────────────────────────────────────────────────────
function formatRupiah(angka) {
    return 'Rp ' + parseFloat(angka || 0).toLocaleString('id-ID', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });
}

// ─── Transaksi: Tambah Item Row ──────────────────────────────────────────────
let itemCount = 0;

function addItemRow(produkList) {
    itemCount++;
    const container = document.getElementById('itemsContainer');
    if (!container) return;

    const options = produkList.map(p =>
        `<option value="${p.id_produk}" data-harga="${p.harga}" data-stok="${p.stok}">${p.nama_produk} (Stok: ${p.stok})</option>`
    ).join('');

    const row = document.createElement('div');
    row.className = 'item-row';
    row.id = 'item-' + itemCount;
    row.innerHTML = `
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Produk</label>
                <select name="produk_id[]" class="form-select produk-select" onchange="onProdukChange(this)" required>
                    <option value="">-- Pilih Produk --</option>
                    ${options}
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Harga Satuan</label>
                <input type="text" class="form-control harga-display px-2 text-end fw-bold text-success" readonly placeholder="Rp 0">
            </div>
            <div class="col-md-1">
                <label class="form-label">Qty</label>
                <input type="number" name="jumlah[]" class="form-control qty-input px-2 text-center fw-bold text-primary" value="1" min="1" onchange="hitungSubtotal(this)" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Subtotal</label>
                <input type="text" class="form-control subtotal-display px-2 text-end fw-bold text-success" readonly placeholder="Rp 0">
            </div>
            <div class="col-md-1 text-end">
                <button type="button" class="btn btn-danger btn-sm w-100" title="Hapus Item" onclick="removeItemRow('item-${itemCount}')">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(row);
    hitungTotal();
}

function removeItemRow(id) {
    const el = document.getElementById(id);
    if (el) {
        el.remove();
        hitungTotal();
    }
}

function onProdukChange(select) {
    const option = select.selectedOptions[0];
    const row    = select.closest('.item-row');
    if (!row) return;

    const harga       = parseFloat(option?.dataset.harga || 0);
    const stok        = parseInt(option?.dataset.stok || 0);
    const qtyInput    = row.querySelector('.qty-input');
    const hargaDisp   = row.querySelector('.harga-display');
    const subtotalDisp = row.querySelector('.subtotal-display');

    if (harga > 0) {
        hargaDisp.value    = formatRupiah(harga);
        qtyInput.max       = stok;
        qtyInput.value     = 1;
        subtotalDisp.value = formatRupiah(harga);
        hargaDisp.dataset.harga = harga;
    } else {
        hargaDisp.value    = '';
        subtotalDisp.value = '';
    }
    hitungTotal();
}

function hitungSubtotal(qtyInput) {
    const row       = qtyInput.closest('.item-row');
    const hargaDisp = row.querySelector('.harga-display');
    const subtotal  = row.querySelector('.subtotal-display');
    const harga     = parseFloat(hargaDisp?.dataset.harga || 0);
    const qty       = parseInt(qtyInput.value || 0);

    subtotal.value = formatRupiah(harga * qty);
    hitungTotal();
}

function hitungTotal() {
    const rows     = document.querySelectorAll('.item-row');
    let total      = 0;

    rows.forEach(function (row) {
        const hargaDisp = row.querySelector('.harga-display');
        const qtyInput  = row.querySelector('.qty-input');
        const harga     = parseFloat(hargaDisp?.dataset.harga || 0);
        const qty       = parseInt(qtyInput?.value || 0);
        total += harga * qty;
    });

    const totalEl = document.getElementById('grandTotal');
    if (totalEl) totalEl.textContent = formatRupiah(total);

    const totalHidden = document.getElementById('totalHidden');
    if (totalHidden) totalHidden.value = total;
}
