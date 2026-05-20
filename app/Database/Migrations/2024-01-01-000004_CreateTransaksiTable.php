<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransaksiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_transaksi' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_pelanggan' => [
                'type'     => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_user' => [
                'type'     => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'total' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'selesai',
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addKey('id_transaksi', true);
        $this->forge->addForeignKey('id_pelanggan', 'pelanggan', 'id_pelanggan', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi');
    }
}
