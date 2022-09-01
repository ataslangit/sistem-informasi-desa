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
        $this->forge->addKey('id', true);
        $this->forge->addKey(['id_subjek', 'id_master', 'id_periode', 'id_klassifikasi']);
        $this->forge->createTable('analisis_partisipasi', true);
    }

    public function down()
    {
        $this->forge->dropTable('analisis_partisipasi');
    }
}
