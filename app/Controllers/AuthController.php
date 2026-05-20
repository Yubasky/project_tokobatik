<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function index()
    {
        if (session()->get('isLoggedIn')) {
            return $this->redirectByRole();
        }
        return view('auth/login');
    }

    public function login()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model    = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->findByUsername($username);

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Username atau password salah.');
        }

        $sessionData = [
            'isLoggedIn' => true,
            'id'         => $user['id'],
            'username'   => $user['username'],
            'nama'       => $user['nama'],
            'role'       => $user['role'],
        ];

        session()->set($sessionData);

        return $this->redirectByRole();
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Berhasil logout.');
    }

    private function redirectByRole()
    {
        $role = session()->get('role');
        if ($role === 'admin') {
            return redirect()->to('/admin/dashboard');
        }
        return redirect()->to('/kasir/dashboard');
    }
}
