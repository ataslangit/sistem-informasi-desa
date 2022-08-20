<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AnalisisKlasifikasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'id_master' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'minval' => [
                'type'       => 'DOUBLE',
                'constraint' => '5,2',
            ],
            'maxval' => [
                'type'       => 'DOUBLE',
                'constraint' => '5,2',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('id_master');
        $this->forge->createTable('analisis_klasifikasi', true);
    }

    public function down()
    {
        $this->forge->dropTable('analisis_klasifikasi');
    }
}
