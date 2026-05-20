<?php

namespace App\Models;

use CodeIgniter\Model;

class PembelianDetailModel extends Model
{
    protected $table            = 'pembelian_detail';
    protected $primaryKey       = 'id_detail';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_pembelian', 'id_produk', 'jumlah', 'harga_beli_satuan', 'subtotal'];

    public function getDetailByPembelian($id_pembelian)
    {
        return $this->select('pembelian_detail.*, produk.nama_produk')
                    ->join('produk', 'produk.id_produk = pembelian_detail.id_produk', 'left')
                    ->where('id_pembelian', $id_pembelian)
                    ->findAll();
    }
}
