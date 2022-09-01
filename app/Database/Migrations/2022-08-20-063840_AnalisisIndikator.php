<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AnalisisIndikator extends Migration
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
            'nomor' => [
                'type'       => 'INT',
                'constraint' => 3,
            ],
            'pertanyaan' => [
                'type'       => 'VARCHAR',
                'constraint' => 400,
            ],
            'id_tipe' => [
                'type'       => 'TINYINT',
                'constraint' => 4,
                'default'    => '1',
            ],
            'bobot' => [
                'type'       => 'TINYINT',
                'constraint' => 4,
                'default'    => '0',
            ],
            'act_analisis' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => '2',
            ],
            'id_kategori' => [
                'type'       => 'TINYINT',
                'constraint' => 4,
            ],
            'is_publik' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['id_master', 'id_tipe', 'id_kategori']);
        $this->forge->createTable('analisis_indikator', true);
    }

    public function down()
    {
        $this->forge->dropTable('analisis_indikator');
    }
}
