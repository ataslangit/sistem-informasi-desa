<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Artikel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'gambar' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'isi' => [
                'type' => 'TEXT',
            ],
            'enabled' => [
                'type'       => 'INT',
                'constraint' => 2,
                'default'    => '1',
            ],
            'tgl_upload' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('TIMESTAMP'),
            ],
            'id_kategori' => [
                'type'       => 'INT',
                'constraint' => 4,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 4,
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'headline' => [
                'type'       => 'INT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'gambar1' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'gambar2' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'gambar3' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'dokumen' => [
                'type'       => 'VARCHAR',
                'constraint' => 400,
            ],
            'link_dokumen' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('artikel', true);
    }

    public function down()
    {
        $this->forge->dropTable('artikel');
    }
}
