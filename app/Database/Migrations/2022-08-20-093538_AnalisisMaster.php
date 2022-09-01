<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AnalisisMaster extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 40,
            ],
            'subjek_type' => [
                'type'       => 'TINYINT',
                'constraint' => 4,
            ],
            'lock' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'default'    => '1',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'kode_analisis' => [
                'type'       => 'VARCHAR',
                'constraint' => 5,
                'default'    => '00000',
            ],
            'id_child' => [
                'type'       => 'SMALLINT',
                'constraint' => 4,
            ],
            'id_kelompok' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'pembagi' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('analisis_master', true);
    }

    public function down()
    {
        $this->forge->dropTable('analisis_master');
    }
}
