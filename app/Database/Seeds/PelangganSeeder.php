<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PelangganSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_pelanggan' => 'Siti Rahayu',
                'alamat'         => 'Jl. Merdeka No. 12, Bandung, Jawa Barat',
                'telepon'        => '081234567890',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'nama_pelanggan' => 'Budi Santoso',
                'alamat'         => 'Jl. Sudirman No. 45, Jakarta Pusat, DKI Jakarta',
                'telepon'        => '082198765432',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'nama_pelanggan' => 'Dewi Pertiwi',
                'alamat'         => 'Jl. Diponegoro No. 8, Yogyakarta, DIY',
                'telepon'        => '085612345678',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('pelanggan')->insertBatch($data);
    }
}
