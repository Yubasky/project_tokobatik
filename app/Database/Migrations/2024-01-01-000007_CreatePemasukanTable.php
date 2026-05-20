<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePemasukanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pemasukan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'keterangan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'jumlah' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0,
            ],
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
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
        $this->forge->addKey('id_pemasukan', true);
        $this->forge->createTable('pemasukan');
    }

    public function down()
    {
        $this->forge->dropTable('pemasukan');
    }
}
