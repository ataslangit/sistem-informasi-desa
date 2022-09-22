<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AnalisisRefSubjek extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'TINYINT',
                'constraint'     => 4,
                'auto_increment' => true,
            ],
            'subjek' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('analisis_ref_subjek', true);
    }

    public function down()
    {
        $this->forge->dropTable('analisis_ref_subjek');
    }
}
