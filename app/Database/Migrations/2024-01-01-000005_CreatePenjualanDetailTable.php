<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenjualanDetailTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_detail' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_transaksi' => [
                'type'     => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_produk' => [
                'type'     => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'jumlah' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 1,
            ],
            'harga_satuan' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0,
            ],
            'subtotal' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0,
            ],
        ]);
        $this->forge->addKey('id_detail', true);
        $this->forge->addForeignKey('id_transaksi', 'transaksi', 'id_transaksi', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_produk', 'produk', 'id_produk', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('penjualan_detail');
    }

    public function down()
    {
        $this->forge->dropTable('penjualan_detail');
    }
}
