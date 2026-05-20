<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TransaksiModel;
use App\Models\ProdukModel;
use App\Models\PelangganModel;
use App\Models\TblKasModel;
use App\Models\PemasukanModel;
use App\Models\PengeluaranModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $transaksiModel   = new TransaksiModel();
        $produkModel      = new ProdukModel();
        $pelangganModel   = new PelangganModel();
        $kasModel         = new TblKasModel();
        $pemasukanModel   = new PemasukanModel();
        $pengeluaranModel = new PengeluaranModel();

        $data = [
            'title'             => 'Dashboard Admin',
            'role'              => 'admin',
            'totalPenjualanHariIni' => $transaksiModel->getTodaySales(),
            'totalPenjualanBulan'   => $transaksiModel->getMonthlySales(),
            'totalPemasukan'    => $pemasukanModel->getTotalBulanIni(),
            'totalPengeluaran'  => $pengeluaranModel->getTotalBulanIni(),
            'saldoKas'          => $kasModel->getSaldo(),
            'totalProduk'       => $produkModel->countAll(),
            'totalPelanggan'    => $pelangganModel->countAll(),
            'transaksiTerbaru'  => $transaksiModel->getTransaksiWithPelanggan(),
        ];

        // Ambil max 5 transaksi terbaru
        $data['transaksiTerbaru'] = array_slice($data['transaksiTerbaru'], 0, 5);

        return view('dashboard/index', $data);
    }
}
