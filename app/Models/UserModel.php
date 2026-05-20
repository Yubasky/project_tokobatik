<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['username', 'password', 'nama', 'role'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username,id,{id}]',
        'nama'     => 'required|max_length[150]',
        'role'     => 'required|in_list[admin,kasir]',
    ];

    protected $validationMessages = [
        'username' => [
            'required'   => 'Username wajib diisi.',
            'is_unique'  => 'Username sudah digunakan.',
            'min_length' => 'Username minimal 3 karakter.',
        ],
        'nama' => [
            'required' => 'Nama wajib diisi.',
        ],
        'role' => [
            'required' => 'Role wajib dipilih.',
            'in_list'  => 'Role tidak valid.',
        ],
    ];

    public function findByUsername(string $username): ?array
    {
        return $this->where('username', $username)->first();
    }
}
