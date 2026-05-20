<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PelangganModel;

class PelangganController extends BaseController
{
    protected PelangganModel $model;

    public function __construct()
    {
        $this->model = new PelangganModel();
    }

    public function index()
    {
        return view('pelanggan/index', [
            'title'     => 'Data Pelanggan',
            'role'      => 'admin',
            'pelanggan' => $this->model->orderBy('nama_pelanggan', 'ASC')->findAll(),
        ]);
    }

    public function create()
    {
        return view('pelanggan/create', ['title' => 'Tambah Pelanggan', 'role' => 'admin']);
    }

    public function store()
    {
        if (!$this->validate([
            'nama_pelanggan' => 'required|max_length[150]',
            'telepon'        => 'permit_empty|max_length[20]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'nama_pelanggan' => $this->request->getPost('nama_pelanggan'),
            'alamat'         => $this->request->getPost('alamat'),
            'telepon'        => $this->request->getPost('telepon'),
        ]);

        return redirect()->to('/admin/pelanggan')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $p = $this->model->find($id);
        if (!$p) return redirect()->to('/admin/pelanggan')->with('error', 'Pelanggan tidak ditemukan.');
        return view('pelanggan/edit', ['title' => 'Edit Pelanggan', 'role' => 'admin', 'pelanggan' => $p]);
    }

    public function update(int $id)
    {
        if (!$this->validate([
            'nama_pelanggan' => 'required|max_length[150]',
            'telepon'        => 'permit_empty|max_length[20]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'nama_pelanggan' => $this->request->getPost('nama_pelanggan'),
            'alamat'         => $this->request->getPost('alamat'),
            'telepon'        => $this->request->getPost('telepon'),
        ]);

        return redirect()->to('/admin/pelanggan')->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/pelanggan')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
