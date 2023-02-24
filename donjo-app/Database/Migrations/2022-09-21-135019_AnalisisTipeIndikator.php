<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AnalisisTipeIndikator extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'TINYINT',
                'constraint'     => 4,
                'auto_increment' => true,
            ],
            'tipe' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('analisis_tipe_indikator', true);
    }

    public function down()
    {
        $this->forge->dropTable('analisis_tipe_indikator');
    }
}
