<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AnalisisParameter extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'id_indikator' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'kode_jawaban' => [
                'type'       => 'INT',
                'constraint' => 3,
            ],
            'asign' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'default'    => '0',
            ],
            'jawaban' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'nilai' => [
                'type'       => 'TINYINT',
                'constraint' => 4,
                'default'    => '0',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('id_indikator');
        $this->forge->createTable('analisis_parameter', true);
    }

    public function down()
    {
        $this->forge->dropTable('analisis_parameter');
    }
}
