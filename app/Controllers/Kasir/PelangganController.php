<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;
use App\Models\PelangganModel;

class PelangganController extends BaseController
{
    public function index()
    {
        $model = new PelangganModel();
        return view('pelanggan/index', [
            'title'     => 'Data Pelanggan',
            'role'      => 'kasir',
            'pelanggan' => $model->orderBy('nama_pelanggan', 'ASC')->findAll(),
        ]);
    }
}
