<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table            = 'produk';
    protected $primaryKey       = 'id_produk';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_produk', 'kategori', 'harga', 'stok', 'deskripsi', 'gambar'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $validationRules = [
        'nama_produk' => 'required|max_length[200]',
        'harga'       => 'required|numeric|greater_than[0]',
        'stok'        => 'required|integer|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'nama_produk' => ['required' => 'Nama produk wajib diisi.'],
        'harga'       => [
            'required'     => 'Harga wajib diisi.',
            'numeric'      => 'Harga harus berupa angka.',
            'greater_than' => 'Harga harus lebih dari 0.',
        ],
        'stok' => [
            'required'              => 'Stok wajib diisi.',
            'integer'               => 'Stok harus berupa angka bulat.',
            'greater_than_equal_to' => 'Stok tidak boleh negatif.',
        ],
    ];

    public function kurangiStok(int $id_produk, int $jumlah): bool
    {
        $produk = $this->find($id_produk);
        if (!$produk || $produk['stok'] < $jumlah) {
            return false;
        }
        return $this->update($id_produk, ['stok' => $produk['stok'] - $jumlah]);
    }
}
