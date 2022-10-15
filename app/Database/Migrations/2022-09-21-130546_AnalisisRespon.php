<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AnalisisRespon extends Migration
{
    public function up()
    {
        // analisis_respon
        $this->forge->addField([
            'id_indikator' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'id_parameter' => [
                'type'       => 'INT',
                'constraint' => 4,
            ],
            'id_subjek' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'id_periode' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
        ]);

        $this->forge->createTable('analisis_respon', true);

        // analisis_respon_bukti
        $this->forge->addField([
            'id_master' => [
                'type'       => 'TINYINT',
                'constraint' => 4,
            ],
            'id_periode' => [
                'type'       => 'TINYINT',
                'constraint' => 4,
            ],
            'id_subjek' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'pengesahan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'tgl_update' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->createTable('analisis_respon_bukti', true);

        // analisis_respon_hasil
        $this->forge->addField([
            'id_master' => [
                'type'       => 'TINYINT',
                'constraint' => 4,
            ],
            'id_periode' => [
                'type'       => 'TINYINT',
                'constraint' => 4,
            ],
            'id_subjek' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'akumulasi' => [
                'type'       => 'DOUBLE',
                'constraint' => [8, 3],
            ],
            'tgl_update' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addUniqueKey(['id_master', 'id_periode', 'id_subjek']);
        $this->forge->createTable('analisis_respon_hasil', true);
    }

    public function down()
    {
        $this->forge->dropTable('analisis_respon');
        $this->forge->dropTable('analisis_respon_bukti');
        $this->forge->dropTable('analisis_respon_hasil');
    }
}
