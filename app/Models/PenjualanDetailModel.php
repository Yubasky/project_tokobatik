<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanDetailModel extends Model
{
    protected $table            = 'penjualan_detail';
    protected $primaryKey       = 'id_detail';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;
    protected $allowedFields    = ['id_transaksi', 'id_produk', 'jumlah', 'harga_satuan', 'subtotal'];

    public function getDetailByTransaksi(int $id_transaksi)
    {
        return $this->select('penjualan_detail.*, produk.nama_produk, produk.kategori')
                    ->join('produk', 'produk.id_produk = penjualan_detail.id_produk')
                    ->where('id_transaksi', $id_transaksi)
                    ->findAll();
    }
}
