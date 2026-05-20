<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProdukModel;

class ProdukController extends BaseController
{
    protected ProdukModel $model;

    public function __construct()
    {
        $this->model = new ProdukModel();
    }

    public function index()
    {
        return view('produk/index', [
            'title'  => 'Data Produk',
            'role'   => 'admin',
            'produk' => $this->model->orderBy('nama_produk', 'ASC')->findAll(),
        ]);
    }

    public function create()
    {
        return view('produk/create', ['title' => 'Tambah Produk', 'role' => 'admin']);
    }

    public function store()
    {
        $rules = [
            'nama_produk' => 'required|max_length[200]',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'kategori'    => 'permit_empty|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambar = $this->request->getFile('gambar');
        $namaGambar = null;

        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $namaGambar = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/uploads/produk', $namaGambar);
        }

        $this->model->insert([
            'nama_produk' => $this->request->getPost('nama_produk'),
            'kategori'    => $this->request->getPost('kategori'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'gambar'      => $namaGambar,
        ]);

        return redirect()->to('/admin/produk')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $produk = $this->model->find($id);
        if (!$produk) {
            return redirect()->to('/admin/produk')->with('error', 'Produk tidak ditemukan.');
        }
        return view('produk/edit', ['title' => 'Edit Produk', 'role' => 'admin', 'produk' => $produk]);
    }

    public function update(int $id)
    {
        $produk = $this->model->find($id);
        if (!$produk) {
            return redirect()->to('/admin/produk')->with('error', 'Produk tidak ditemukan.');
        }

        $rules = [
            'nama_produk' => 'required|max_length[200]',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambar = $this->request->getFile('gambar');
        $namaGambar = $produk['gambar'];

        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            // Hapus gambar lama
            if ($namaGambar && file_exists(ROOTPATH . 'public/uploads/produk/' . $namaGambar)) {
                unlink(ROOTPATH . 'public/uploads/produk/' . $namaGambar);
            }
            $namaGambar = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/uploads/produk', $namaGambar);
        }

        $this->model->update($id, [
            'nama_produk' => $this->request->getPost('nama_produk'),
            'kategori'    => $this->request->getPost('kategori'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'gambar'      => $namaGambar,
        ]);

        return redirect()->to('/admin/produk')->with('success', 'Produk berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $produk = $this->model->find($id);
        if (!$produk) {
            return redirect()->to('/admin/produk')->with('error', 'Produk tidak ditemukan.');
        }

        if ($produk['gambar'] && file_exists(ROOTPATH . 'public/uploads/produk/' . $produk['gambar'])) {
            unlink(ROOTPATH . 'public/uploads/produk/' . $produk['gambar']);
        }

        $this->model->delete($id);
        return redirect()->to('/admin/produk')->with('success', 'Produk berhasil dihapus.');
    }
}
