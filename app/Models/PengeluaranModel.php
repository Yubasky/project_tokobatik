<?php

namespace App\Models;

use CodeIgniter\Model;

class PengeluaranModel extends Model
{
    protected $table            = 'pengeluaran';
    protected $primaryKey       = 'id_pengeluaran';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['tanggal', 'keterangan', 'jumlah', 'kategori'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $validationRules = [
        'tanggal'    => 'required|valid_date',
        'keterangan' => 'required|max_length[255]',
        'jumlah'     => 'required|numeric|greater_than[0]',
    ];

    protected $validationMessages = [
        'tanggal'    => ['required' => 'Tanggal wajib diisi.', 'valid_date' => 'Format tanggal tidak valid.'],
        'keterangan' => ['required' => 'Keterangan wajib diisi.'],
        'jumlah'     => ['required' => 'Jumlah wajib diisi.', 'numeric' => 'Jumlah harus berupa angka.', 'greater_than' => 'Jumlah harus lebih dari 0.'],
    ];

    /**
     * Override insert: otomatis catat ke tbl_kas dengan jumlah NEGATIF
     */
    public function insertWithKas(array $data): bool|int
    {
        $this->db->transStart();

        $insertId = $this->insert($data, true);

        if ($insertId) {
            $kasModel = new TblKasModel();
            $kasModel->insert([
                'tanggal'    => $data['tanggal'],
                'keterangan' => $data['keterangan'],
                'jumlah'     => -abs($data['jumlah']),  // NEGATIF untuk pengeluaran
                'noref'      => 'OUT-' . $insertId,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        $this->db->transComplete();
        return $this->db->transStatus() ? $insertId : false;
    }

    /**
     * Update pengeluaran dan update entri kas terkait
     */
    public function updateWithKas(int $id, array $data): bool
    {
        $this->db->transStart();

        $this->update($id, $data);

        $kasModel = new TblKasModel();
        $kasModel->where('noref', 'OUT-' . $id)->set([
            'tanggal'    => $data['tanggal'],
            'keterangan' => $data['keterangan'],
            'jumlah'     => -abs($data['jumlah']),  // tetap NEGATIF
        ])->update();

        $this->db->transComplete();
        return $this->db->transStatus();
    }

    /**
     * Delete pengeluaran dan hapus entri kas terkait
     */
    public function deleteWithKas(int $id): bool
    {
        $this->db->transStart();

        $kasModel = new TblKasModel();
        $kasModel->where('noref', 'OUT-' . $id)->delete();

        $this->delete($id);

        $this->db->transComplete();
        return $this->db->transStatus();
    }

    public function getTotalBulanIni(): float
    {
        $result = $this->selectSum('jumlah')
                       ->where('MONTH(tanggal)', date('m'))
                       ->where('YEAR(tanggal)', date('Y'))
                       ->first();
        return (float)($result['jumlah'] ?? 0);
    }
}
