<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function index()
    {
        return view('user/index', [
            'title' => 'Manajemen User',
            'role'  => 'admin',
            'users' => $this->model->orderBy('nama', 'ASC')->findAll(),
        ]);
    }

    public function create()
    {
        return view('user/create', ['title' => 'Tambah User', 'role' => 'admin']);
    }

    public function store()
    {
        if (!$this->validate([
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'nama'     => 'required',
            'role'     => 'required|in_list[admin,kasir]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama'     => $this->request->getPost('nama'),
            'role'     => $this->request->getPost('role'),
        ]);

        return redirect()->to('/admin/user')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $user = $this->model->find($id);
        if (!$user) return redirect()->to('/admin/user')->with('error', 'User tidak ditemukan.');
        return view('user/edit', ['title' => 'Edit User', 'role' => 'admin', 'user' => $user]);
    }

    public function update(int $id)
    {
        $rules = [
            'username' => "required|min_length[3]|is_unique[users.username,id,{$id}]",
            'nama'     => 'required',
            'role'     => 'required|in_list[admin,kasir]',
        ];

        $newPassword = $this->request->getPost('password');
        if (!empty($newPassword)) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'nama'     => $this->request->getPost('nama'),
            'role'     => $this->request->getPost('role'),
        ];

        if (!empty($newPassword)) {
            $data['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $this->model->skipValidation(true)->update($id, $data);
        return redirect()->to('/admin/user')->with('success', 'User berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        if ($id === (int)session()->get('id')) {
            return redirect()->to('/admin/user')->with('error', 'Tidak bisa menghapus akun sendiri.');
        }
        $this->model->delete($id);
        return redirect()->to('/admin/user')->with('success', 'User berhasil dihapus.');
    }
}
