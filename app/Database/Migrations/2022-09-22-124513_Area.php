<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Area extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 4,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'path' => [
                'type' => 'TEXT',
            ],
            'enabled' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => '1',
            ],
            'ref_polygon' => [
                'type'       => 'INT',
                'constraint' => 9,
            ],
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'id_cluster' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'desk' => [
                'type' => 'TEXT',
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('area', true);
    }

    public function down()
    {
        $this->forge->dropTable('area');
    }
}
