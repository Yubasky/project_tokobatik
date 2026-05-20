<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePembelianTables extends Migration
{
    public function up()
    {
        // 1. Table `pembelian` (Parent)
        $this->forge->addField([
            'id_pembelian' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'total_biaya' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0,
            ],
            'keterangan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_pembelian', true);
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('pembelian');

        // 2. Table `pembelian_detail` (Child)
        $this->forge->addField([
            'id_detail' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_pembelian' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'id_produk' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'jumlah' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 1,
            ],
            'harga_beli_satuan' => [
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
        $this->forge->addForeignKey('id_pembelian', 'pembelian', 'id_pembelian', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_produk', 'produk', 'id_produk', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('pembelian_detail');
    }

    public function down()
    {
        $this->forge->dropTable('pembelian_detail');
        $this->forge->dropTable('pembelian');
    }
}
