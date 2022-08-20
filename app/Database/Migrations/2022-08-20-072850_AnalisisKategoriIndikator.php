<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AnalisisKategoriIndikator extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'TINYINT',
                'constraint'     => 4,
                'auto_increment' => true,
            ],
            'id_master' => [
                'type'       => 'INT',
                'constraint' => 4,
            ],
            'kategori_kode' => [
                'type'       => 'VARCHAR',
                'constraint' => 3,
            ],
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('id_master');
        $this->forge->createTable('analisis_kategori_indikator', true);
    }

    public function down()
    {
        $this->forge->dropTable('analisis_kategori_indikator');
    }
}
