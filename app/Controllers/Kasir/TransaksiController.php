<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;
use App\Models\TransaksiModel;
use App\Models\PenjualanDetailModel;
use App\Models\ProdukModel;
use App\Models\PelangganModel;

class TransaksiController extends BaseController
{
    protected TransaksiModel $model;
    protected PenjualanDetailModel $detailModel;
    protected ProdukModel $produkModel;
    protected PelangganModel $pelangganModel;

    public function __construct()
    {
        $this->model          = new TransaksiModel();
        $this->detailModel    = new PenjualanDetailModel();
        $this->produkModel    = new ProdukModel();
        $this->pelangganModel = new PelangganModel();
    }

    public function index()
    {
        return view('transaksi/index', [
            'title'     => 'Data Transaksi',
            'role'      => 'kasir',
            'transaksi' => $this->model->getTransaksiWithPelanggan(),
        ]);
    }

    public function create()
    {
        return view('transaksi/create', [
            'title'     => 'Transaksi Baru',
            'role'      => 'kasir',
            'pelanggan' => $this->pelangganModel->orderBy('nama_pelanggan', 'ASC')->findAll(),
            'produk'    => $this->produkModel->where('stok >', 0)->orderBy('nama_produk', 'ASC')->findAll(),
        ]);
    }

    public function getProduk(int $id)
    {
        $produk = $this->produkModel->find($id);
        return $this->response->setJSON($produk);
    }

    public function store()
    {
        if (!$this->validate([
            'id_pelanggan' => 'required|integer',
            'tanggal'      => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $produkIds = $this->request->getPost('produk_id');
        $jumlahArr = $this->request->getPost('jumlah');

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

            $qty = (int)$jumlahArr[$idx];
            if ($produk['stok'] < $qty) {
                $db->transRollback();
                return redirect()->back()->withInput()->with('error', "Stok '{$produk['nama_produk']}' tidak mencukupi. Tersedia: {$produk['stok']}");
            }

            $subtotal = $produk['harga'] * $qty;
            $total   += $subtotal;

            $details[] = [
                'id_produk'    => $id_produk,
                'jumlah'       => $qty,
                'harga_satuan' => $produk['harga'],
                'subtotal'     => $subtotal,
            ];
        }

        $id_transaksi = $this->model->insert([
            'id_pelanggan' => $this->request->getPost('id_pelanggan'),
            'id_user'      => session()->get('id'),
            'tanggal'      => $this->request->getPost('tanggal'),
            'total'        => $total,
            'status'       => 'selesai',
            'keterangan'   => $this->request->getPost('keterangan'),
        ], true);

        foreach ($details as $detail) {
            $detail['id_transaksi'] = $id_transaksi;
            $this->detailModel->insert($detail);
            $this->produkModel->kurangiStok($detail['id_produk'], $detail['jumlah']);
        }

        // --- Otomatis Catat Pemasukan ---
        $pemasukanModel = new \App\Models\PemasukanModel();
        $pemasukanModel->insertWithKas([
            'tanggal'    => $this->request->getPost('tanggal'),
            'keterangan' => 'Penjualan Transaksi #' . $id_transaksi,
            'jumlah'     => $total,
            'kategori'   => 'Penjualan',
        ]);

        $db->transComplete();

        if (!$db->transStatus()) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan transaksi.');
        }

        return redirect()->to('/kasir/transaksi')->with('success', 'Transaksi berhasil disimpan.');
    }

    public function show(int $id)
    {
        $transaksi = $this->model->getTransaksiDetail($id);
        if (!$transaksi) return redirect()->to('/kasir/transaksi')->with('error', 'Transaksi tidak ditemukan.');

        return view('transaksi/show', [
            'title'     => 'Detail Transaksi #' . $id,
            'role'      => 'kasir',
            'transaksi' => $transaksi,
            'detail'    => $this->detailModel->getDetailByTransaksi($id),
        ]);
    }
}
