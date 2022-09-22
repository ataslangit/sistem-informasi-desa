<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AnalisisRefState extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'TINYINT',
                'constraint'     => 4,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 40,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('analisis_ref_state', true);
    }

    public function down()
    {
        $this->forge->dropTable('analisis_ref_state');
    }
}
