<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AnalisisPeriode extends Migration
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
                'constraint' => 50,
            ],
            'id_state' => [
                'type'       => 'TINYINT',
                'constraint' => '4',
                'default'    => '1',
            ],
            'aktif' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'default'    => '0',
            ],
            'keterangan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'tahun_pelaksanaan' => [
                'type'       => 'YEAR',
                'constraint' => 4,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('id_master');
        $this->forge->addKey('id_state');
        $this->forge->createTable('analisis_periode', true);
    }

    public function down()
    {
        $this->forge->dropTable('analisis_periode');
    }
}
