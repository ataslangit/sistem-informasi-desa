<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Config extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'auto_increment' => true,
            ],
            'nama_desa' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'kode_desa' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'nama_kepala_desa' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'nip_kepala_desa' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'kode_pos' => [
                'type'       => 'VARCHAR',
                'constraint' => 6,
            ],
            'nama_kecamatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'kode_kecamatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'nama_kepala_camat' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'nip_kepala_camat' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'nama_kabupaten' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'nama_propinsi' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'kode_propinsi' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'kode_propinsi' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'logo' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'lat' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'lng' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'zoom' => [
                'type'       => 'TINYINT',
                'constraint' => 4,
            ],
            'map_tipe' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'path' => [
                'type' => 'TEXT',
            ],
            'alamat_kantor' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'g_analytic' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'regid' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
            ],
            'macid' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
            ],
            'email_desa' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'gapi_key' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('config', true);
    }

    public function down()
    {
        $this->forge->dropTable('config');
    }
}
