<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PembelianModel;
use App\Models\PembelianDetailModel;
use App\Models\ProdukModel;
use App\Models\PengeluaranModel;

class PembelianController extends BaseController
{
    protected PembelianModel $model;
    protected PembelianDetailModel $detailModel;
    protected ProdukModel $produkModel;

    public function __construct()
    {
        $this->model       = new PembelianModel();
        $this->detailModel = new PembelianDetailModel();
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {
        return view('pembelian/index', [
            'title'     => 'Data Pembelian (Stok Masuk)',
            'role'      => 'admin',
            'pembelian' => $this->model->getPembelianLengkap(),
        ]);
    }

    public function create()
    {
        return view('pembelian/create', [
            'title'  => 'Catat Pembelian Baru',
            'role'   => 'admin',
            // Load all produk, no stok limit needed because we are buying
            'produk' => $this->produkModel->orderBy('nama_produk', 'ASC')->findAll(),
        ]);
    }

    public function store()
    {
        if (!$this->validate([
            'tanggal'      => 'required',
            'produk_id.*'  => 'required|integer',
            'jumlah.*'     => 'required|integer|greater_than[0]',
            'harga_beli.*' => 'required|numeric|greater_than_equal_to[0]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $produkIds = $this->request->getPost('produk_id');
        $jumlahArr = $this->request->getPost('jumlah');
        $hargaArr  = $this->request->getPost('harga_beli'); // user defines buying price

        if (empty($produkIds)) {
            return redirect()->back()->withInput()->with('error', 'Minimal 1 produk harus dipilih.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $total   = 0;
        $details = [];

        foreach ($produkIds as $idx => $id_produk) {
            $produk = $this->produkModel->find($id_produk);
            if (!$produk) continue;

            $qty   = (int)$jumlahArr[$idx];
            $harga = (float)$hargaArr[$idx];
            $subtotal = $harga * $qty;
            $total += $subtotal;

            $details[] = [
                'id_produk'         => $id_produk,
                'jumlah'            => $qty,
                'harga_beli_satuan' => $harga,
                'subtotal'          => $subtotal,
            ];
        }

        // 1. Simpan tabel pembelian
        $id_pembelian = $this->model->insert([
            'id_user'      => session()->get('id'),
            'tanggal'      => $this->request->getPost('tanggal'),
            'total_biaya'  => $total,
            'keterangan'   => $this->request->getPost('keterangan'),
        ], true);

        // 2. Simpan detail dan Tambah Stok
        foreach ($details as $detail) {
            $detail['id_pembelian'] = $id_pembelian;
            $this->detailModel->insert($detail);
            
            // Tambah stok ke tabel produk
            $produk = $this->produkModel->find($detail['id_produk']);
            $this->produkModel->update($detail['id_produk'], [
                'stok' => $produk['stok'] + $detail['jumlah']
            ]);
        }

        // 3. Otomatis Catat sebagai Pengeluaran
        if ($total > 0) {
            $pengeluaranModel = new PengeluaranModel();
            $pengeluaranModel->insertWithKas([
                'tanggal'    => $this->request->getPost('tanggal'),
                'keterangan' => 'Pembelian Stok Barang #' . $id_pembelian,
                'jumlah'     => $total,
                'kategori'   => 'Pembelian Stok',
            ]);
        }

        $db->transComplete();

        if (!$db->transStatus()) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan pembelian.');
        }

        return redirect()->to('/admin/pembelian')->with('success', 'Pembelian berhasil dicatat. Stok bertambah & Kas berkurang.');
    }

    public function show(int $id)
    {
        $pembelian = $this->model->getPembelianDetail($id);
        if (!$pembelian) return redirect()->to('/admin/pembelian')->with('error', 'Pembelian tidak ditemukan.');

        return view('pembelian/show', [
            'title'     => 'Detail Pembelian #' . $id,
            'role'      => 'admin',
            'pembelian' => $pembelian,
            'detail'    => $this->detailModel->getDetailByPembelian($id),
        ]);
    }

    public function delete(int $id)
    {
        // 1. Kembalikan (kurangi) stok sebelum hapus
        $details = $this->detailModel->where('id_pembelian', $id)->findAll();
        foreach ($details as $d) {
            $produk = $this->produkModel->find($d['id_produk']);
            if ($produk) {
                // Kurangi stok karena pembelian dibatalkan
                $this->produkModel->update($d['id_produk'], [
                    'stok' => max(0, $produk['stok'] - $d['jumlah'])
                ]);
            }
        }

        $this->model->delete($id);

        // 2. Hapus dari pengeluaran & Kas
        $pengeluaranModel = new PengeluaranModel();
        $pengeluaran = $pengeluaranModel->where('keterangan', 'Pembelian Stok Barang #' . $id)->first();
        if ($pengeluaran) {
            $pengeluaranModel->deleteWithKas($pengeluaran['id_pengeluaran']);
        }

        return redirect()->to('/admin/pembelian')->with('success', 'Pembelian berhasil dibatalkan. Stok dikurangi & Kas dikembalikan.');
    }
}
