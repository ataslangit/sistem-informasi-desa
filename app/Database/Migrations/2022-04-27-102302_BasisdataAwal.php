<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BasisdataAwal extends Migration
{
    public function up()
    {
        //# Create Table analisis_indikator
        $fields = [
            'id'           => ['type' => 'INT', 'auto_increment' => true],
            'id_master'    => ['type' => 'INT'],
            'nomor'        => ['type' => 'INT'],
            'pertanyaan'   => ['type' => 'VARCHAR', 'constraint' => 400],
            'id_tipe'      => ['type' => 'TINYINT', 'default' => '1'],
            'bobot'        => ['type' => 'TINYINT'],
            'act_analisis' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => '2'],
            'id_kategori'  => ['type' => 'TINYINT'],
            'is_publik'    => ['type' => 'TINYINT', 'constraint' => 1],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['id_master', 'id_tipe', 'id_kategori']);
        $this->forge->createTable('analisis_indikator', true);

        //# Create Table analisis_kategori_indikator
        $fields = [
            'id'            => ['type' => 'TINYINT', 'auto_increment' => true],
            'id_master'     => ['type' => 'TINYINT'],
            'kategori_kode' => ['type' => 'VARCHAR', 'constraint' => 3],
            'kategori'      => ['type' => 'VARCHAR', 'constraint' => 50],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['id_master']);
        $this->forge->createTable('analisis_kategori_indikator', true);

        //# Create Table analisis_klasifikasi
        $fields = [
            'id'        => ['type' => 'INT', 'auto_increment' => true],
            'id_master' => ['type' => 'INT'],
            'nama'      => ['type' => 'VARCHAR', 'constraint' => 20],
            'minval'    => ['type' => 'DOUBLE', 'constraint' => '5,2'],
            'maxval'    => ['type' => 'DOUBLE', 'constraint' => '5,2'],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['id_master']);
        $this->forge->createTable('analisis_klasifikasi', true);

        //# Create Table analisis_master
        $fields = [
            'id'            => ['type' => 'INT', 'auto_increment' => true],
            'nama'          => ['type' => 'VARCHAR', 'constraint' => 40],
            'subjek_tipe'   => ['type' => 'TINYINT'],
            'lock'          => ['type' => 'TINYINT', 'constraint' => 1, 'default' => '1'],
            'deskripsi'     => ['type' => 'TEXT'],
            'kode_analisis' => ['type' => 'VARCHAR', 'constraint' => 5, 'default' => '00000'],
            'id_child'      => ['type' => 'SMALLINT'],
            'id_kelompok'   => ['type' => 'INT'],
            'pembagi'       => ['type' => 'VARCHAR', 'constraint' => '10', 'default' => '100'],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable('analisis_master', true);

        //# Create Table analisis_parameter
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('id_indikator int NOT NULL');
        $this->forge->addField('kode_jawaban int NOT NULL');
        $this->forge->addField('asign tinyint(1) NOT NULL');
        $this->forge->addField('jawaban varchar(200) NOT NULL');
        $this->forge->addField('nilai tinyint NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->addKey(['id_indikator']);
        $this->forge->createTable('analisis_parameter', true);

        //# Create Table analisis_partisipasi
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('id_subjek int NOT NULL');
        $this->forge->addField('id_master int NOT NULL');
        $this->forge->addField('id_periode int NOT NULL');
        $this->forge->addField("id_klassifikasi int NOT NULL DEFAULT '1'");
        $this->forge->addKey('id', true);
        $this->forge->addKey(['id_subjek', 'id_master', 'id_periode', 'id_klassifikasi']);
        $this->forge->createTable('analisis_partisipasi', true);

        //# Create Table analisis_periode
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('id_master int NOT NULL');
        $this->forge->addField('nama varchar(50) NOT NULL');
        $this->forge->addField("id_state tinyint NOT NULL DEFAULT '1'");
        $this->forge->addField('aktif tinyint(1) NOT NULL');
        $this->forge->addField('keterangan varchar(100) NOT NULL');
        $this->forge->addField('tahun_pelaksanaan year NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->addKey(['id_master', 'id_state']);
        $this->forge->createTable('analisis_periode', true);

        //# Create Table analisis_ref_state
        $this->forge->addField('id tinyint NOT NULL auto_increment');
        $this->forge->addField('nama varchar(40) NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('analisis_ref_state', true);

        //# Create Table analisis_ref_subjek
        $this->forge->addField('id tinyint NOT NULL auto_increment');
        $this->forge->addField('subjek varchar(20) NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('analisis_ref_subjek', true);

        //# Create Table analisis_respon
        $this->forge->addField('id_indikator int NOT NULL');
        $this->forge->addField('id_parameter int NOT NULL');
        $this->forge->addField('id_subjek int NOT NULL');
        $this->forge->addField('id_periode int NOT NULL');
        $this->forge->createTable('analisis_respon', true);

        //# Create Table analisis_respon_bukti
        $this->forge->addField('id_master tinyint NOT NULL');
        $this->forge->addField('id_periode tinyint NOT NULL');
        $this->forge->addField('id_subjek int NOT NULL');
        $this->forge->addField('pengesahan varchar(100) NOT NULL');
        $this->forge->addField('tgl_update timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->forge->createTable('analisis_respon_bukti', true);

        //# Create Table analisis_respon_hasil
        $this->forge->addField('id_master tinyint NOT NULL');
        $this->forge->addField('id_periode tinyint NOT NULL');
        $this->forge->addField('id_subjek int NOT NULL');
        $this->forge->addField('akumulasi double(8,3) NOT NULL');
        $this->forge->addField('tgl_update timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addKey(['id_master', 'id_periode', 'id_subjek']);
        $this->forge->createTable('analisis_respon_hasil', true);

        //# Create Table analisis_tipe_indikator
        $this->forge->addField('id tinyint NOT NULL auto_increment');
        $this->forge->addField('tipe varchar(20) NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('analisis_tipe_indikator', true);

        //# Create Table area
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('nama varchar(50) NOT NULL');
        $this->forge->addField('path text NOT NULL');
        $this->forge->addField("enabled int NOT NULL DEFAULT '1'");
        $this->forge->addField('ref_polygon int NOT NULL');
        $this->forge->addField('foto varchar(100) NOT NULL');
        $this->forge->addField('id_cluster int NOT NULL');
        $this->forge->addField('desk text NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('area', true);

        //# Create Table artikel
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('gambar varchar(200) NOT NULL');
        $this->forge->addField('isi text NOT NULL');
        $this->forge->addField("enabled int NOT NULL DEFAULT '1'");
        $this->forge->addField('tgl_upload timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('id_kategori int NOT NULL');
        $this->forge->addField('id_user int NOT NULL');
        $this->forge->addField('judul varchar(100) NOT NULL');
        $this->forge->addField('headline int NOT NULL');
        $this->forge->addField('gambar1 varchar(200) NOT NULL');
        $this->forge->addField('gambar2 varchar(200) NOT NULL');
        $this->forge->addField('gambar3 varchar(200) NOT NULL');
        $this->forge->addField('dokumen varchar(400) NOT NULL');
        $this->forge->addField('link_dokumen varchar(200) NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('artikel', true);

        //# Create Table config
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('nama_desa varchar(100) NOT NULL');
        $this->forge->addField('kode_desa varchar(100) NOT NULL');
        $this->forge->addField('nama_kepala_desa varchar(100) NOT NULL');
        $this->forge->addField('nip_kepala_desa varchar(100) NOT NULL');
        $this->forge->addField('kode_pos varchar(6) NOT NULL');
        $this->forge->addField('nama_kecamatan varchar(100) NOT NULL');
        $this->forge->addField('kode_kecamatan varchar(100) NOT NULL');
        $this->forge->addField('nama_kepala_camat varchar(100) NOT NULL');
        $this->forge->addField('nip_kepala_camat varchar(100) NOT NULL');
        $this->forge->addField('nama_kabupaten varchar(100) NOT NULL');
        $this->forge->addField('kode_kabupaten varchar(100) NOT NULL');
        $this->forge->addField('nama_propinsi varchar(100) NOT NULL');
        $this->forge->addField('kode_propinsi varchar(100) NOT NULL');
        $this->forge->addField('logo varchar(100) NOT NULL');
        $this->forge->addField('lat varchar(20) NOT NULL');
        $this->forge->addField('lng varchar(20) NOT NULL');
        $this->forge->addField('zoom tinyint NOT NULL');
        $this->forge->addField('map_tipe varchar(20) NOT NULL');
        $this->forge->addField('path text NOT NULL');
        $this->forge->addField('alamat_kantor varchar(200) NULL');
        $this->forge->addField('g_analytic varchar(200) NOT NULL');
        $this->forge->addField('regid varchar(60) NOT NULL');
        $this->forge->addField('macid varchar(60) NOT NULL');
        $this->forge->addField('email_desa varchar(100) NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('config', true);

        //# Create Table data_persil
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('nik varchar(64) NOT NULL');
        $this->forge->addField('nama varchar(128) NOT NULL');
        $this->forge->addField('persil_jenis_id tinyint NOT NULL');
        $this->forge->addField('id_clusterdesa varchar(64) NOT NULL');
        $this->forge->addField('alamat_ext varchar(64) NOT NULL');
        $this->forge->addField('luas decimal(7,2) NOT NULL');
        $this->forge->addField('kelas varchar(128) NULL');
        $this->forge->addField('peta text NULL');
        $this->forge->addField('no_sppt_pbb varchar(128) NOT NULL');
        $this->forge->addField('persil_peruntukan_id tinyint NOT NULL');
        $this->forge->addField('rdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('userID int NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('data_persil', true);

        //# Create Table data_persil_jenis
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('nama varchar(128) NOT NULL');
        $this->forge->addField('ndesc text NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('data_persil_jenis', true);

        //# Create Table data_persil_log
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('persil_id int NOT NULL');
        $this->forge->addField('persil_transaksi_jenis tinyint NOT NULL');
        $this->forge->addField('pemilik_lama varchar(24) NOT NULL');
        $this->forge->addField('pemilik_baru varchar(24) NOT NULL');
        $this->forge->addField('rdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('user_id int NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('data_persil_log', true);

        //# Create Table data_persil_peruntukan
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('nama varchar(128) NOT NULL');
        $this->forge->addField('ndesc text NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('data_persil_peruntukan', true);

        //# Create Table detail_log_penduduk
        $this->forge->addField('id int NOT NULL');
        $this->forge->addField('nama varchar(50) NOT NULL');
        $this->forge->createTable('detail_log_penduduk', true);

        //# Create Table dokumen
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('id_pend int NOT NULL');
        $this->forge->addField('satuan varchar(200) NOT NULL');
        $this->forge->addField('nama varchar(50) NOT NULL');
        $this->forge->addField("enabled int NOT NULL DEFAULT '1'");
        $this->forge->addField('tgl_upload timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addKey('id', true);
        $this->forge->createTable('dokumen', true);

        //# Create Table gambar_gallery
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('parrent int NOT NULL');
        $this->forge->addField('gambar varchar(200) NOT NULL');
        $this->forge->addField('nama varchar(50) NOT NULL');
        $this->forge->addField("enabled int NOT NULL DEFAULT '1'");
        $this->forge->addField('tgl_upload timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('tipe int NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->addKey(['parrent']);
        $this->forge->createTable('gambar_gallery', true);

        //# Create Table garis
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('nama varchar(50) NOT NULL');
        $this->forge->addField('path text NOT NULL');
        $this->forge->addField("enabled int NOT NULL DEFAULT '1'");
        $this->forge->addField('ref_line int NOT NULL');
        $this->forge->addField('foto varchar(100) NOT NULL');
        $this->forge->addField('desk text NOT NULL');
        $this->forge->addField('id_cluster int NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('garis', true);

        //# Create Table gis_simbol
        $this->forge->addField('simbol varchar(40) NULL');
        $this->forge->createTable('gis_simbol', true);

        //# Create Table inbox
        $this->forge->addField('ID int unsigned NOT NULL auto_increment');
        $this->forge->addField('UpdatedInDB timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP');
        $this->forge->addField("ReceivingDateTime timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'");
        $this->forge->addField('Text text NOT NULL');
        $this->forge->addField('SenderNumber varchar(20) NOT NULL');
        $this->forge->addField("Coding enum('Default_No_Compression','Unicode_No_Compression','8bit','Default_Compression','Unicode_Compression') NOT NULL DEFAULT 'Default_No_Compression'");
        $this->forge->addField('UDH text NOT NULL');
        $this->forge->addField('SMSCNumber varchar(20) NOT NULL');
        $this->forge->addField("Class int NOT NULL DEFAULT '-1'");
        $this->forge->addField('TextDecoded text NOT NULL');
        $this->forge->addField('RecipientID text NOT NULL');
        $this->forge->addField("Processed enum('false','true') NOT NULL DEFAULT 'false'");
        $this->forge->addKey('ID', true);
        $this->forge->createTable('inbox', true);

        //# Create Table kategori
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('kategori varchar(100) NOT NULL');
        $this->forge->addField("tipe int NOT NULL DEFAULT '1'");
        $this->forge->addField('urut tinyint NOT NULL');
        $this->forge->addField('enabled tinyint NOT NULL');
        $this->forge->addField('parrent tinyint NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('kategori', true);

        //# Create Table kelompok
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('id_master int NOT NULL');
        $this->forge->addField('id_ketua int NOT NULL');
        $this->forge->addField('kode varchar(16) NOT NULL');
        $this->forge->addField('nama varchar(50) NOT NULL');
        $this->forge->addField('keterangan varchar(100) NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->addKey(['id_master', 'id_ketua']);
        $this->forge->createTable('kelompok', true);

        //# Create Table kelompok_anggota
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('id_kelompok int NOT NULL');
        $this->forge->addField('id_penduduk int NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->addKey(['id_kelompok', 'id_penduduk']);
        $this->forge->createTable('kelompok_anggota', true);

        //# Create Table kelompok_master
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('kelompok varchar(50) NOT NULL');
        $this->forge->addField('deskripsi varchar(400) NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('kelompok_master', true);

        //# Create Table komentar
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addKey('id', true);
        $this->forge->addField('id_artikel int NOT NULL');
        $this->forge->addField('owner varchar(50) NOT NULL');
        $this->forge->addField('email varchar(50) NOT NULL');
        $this->forge->addField('komentar text NOT NULL');
        $this->forge->addField('tgl_upload timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField("enabled int NOT NULL DEFAULT '2'");
        $this->forge->createTable('komentar', true);

        //# Create Table kontak
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('id_pend int NULL');
        $this->forge->addField('no_hp varchar(15) NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('kontak', true);

        //# Create Table kontak_grup
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('nama_grup varchar(30) NOT NULL');
        $this->forge->addField('id_kontak int NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('kontak_grup', true);

        //# Create Table line
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('nama varchar(50) NOT NULL');
        $this->forge->addField('simbol varchar(50) NOT NULL');
        $this->forge->addField("color varchar(10) NOT NULL DEFAULT 'ff0000'");
        $this->forge->addField('tipe int NOT NULL');
        $this->forge->addField("parrent int NULL DEFAULT '1'");
        $this->forge->addField("enabled int NOT NULL DEFAULT '1'");
        $this->forge->addKey('id', true);
        $this->forge->addKey(['parrent']);
        $this->forge->createTable('line', true);

        //# Create Table log_bulanan
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('pend int NOT NULL');
        $this->forge->addField('lk int NOT NULL');
        $this->forge->addField('pr int NOT NULL');
        $this->forge->addField('kk int NOT NULL');
        $this->forge->addField('tgl timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP');
        $this->forge->addKey('id', true);
        $this->forge->createTable('log_bulanan', true);

        //# Create Table log_penduduk
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('id_pend int NOT NULL');
        $this->forge->addField('id_detail int NOT NULL');
        $this->forge->addField('tanggal timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('bulan varchar(2) NOT NULL');
        $this->forge->addField('tahun varchar(4) NOT NULL');
        $this->forge->addField('tgl_peristiwa date NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->addKey(['id_pend', 'id_detail', 'tgl_peristiwa']);
        $this->forge->createTable('log_penduduk', true);

        //# Create Table log_perubahan_penduduk
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('id_pend int NOT NULL');
        $this->forge->addField('id_cluster varchar(200) NOT NULL');
        $this->forge->addField('tanggal timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP');
        $this->forge->addKey('id', true);
        $this->forge->createTable('log_perubahan_penduduk', true);

        //# Create Table log_surat
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('id_format_surat int NOT NULL');
        $this->forge->addField('id_pend int NOT NULL');
        $this->forge->addField('id_pamong int NOT NULL');
        $this->forge->addField('id_user int NOT NULL');
        $this->forge->addField('tanggal timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('bulan varchar(2) NULL');
        $this->forge->addField('tahun varchar(4) NULL');
        $this->forge->addField('no_surat varchar(20) NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('log_surat', true);

        //# Create Table lokasi
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('desk text NOT NULL');
        $this->forge->addField('nama varchar(50) NOT NULL');
        $this->forge->addField("enabled int NOT NULL DEFAULT '1'");
        $this->forge->addField('lat varchar(30) NOT NULL');
        $this->forge->addField('lng varchar(30) NOT NULL');
        $this->forge->addField('ref_point int NOT NULL');
        $this->forge->addField('foto varchar(100) NOT NULL');
        $this->forge->addField('id_cluster int NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->addKey(['ref_point']);
        $this->forge->createTable('lokasi', true);

        //# Create Table media_sosial
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('gambar text NOT NULL');
        $this->forge->addField('link text NOT NULL');
        $this->forge->addField('nama varchar(100) NOT NULL');
        $this->forge->addField('enabled int NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('media_sosial', true);

        //# Create Table menu
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('nama varchar(50) NOT NULL');
        $this->forge->addField('link varchar(500) NOT NULL');
        $this->forge->addField('tipe int NOT NULL');
        $this->forge->addField("parrent int NOT NULL DEFAULT '1'");
        $this->forge->addField('link_tipe tinyint(1) NOT NULL');
        $this->forge->addField("enabled int NOT NULL DEFAULT '1'");
        $this->forge->addKey('id', true);
        $this->forge->createTable('menu', true);

        //# Create Table outbox
        $this->forge->addField('ID int unsigned NOT NULL auto_increment');
        $this->forge->addField('UpdatedInDB timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP');
        $this->forge->addField("InsertIntoDB timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'");
        $this->forge->addField("SendingDateTime timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'");
        $this->forge->addField("SendBefore time NOT NULL DEFAULT '23:59:59'");
        $this->forge->addField("SendAfter time NOT NULL DEFAULT '00:00:00'");
        $this->forge->addField('Text text NULL');
        $this->forge->addField('DestinationNumber varchar(20) NOT NULL');
        $this->forge->addField("Coding enum('Default_No_Compression','Unicode_No_Compression','8bit','Default_Compression','Unicode_Compression') NOT NULL DEFAULT 'Default_No_Compression'");
        $this->forge->addField('UDH text NULL');
        $this->forge->addField("Class int NULL DEFAULT '-1'");
        $this->forge->addField('TextDecoded text NOT NULL');
        $this->forge->addField("MultiPart enum('false','true') NULL DEFAULT 'false'");
        $this->forge->addField("RelativeValidity int NULL DEFAULT '-1'");
        $this->forge->addField('SenderID varchar(255) NULL');
        $this->forge->addField("SendingTimeOut timestamp NULL DEFAULT '0000-00-00 00:00:00'");
        $this->forge->addField("DeliveryReport enum('default','yes','no') NULL DEFAULT 'default'");
        $this->forge->addField('CreatorID text NOT NULL');
        $this->forge->addKey('ID', true);
        $this->forge->addKey(['SendingDateTime', 'SenderID', 'SendingTimeOut']);
        $this->forge->createTable('outbox', true);

        //# Create Table point
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('nama varchar(50) NOT NULL');
        $this->forge->addField('simbol varchar(50) NOT NULL');
        $this->forge->addField('tipe int NOT NULL');
        $this->forge->addField("parrent int NOT NULL DEFAULT '1'");
        $this->forge->addField("enabled int NOT NULL DEFAULT '1'");
        $this->forge->addKey('id', true);
        $this->forge->addKey(['parrent']);
        $this->forge->createTable('point', true);

        //# Create Table polygon
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('nama varchar(50) NOT NULL');
        $this->forge->addField('simbol varchar(50) NOT NULL');
        $this->forge->addField("color varchar(10) NOT NULL DEFAULT 'ff0000'");
        $this->forge->addField('tipe int NOT NULL');
        $this->forge->addField("parrent int NULL DEFAULT '1'");
        $this->forge->addField("enabled int NOT NULL DEFAULT '1'");
        $this->forge->addKey('id', true);
        $this->forge->addKey(['parrent']);
        $this->forge->createTable('polygon', true);

        //# Create Table program
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('nama varchar(256) NOT NULL');
        $this->forge->addField('ndesc text NOT NULL');
        $this->forge->addField('sasaran tinyint(1) NOT NULL');
        $this->forge->addField('sdate datetime NOT NULL');
        $this->forge->addField('edate datetime NOT NULL');
        $this->forge->addField('userID int NOT NULL');
        $this->forge->addField('rdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('status tinyint(1) NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('program', true);

        //# Create Table program_peserta
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('program_id int NOT NULL');
        $this->forge->addField('peserta decimal(18,0) NOT NULL');
        $this->forge->addField('sasaran tinyint(1) NOT NULL');
        $this->forge->addField('userID int NOT NULL');
        $this->forge->addField('rdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addKey('id', true);
        $this->forge->createTable('program_peserta', true);

        //# Create Table sentitems
        $this->forge->addField('ID int unsigned NOT NULL');
        $this->forge->addField("SequencePosition int NOT NULL DEFAULT '1'");
        $this->forge->addField('UpdatedInDB timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP');
        $this->forge->addField("InsertIntoDB timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'");
        $this->forge->addField("SendingDateTime timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'");
        $this->forge->addField('DeliveryDateTime timestamp NULL');
        $this->forge->addField('Text text NOT NULL');
        $this->forge->addField('DestinationNumber varchar(20) NOT NULL');
        $this->forge->addField("Coding enum('Default_No_Compression','Unicode_No_Compression','8bit','Default_Compression','Unicode_Compression') NOT NULL DEFAULT 'Default_No_Compression'");
        $this->forge->addField('UDH text NOT NULL');
        $this->forge->addField('SMSCNumber varchar(20) NOT NULL');
        $this->forge->addField("Class int NOT NULL DEFAULT '-1'");
        $this->forge->addField('TextDecoded text NOT NULL');
        $this->forge->addField('SenderID varchar(255) NOT NULL');
        $this->forge->addField("Status enum('SendingOK','SendingOKNoReport','SendingError','DeliveryOK','DeliveryFailed','DeliveryPending','DeliveryUnknown','Error') NOT NULL DEFAULT 'SendingOK'");
        $this->forge->addField("StatusError int NOT NULL DEFAULT '-1'");
        $this->forge->addField("TPMR int NOT NULL DEFAULT '-1'");
        $this->forge->addField("RelativeValidity int NOT NULL DEFAULT '-1'");
        $this->forge->addField('CreatorID text NOT NULL');
        $this->forge->addKey('ID', true);
        $this->forge->addKey('SequencePosition', true);
        $this->forge->addKey(['DeliveryDateTime', 'DestinationNumber', 'SenderID', 'TPMR']);
        $this->forge->createTable('sentitems', true);

        //# Create Table setting_modul
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('modul varchar(50) NOT NULL');
        $this->forge->addField('url varchar(50) NOT NULL');
        $this->forge->addField('aktif tinyint(1) NOT NULL');
        $this->forge->addField('ikon varchar(50) NOT NULL');
        $this->forge->addField('urut tinyint NOT NULL');
        $this->forge->addField("level tinyint(1) NOT NULL DEFAULT '2'");
        $this->forge->addField('hidden tinyint(1) NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('setting_modul', true);

        //# Create Table setting_sms
        $this->forge->addField('autoreply_text varchar(160) NULL');
        $this->forge->createTable('setting_sms', true);

        //# Create Table sys_traffic
        $this->forge->addField('Tanggal date NOT NULL');
        $this->forge->addField('ipAddress text NOT NULL');
        $this->forge->addField('Jumlah int NOT NULL');
        $this->forge->addKey('Tanggal', true);
        $this->forge->createTable('sys_traffic', true);

        //# Create Table tweb_alamat_sekarang
        $this->forge->addField('id int NOT NULL');
        $this->forge->addField('jalan varchar(100) NOT NULL');
        $this->forge->addField('rt varchar(100) NOT NULL');
        $this->forge->addField('rw varchar(100) NOT NULL');
        $this->forge->addField('dusun varchar(100) NOT NULL');
        $this->forge->addField('desa varchar(100) NOT NULL');
        $this->forge->addField('kecamatan varchar(100) NOT NULL');
        $this->forge->addField('kabupaten varchar(100) NOT NULL');
        $this->forge->addField('provinsi varchar(100) NOT NULL');
        $this->forge->createTable('tweb_alamat_sekarang', true);

        //# Create Table tweb_cacat
        $this->forge->addField('id int unsigned NOT NULL auto_increment');
        $this->forge->addField('nama varchar(100) NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_cacat', true);

        //# Create Table tweb_desa_pamong
        $this->forge->addField('pamong_id int NOT NULL auto_increment');
        $this->forge->addField('pamong_nama varchar(100) NULL');
        $this->forge->addField('pamong_nip varchar(20) NULL');
        $this->forge->addField('pamong_nik varchar(20) NULL');
        $this->forge->addField('jabatan varchar(50) NULL');
        $this->forge->addField('pamong_status varchar(45) NULL');
        $this->forge->addField('pamong_tgl_terdaftar date NULL');
        $this->forge->addKey('pamong_id', true);
        $this->forge->createTable('tweb_desa_pamong', true);

        //# Create Table tweb_golongan_darah
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('nama varchar(15) NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_golongan_darah', true);

        //# Create Table tweb_keluarga
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('no_kk varchar(160) NULL');
        $this->forge->addField('nik_kepala varchar(200) NULL');
        $this->forge->addField('tgl_daftar timestamp NULL DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('kelas_sosial int NULL');
        $this->forge->addField("raskin int NOT NULL DEFAULT '2'");
        $this->forge->addField("id_bedah_rumah int NOT NULL DEFAULT '2'");
        $this->forge->addField("id_pkh int NOT NULL DEFAULT '2'");
        $this->forge->addField("id_blt int NOT NULL DEFAULT '2'");
        $this->forge->addKey('id', true);
        $this->forge->addKey(['nik_kepala']);
        $this->forge->createTable('tweb_keluarga', true);

        //# Create Table tweb_penduduk
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('nama varchar(100) NOT NULL');
        $this->forge->addField('nik decimal(16,0) NOT NULL');
        $this->forge->addField('id_kk int NULL');
        $this->forge->addField('kk_level tinyint NOT NULL');
        $this->forge->addField('id_rtm int NOT NULL');
        $this->forge->addField('rtm_level int NOT NULL');
        $this->forge->addField('sex tinyint unsigned NULL');
        $this->forge->addField('tempatlahir varchar(100) NOT NULL');
        $this->forge->addField('tanggallahir date NOT NULL');
        $this->forge->addField('agama_id int unsigned NOT NULL');
        $this->forge->addField('pendidikan_kk_id int unsigned NOT NULL');
        $this->forge->addField('pendidikan_id int unsigned NOT NULL');
        $this->forge->addField('pendidikan_sedang_id int unsigned NOT NULL');
        $this->forge->addField('pekerjaan_id int unsigned NOT NULL');
        $this->forge->addField('status_kawin tinyint unsigned NOT NULL');
        $this->forge->addField('warganegara_id int unsigned NOT NULL');
        $this->forge->addField('dokumen_pasport varchar(45) NULL');
        $this->forge->addField('dokumen_kitas int NULL');
        $this->forge->addField('ayah_nik varchar(16) NOT NULL');
        $this->forge->addField('ibu_nik varchar(16) NOT NULL');
        $this->forge->addField('nama_ayah varchar(100) NOT NULL');
        $this->forge->addField('nama_ibu varchar(100) NOT NULL');
        $this->forge->addField('foto varchar(100) NOT NULL');
        $this->forge->addField('golongan_darah_id int NOT NULL');
        $this->forge->addField('id_cluster int NOT NULL');
        $this->forge->addField('status int unsigned NULL');
        $this->forge->addField('alamat_sebelumnya varchar(200) NOT NULL');
        $this->forge->addField('alamat_sekarang varchar(200) NOT NULL');
        $this->forge->addField("status_dasar tinyint NOT NULL DEFAULT '1'");
        $this->forge->addField('hamil int NULL');
        $this->forge->addField('cacat_id int NULL');
        $this->forge->addField('sakit_menahun_id int NOT NULL');
        $this->forge->addField("jamkesmas int NOT NULL DEFAULT '2'");
        $this->forge->addField('akta_lahir varchar(40) NOT NULL');
        $this->forge->addField('akta_perkawinan varchar(40) NOT NULL');
        $this->forge->addField('tanggalperkawinan date NOT NULL');
        $this->forge->addField('akta_perceraian varchar(40) NOT NULL');
        $this->forge->addField('tanggalperceraian date NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_penduduk', true);

        //# Create Table tweb_penduduk_agama
        $this->forge->addField('id int unsigned NOT NULL auto_increment');
        $this->forge->addField('nama varchar(100) NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_penduduk_agama', true);

        //# Create Table tweb_penduduk_hubungan
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('nama varchar(100) NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_penduduk_hubungan', true);

        //# Create Table tweb_penduduk_kawin
        $this->forge->addField('id int unsigned NOT NULL auto_increment');
        $this->forge->addField('nama varchar(100) NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_penduduk_kawin', true);

        //# Create Table tweb_penduduk_mandiri
        $this->forge->addField('nik varchar(20) NOT NULL');
        $this->forge->addField('pin varchar(60) NOT NULL');
        $this->forge->addField('tanggal_buat timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP');
        $this->forge->addField('last_login datetime NOT NULL');
        $this->forge->addKey('nik', true);
        $this->forge->createTable('tweb_penduduk_mandiri', true);

        //# Create Table tweb_penduduk_map
        $this->forge->addField('id int NOT NULL');
        $this->forge->addField('lat varchar(24) NOT NULL');
        $this->forge->addField('lng varchar(24) NOT NULL');
        $this->forge->createTable('tweb_penduduk_map', true);

        //# Create Table tweb_penduduk_pekerjaan
        $this->forge->addField('id int unsigned NOT NULL auto_increment');
        $this->forge->addField('nama varchar(100) NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_penduduk_pekerjaan', true);

        //# Create Table tweb_penduduk_pendidikan
        $this->forge->addField('id tinyint NOT NULL auto_increment');
        $this->forge->addField('nama varchar(50) NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_penduduk_pendidikan', true);

        //# Create Table tweb_penduduk_pendidikan_kk
        $this->forge->addField('id int unsigned NOT NULL auto_increment');
        $this->forge->addField('nama varchar(50) NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_penduduk_pendidikan_kk', true);

        //# Create Table tweb_penduduk_sex
        $this->forge->addField('id int unsigned NOT NULL auto_increment');
        $this->forge->addField('nama varchar(15) NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_penduduk_sex', true);

        //# Create Table tweb_penduduk_status
        $this->forge->addField('id int unsigned NOT NULL auto_increment');
        $this->forge->addField('nama varchar(50) NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_penduduk_status', true);

        //# Create Table tweb_penduduk_umur
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('nama varchar(25) NULL');
        $this->forge->addField('dari int NULL');
        $this->forge->addField('sampai int NULL');
        $this->forge->addField('status int NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_penduduk_umur', true);

        //# Create Table tweb_penduduk_warganegara
        $this->forge->addField('id int unsigned NOT NULL auto_increment');
        $this->forge->addField('nama varchar(25) NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_penduduk_warganegara', true);

        //# Create Table tweb_rtm
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('nik_kepala int NOT NULL');
        $this->forge->addField('no_kk varchar(20) NOT NULL');
        $this->forge->addField('tgl_daftar timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP');
        $this->forge->addField('kelas_sosial int NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_rtm', true);

        //# Create Table tweb_rtm_hubungan
        $this->forge->addField('id tinyint NOT NULL auto_increment');
        $this->forge->addField('nama varchar(20) NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_rtm_hubungan', true);

        //# Create Table tweb_sakit_menahun
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('nama varchar(255) NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_sakit_menahun', true);

        //# Create Table tweb_status_dasar
        $this->forge->addField('id int unsigned NOT NULL auto_increment');
        $this->forge->addField('nama varchar(50) NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_status_dasar', true);

        //# Create Table tweb_surat_atribut
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('id_surat int NOT NULL');
        $this->forge->addField('id_tipe tinyint NOT NULL');
        $this->forge->addField('nama varchar(40) NOT NULL');
        $this->forge->addField('`long` tinyint NOT NULL');
        $this->forge->addField('kode tinyint NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_surat_atribut', true);

        //# Create Table tweb_surat_format
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('nama varchar(100) NOT NULL');
        $this->forge->addField('url_surat varchar(100) NOT NULL');
        $this->forge->addField('kode_surat varchar(10) NOT NULL');
        $this->forge->addField('kunci tinyint(1) NOT NULL');
        $this->forge->addField('favorit tinyint(1) NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_surat_format', true);

        //# Create Table tweb_wil_clusterdesa
        $this->forge->addField('id int NOT NULL auto_increment');
        $this->forge->addField('rt varchar(10) NOT NULL');
        $this->forge->addField('rw varchar(10) NOT NULL');
        $this->forge->addField('dusun varchar(50) NOT NULL');
        $this->forge->addField('id_kepala int NOT NULL');
        $this->forge->addField('lat varchar(20) NOT NULL');
        $this->forge->addField('lng varchar(20) NOT NULL');
        $this->forge->addField('zoom int NOT NULL');
        $this->forge->addField('path text NOT NULL');
        $this->forge->addField('map_tipe varchar(20) NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->addKey(['rt', 'rw', 'dusun', 'id_kepala']);
        $this->forge->createTable('tweb_wil_clusterdesa', true);

        //# Create Table user
        $this->forge->addField('id mediumint unsigned NOT NULL auto_increment');
        $this->forge->addField('username varchar(100) NOT NULL');
        $this->forge->addField('password varchar(40) NOT NULL');
        $this->forge->addField('id_grup int NOT NULL');
        $this->forge->addField('email varchar(100) NOT NULL');
        $this->forge->addField('last_login datetime NOT NULL');
        $this->forge->addField('active tinyint unsigned NULL');
        $this->forge->addField('nama varchar(50) NULL');
        $this->forge->addField('company varchar(100) NULL');
        $this->forge->addField('phone varchar(20) NULL');
        $this->forge->addField('foto varchar(100) NOT NULL');
        $this->forge->addField('session varchar(40) NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('user', true);

        //# Create Table user_grup
        $this->forge->addField('id tinyint NOT NULL');
        $this->forge->addField('nama varchar(20) NOT NULL');
        $this->forge->addKey('id', true);
        $this->forge->createTable('user_grup', true);
    }

    public function down()
    {
        $this->forge->dropTable('analisis_indikator', true);
        $this->forge->dropTable('analisis_kategori_indikator', true);
        $this->forge->dropTable('analisis_klasifikasi', true);
        $this->forge->dropTable('analisis_master', true);
        $this->forge->dropTable('analisis_parameter', true);
        $this->forge->dropTable('analisis_partisipasi', true);
        $this->forge->dropTable('analisis_periode', true);
        $this->forge->dropTable('analisis_ref_state', true);
        $this->forge->dropTable('analisis_ref_subjek', true);
        $this->forge->dropTable('analisis_respon', true);
        $this->forge->dropTable('analisis_respon_bukti', true);
        $this->forge->dropTable('analisis_respon_hasil', true);
        $this->forge->dropTable('analisis_tipe_indikator', true);
        $this->forge->dropTable('area', true);
        $this->forge->dropTable('artikel', true);
        $this->forge->dropTable('config', true);
        $this->forge->dropTable('data_persil', true);
        $this->forge->dropTable('data_persil_jenis', true);
        $this->forge->dropTable('data_persil_log', true);
        $this->forge->dropTable('data_persil_peruntukan', true);
        $this->forge->dropTable('detail_log_penduduk', true);
        $this->forge->dropTable('dokumen', true);
        $this->forge->dropTable('gambar_gallery', true);
        $this->forge->dropTable('garis', true);
        $this->forge->dropTable('gis_simbol', true);
        $this->forge->dropTable('inbox', true);
        $this->forge->dropTable('kategori', true);
        $this->forge->dropTable('kelompok', true);
        $this->forge->dropTable('kelompok_anggota', true);
        $this->forge->dropTable('kelompok_master', true);
        $this->forge->dropTable('komentar', true);
        $this->forge->dropTable('kontak', true);
        $this->forge->dropTable('kontak_grup', true);
        $this->forge->dropTable('line', true);
        $this->forge->dropTable('log_bulanan', true);
        $this->forge->dropTable('log_penduduk', true);
        $this->forge->dropTable('log_perubahan_penduduk', true);
        $this->forge->dropTable('log_surat', true);
        $this->forge->dropTable('lokasi', true);
        $this->forge->dropTable('media_sosial', true);
        $this->forge->dropTable('menu', true);
        $this->forge->dropTable('outbox', true);
        $this->forge->dropTable('point', true);
        $this->forge->dropTable('polygon', true);
        $this->forge->dropTable('program', true);
        $this->forge->dropTable('program_peserta', true);
        $this->forge->dropTable('sentitems', true);
        $this->forge->dropTable('setting_modul', true);
        $this->forge->dropTable('setting_sms', true);
        $this->forge->dropTable('sys_traffic', true);
        $this->forge->dropTable('tweb_alamat_sekarang', true);
        $this->forge->dropTable('tweb_cacat', true);
        $this->forge->dropTable('tweb_desa_pamong', true);
        $this->forge->dropTable('tweb_golongan_darah', true);
        $this->forge->dropTable('tweb_keluarga', true);
        $this->forge->dropTable('tweb_penduduk', true);
        $this->forge->dropTable('tweb_penduduk_agama', true);
        $this->forge->dropTable('tweb_penduduk_hubungan', true);
        $this->forge->dropTable('tweb_penduduk_kawin', true);
        $this->forge->dropTable('tweb_penduduk_mandiri', true);
        $this->forge->dropTable('tweb_penduduk_map', true);
        $this->forge->dropTable('tweb_penduduk_pekerjaan', true);
        $this->forge->dropTable('tweb_penduduk_pendidikan', true);
        $this->forge->dropTable('tweb_penduduk_pendidikan_kk', true);
        $this->forge->dropTable('tweb_penduduk_sex', true);
        $this->forge->dropTable('tweb_penduduk_status', true);
        $this->forge->dropTable('tweb_penduduk_umur', true);
        $this->forge->dropTable('tweb_penduduk_warganegara', true);
        $this->forge->dropTable('tweb_rtm', true);
        $this->forge->dropTable('tweb_rtm_hubungan', true);
        $this->forge->dropTable('tweb_sakit_menahun', true);
        $this->forge->dropTable('tweb_status_dasar', true);
        $this->forge->dropTable('tweb_surat_atribut', true);
        $this->forge->dropTable('tweb_surat_format', true);
        $this->forge->dropTable('tweb_wil_clusterdesa', true);
        $this->forge->dropTable('user', true);
        $this->forge->dropTable('user_grup', true);
    }
}
