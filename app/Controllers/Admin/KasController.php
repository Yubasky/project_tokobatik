<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TblKasModel;

class KasController extends BaseController
{
    protected TblKasModel $model;

    public function __construct()
    {
        $this->model = new TblKasModel();
    }

    public function index()
    {
        $dari   = $this->request->getGet('dari');
        $sampai = $this->request->getGet('sampai');

        $riwayat = $this->model->getRiwayat($dari, $sampai);
        $saldo   = $this->model->getSaldo();

        // Hitung saldo berjalan
        $saldoBerjalan = 0;
        foreach ($riwayat as &$row) {
            $saldoBerjalan += $row['jumlah'];
            $row['saldo_berjalan'] = $saldoBerjalan;
        }

        return view('kas/index', [
            'title'   => 'Laporan Kas',
            'role'    => 'admin',
            'riwayat' => $riwayat,
            'saldo'   => $saldo,
            'dari'    => $dari,
            'sampai'  => $sampai,
            'totalPemasukan'   => $this->model->getTotalPemasukan(date('m'), date('Y')),
            'totalPengeluaran' => abs($this->model->getTotalPengeluaran(date('m'), date('Y'))),
        ]);
    }

    public function filter()
    {
        return redirect()->to('/admin/kas?' . http_build_query([
            'dari'   => $this->request->getPost('dari'),
            'sampai' => $this->request->getPost('sampai'),
        ]));
    }
}
