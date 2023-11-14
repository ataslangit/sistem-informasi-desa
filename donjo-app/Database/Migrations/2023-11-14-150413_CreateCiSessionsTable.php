<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCiSessionsTable extends Migration
{
    protected $DBGroup = 'default';

    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'VARCHAR', 'constraint' => 128, 'null' => false],
            'ip_address' => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => false],
            'timestamp timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL',
            'data' => ['type' => 'BLOB', 'null' => false],
        ]);
        $this->forge->addKey(['id', 'ip_address'], true);
        $this->forge->addKey('timestamp');
        $this->forge->createTable('sessions', true);
    }

    public function down()
    {
        $this->forge->dropTable('sessions', true);
    }
}
