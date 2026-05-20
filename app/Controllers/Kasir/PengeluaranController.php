<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;
use App\Models\PengeluaranModel;

class PengeluaranController extends BaseController
{
    protected PengeluaranModel $model;

    public function __construct()
    {
        $this->model = new PengeluaranModel();
    }

    public function index()
    {
        return view('pengeluaran/index', [
            'title'       => 'Data Pengeluaran',
            'role'        => 'kasir',
            'pengeluaran' => $this->model->orderBy('tanggal', 'DESC')->findAll(),
        ]);
    }

    public function create()
    {
        return view('pengeluaran/create', ['title' => 'Catat Pengeluaran', 'role' => 'kasir']);
    }

    public function store()
    {
        if (!$this->validate([
            'tanggal'    => 'required',
            'keterangan' => 'required|max_length[255]',
            'jumlah'     => 'required|numeric|greater_than[0]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insertWithKas([
            'tanggal'    => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'jumlah'     => $this->request->getPost('jumlah'),
            'kategori'   => $this->request->getPost('kategori'),
        ]);

        return redirect()->to('/kasir/pengeluaran')->with('success', 'Pengeluaran berhasil dicatat.');
    }

    public function edit(int $id)
    {
        $p = $this->model->find($id);
        if (!$p) return redirect()->to('/kasir/pengeluaran')->with('error', 'Data tidak ditemukan.');
        return view('pengeluaran/edit', ['title' => 'Edit Pengeluaran', 'role' => 'kasir', 'pengeluaran' => $p]);
    }

    public function update(int $id)
    {
        if (!$this->validate([
            'tanggal'    => 'required',
            'keterangan' => 'required|max_length[255]',
            'jumlah'     => 'required|numeric|greater_than[0]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->updateWithKas($id, [
            'tanggal'    => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'jumlah'     => $this->request->getPost('jumlah'),
            'kategori'   => $this->request->getPost('kategori'),
        ]);

        return redirect()->to('/kasir/pengeluaran')->with('success', 'Pengeluaran berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $this->model->deleteWithKas($id);
        return redirect()->to('/kasir/pengeluaran')->with('success', 'Pengeluaran berhasil dihapus.');
    }
}
