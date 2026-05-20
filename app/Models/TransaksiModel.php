<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id_transaksi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_pelanggan', 'id_user', 'tanggal', 'total', 'status', 'keterangan'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $validationRules = [
        'id_pelanggan' => 'required|integer',
        'tanggal'      => 'required|valid_date',
        'total'        => 'required|numeric',
    ];

    public function getTransaksiWithPelanggan()
    {
        return $this->select('transaksi.*, pelanggan.nama_pelanggan, users.nama as nama_kasir')
                    ->join('pelanggan', 'pelanggan.id_pelanggan = transaksi.id_pelanggan')
                    ->join('users', 'users.id = transaksi.id_user')
                    ->orderBy('transaksi.created_at', 'DESC')
                    ->findAll();
    }

    public function getTransaksiDetail(int $id)
    {
        return $this->select('transaksi.*, pelanggan.nama_pelanggan, pelanggan.telepon, users.nama as nama_kasir')
                    ->join('pelanggan', 'pelanggan.id_pelanggan = transaksi.id_pelanggan')
                    ->join('users', 'users.id = transaksi.id_user')
                    ->where('transaksi.id_transaksi', $id)
                    ->first();
    }

    public function getTodaySales()
    {
        return $this->selectSum('total')
                    ->where('tanggal', date('Y-m-d'))
                    ->first()['total'] ?? 0;
    }

    public function getMonthlySales()
    {
        return $this->selectSum('total')
                    ->where('MONTH(tanggal)', date('m'))
                    ->where('YEAR(tanggal)', date('Y'))
                    ->first()['total'] ?? 0;
    }
}
