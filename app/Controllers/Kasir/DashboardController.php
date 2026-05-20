<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;
use App\Models\TransaksiModel;
use App\Models\TblKasModel;
use App\Models\PemasukanModel;
use App\Models\PengeluaranModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $transaksiModel   = new TransaksiModel();
        $kasModel         = new TblKasModel();
        $pemasukanModel   = new PemasukanModel();
        $pengeluaranModel = new PengeluaranModel();

        $data = [
            'title'                  => 'Dashboard Kasir',
            'role'                   => 'kasir',
            'totalPenjualanHariIni'  => $transaksiModel->getTodaySales(),
            'totalPenjualanBulan'    => $transaksiModel->getMonthlySales(),
            'totalPemasukan'         => $pemasukanModel->getTotalBulanIni(),
            'totalPengeluaran'       => $pengeluaranModel->getTotalBulanIni(),
            'saldoKas'               => $kasModel->getSaldo(),
            'transaksiTerbaru'       => array_slice($transaksiModel->getTransaksiWithPelanggan(), 0, 5),
        ];

        return view('dashboard/index', $data);
    }
}
