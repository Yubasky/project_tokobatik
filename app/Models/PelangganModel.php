<?php

namespace App\Models;

use CodeIgniter\Model;

class PelangganModel extends Model
{
    protected $table            = 'pelanggan';
    protected $primaryKey       = 'id_pelanggan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_pelanggan', 'alamat', 'telepon'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $validationRules = [
        'nama_pelanggan' => 'required|max_length[150]',
        'telepon'        => 'permit_empty|max_length[20]',
    ];

    protected $validationMessages = [
        'nama_pelanggan' => [
            'required' => 'Nama pelanggan wajib diisi.',
        ],
    ];
}
