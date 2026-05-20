<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_produk' => 'Batik Tulis Mega Mendung Biru',
                'kategori'    => 'Batik Tulis',
                'harga'       => 350000,
                'stok'        => 25,
                'deskripsi'   => 'Batik tulis motif mega mendung khas Cirebon dengan warna biru yang elegan. Bahan katun prima.',
                'gambar'      => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'nama_produk' => 'Batik Cap Parang Klasik Coklat',
                'kategori'    => 'Batik Cap',
                'harga'       => 175000,
                'stok'        => 40,
                'deskripsi'   => 'Batik cap motif parang dengan warna coklat klasik. Cocok untuk acara formal maupun semi-formal.',
                'gambar'      => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'nama_produk' => 'Batik Print Kawung Modern',
                'kategori'    => 'Batik Print',
                'harga'       => 120000,
                'stok'        => 60,
                'deskripsi'   => 'Batik print motif kawung dengan sentuhan modern. Bahan rayon yang adem dan nyaman.',
                'gambar'      => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'nama_produk' => 'Batik Tulis Lereng Sogan Premium',
                'kategori'    => 'Batik Tulis',
                'harga'       => 480000,
                'stok'        => 15,
                'deskripsi'   => 'Batik tulis motif lereng dengan warna sogan (kecoklatan). Kualitas premium bahan sutra.',
                'gambar'      => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'nama_produk' => 'Batik Kombinasi Truntum Hijau',
                'kategori'    => 'Batik Kombinasi',
                'harga'       => 250000,
                'stok'        => 30,
                'deskripsi'   => 'Batik kombinasi motif truntum dengan warna hijau segar. Perpaduan teknik tulis dan cap.',
                'gambar'      => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('produk')->insertBatch($data);
    }
}
