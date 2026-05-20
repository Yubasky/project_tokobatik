<?php

namespace App\Models;

use CodeIgniter\Model;

class TblKasModel extends Model
{
    protected $table            = 'tbl_kas';
    protected $primaryKey       = 'id_kas';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;
    protected $allowedFields    = ['tanggal', 'keterangan', 'jumlah', 'noref', 'created_at'];

    public function getSaldo(): float
    {
        $result = $this->selectSum('jumlah')->first();
        return (float)($result['jumlah'] ?? 0);
    }

    public function getRiwayat(?string $dari = null, ?string $sampai = null): array
    {
        $builder = $this->orderBy('tanggal', 'ASC')->orderBy('id_kas', 'ASC');
        if ($dari) {
            $builder->where('tanggal >=', $dari);
        }
        if ($sampai) {
            $builder->where('tanggal <=', $sampai);
        }
        return $builder->findAll();
    }

    public function getSaldoHingga(?string $sampai = null): float
    {
        $builder = $this->selectSum('jumlah');
        if ($sampai) {
            $builder->where('tanggal <=', $sampai);
        }
        $result = $builder->first();
        return (float)($result['jumlah'] ?? 0);
    }

    public function getTotalPemasukan(?string $bulan = null, ?string $tahun = null): float
    {
        $builder = $this->selectSum('jumlah')->where('jumlah >', 0);
        if ($bulan) $builder->where('MONTH(tanggal)', $bulan);
        if ($tahun) $builder->where('YEAR(tanggal)', $tahun);
        return (float)($builder->first()['jumlah'] ?? 0);
    }

    public function getTotalPengeluaran(?string $bulan = null, ?string $tahun = null): float
    {
        $builder = $this->selectSum('jumlah')->where('jumlah <', 0);
        if ($bulan) $builder->where('MONTH(tanggal)', $bulan);
        if ($tahun) $builder->where('YEAR(tanggal)', $tahun);
        return (float)($builder->first()['jumlah'] ?? 0);
    }
}
