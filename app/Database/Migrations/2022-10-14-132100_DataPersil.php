<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class DataPersil extends Migration
{
    public function up()
    {
        // tabel data_persil
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nik' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 128,
                'comment'    => 'nomer persil',
            ],
            'persil_jenis_id' => [
                'type'       => 'TINYINT',
                'constraint' => 2,
            ],
            'id_clusterdesa' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
            ],
            'alamat_ext' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
            ],
            'luas' => [
                'type'       => 'DECIMAL',
                'constraint' => '7,2',
            ],
            'kelas' => [
                'type'       => 'VARCHAR',
                'constraint' => 128,
                'default'    => null,
                'null'       => true,
            ],
            'peta' => [
                'type' => 'TEXT',
            ],
            'no_sppt_pbb' => [
                'type'       => 'VARCHAR',
                'constraint' => 128,
            ],
            'persil_peruntukan_id' => [
                'type'       => 'TINYINT',
                'constraint' => 2,
            ],
            'rdate' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'userID' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('nik');
        $this->forge->createTable('data_persil', true);

        // tabel data_persil_jenis
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 128,
            ],
            'ndesc' => [
                'type' => 'TEXT',
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('data_persil_jenis', true);

        // data persil_log
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'persil_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'persil_transaksi_jenis' => [
                'type'       => 'TINYINT',
                'constraint' => 2,
            ],
            'pemilik_lama' => [
                'type'       => 'VARCHAR',
                'constraint' => 24,
            ],
            'pemilik_baru' => [
                'type'       => 'VARCHAR',
                'constraint' => 24,
            ],
            'rdate' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $attr = ['COMMENT' => 'Tabel untuk menyimpan catatan transaksi atas data persil'];
        $this->forge->createTable('data_persil_log', true, $attr);

        // table data_persil_peruntukan
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 128,
            ],
            'ndesc' => [
                'type' => 'TEXT',
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('data_persil_peruntukan', true);
    }

    public function down()
    {
        $this->forge->dropTable('data_persil');
        $this->forge->dropTable('data_persil_jenis');
        $this->forge->dropTable('data_persil_peruntukan');
    }
}
