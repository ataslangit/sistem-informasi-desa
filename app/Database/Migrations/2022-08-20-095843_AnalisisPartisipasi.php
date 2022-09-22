<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AnalisisPartisipasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'id_subjek' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'id_master' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'id_periode' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'id_klassifikasi' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => '1',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('id_subjek');
        $this->forge->addKey('id_master');
        $this->forge->addKey('id_periode');
        $this->forge->addKey('id_klassifikasi');
        $this->forge->createTable('analisis_partisipasi', true);
    }

    public function down()
    {
        $this->forge->dropTable('analisis_partisipasi');
    }
}
