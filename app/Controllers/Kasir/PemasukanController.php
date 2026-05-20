<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;
use App\Models\PemasukanModel;

class PemasukanController extends BaseController
{
    protected PemasukanModel $model;

    public function __construct()
    {
        $this->model = new PemasukanModel();
    }

    public function index()
    {
        return view('pemasukan/index', [
            'title'     => 'Data Pemasukan',
            'role'      => 'kasir',
            'pemasukan' => $this->model->orderBy('tanggal', 'DESC')->findAll(),
        ]);
    }

    public function create()
    {
        return view('pemasukan/create', ['title' => 'Catat Pemasukan', 'role' => 'kasir']);
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

        return redirect()->to('/kasir/pemasukan')->with('success', 'Pemasukan berhasil dicatat.');
    }

    public function edit(int $id)
    {
        $p = $this->model->find($id);
        if (!$p) return redirect()->to('/kasir/pemasukan')->with('error', 'Data tidak ditemukan.');
        return view('pemasukan/edit', ['title' => 'Edit Pemasukan', 'role' => 'kasir', 'pemasukan' => $p]);
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

        return redirect()->to('/kasir/pemasukan')->with('success', 'Pemasukan berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $this->model->deleteWithKas($id);
        return redirect()->to('/kasir/pemasukan')->with('success', 'Pemasukan berhasil dihapus.');
    }
}
