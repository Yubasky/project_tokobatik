<?php

namespace App\Models;

use CodeIgniter\Model;

class PembelianModel extends Model
{
    protected $table            = 'pembelian';
    protected $primaryKey       = 'id_pembelian';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_user', 'tanggal', 'total_biaya', 'keterangan'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function getPembelianDetail($id)
    {
        return $this->select('pembelian.*, users.nama as nama_user')
                    ->join('users', 'users.id = pembelian.id_user', 'left')
                    ->where('pembelian.id_pembelian', $id)
                    ->first();
    }

    public function getPembelianLengkap()
    {
        return $this->select('pembelian.*, users.nama as nama_user')
                    ->join('users', 'users.id = pembelian.id_user', 'left')
                    ->orderBy('pembelian.tanggal', 'DESC')
                    ->orderBy('pembelian.id_pembelian', 'DESC')
                    ->findAll();
    }
}
