<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Create_base extends CI_Migration
{
    public function up()
    {
        //# Create Table analisis_indikator
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`id_master` int NOT NULL ');
        $this->dbforge->add_field('`nomor` int NOT NULL ');
        $this->dbforge->add_field('`pertanyaan` varchar(400) NOT NULL ');
        $this->dbforge->add_field("`id_tipe` tinyint NOT NULL DEFAULT '1' ");
        $this->dbforge->add_field('`bobot` tinyint NOT NULL ');
        $this->dbforge->add_field("`act_analisis` tinyint(1) NOT NULL DEFAULT '2' ");
        $this->dbforge->add_field('`id_kategori` tinyint NOT NULL ');
        $this->dbforge->add_field('`is_publik` tinyint(1) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key(['id_master', 'id_tipe', 'id_kategori']);
        $this->dbforge->create_table('analisis_indikator', true);

        //# Create Table analisis_kategori_indikator
        $this->dbforge->add_field('`id` tinyint NOT NULL auto_increment');
        $this->dbforge->add_field('`id_master` tinyint NOT NULL ');
        $this->dbforge->add_field('`kategori_kode` varchar(3) NOT NULL ');
        $this->dbforge->add_field('`kategori` varchar(50) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key(['id_master']);
        $this->dbforge->create_table('analisis_kategori_indikator', true);

        //# Create Table analisis_klasifikasi
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`id_master` int NOT NULL ');
        $this->dbforge->add_field('`nama` varchar(20) NOT NULL ');
        $this->dbforge->add_field('`minval` double(5,2) NOT NULL ');
        $this->dbforge->add_field('`maxval` double(5,2) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key(['id_master']);
        $this->dbforge->create_table('analisis_klasifikasi', true);

        //# Create Table analisis_master
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(40) NOT NULL ');
        $this->dbforge->add_field('`subjek_tipe` tinyint NOT NULL ');
        $this->dbforge->add_field("`lock` tinyint(1) NOT NULL DEFAULT '1' ");
        $this->dbforge->add_field('`deskripsi` text NOT NULL ');
        $this->dbforge->add_field("`kode_analisis` varchar(5) NOT NULL DEFAULT '00000' ");
        $this->dbforge->add_field('`id_child` smallint NOT NULL ');
        $this->dbforge->add_field('`id_kelompok` int NOT NULL ');
        $this->dbforge->add_field("`pembagi` varchar(10) NOT NULL DEFAULT '100' ");
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('analisis_master', true);

        //# Create Table analisis_parameter
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`id_indikator` int NOT NULL ');
        $this->dbforge->add_field('`kode_jawaban` int NOT NULL ');
        $this->dbforge->add_field('`asign` tinyint(1) NOT NULL ');
        $this->dbforge->add_field('`jawaban` varchar(200) NOT NULL ');
        $this->dbforge->add_field('`nilai` tinyint NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key(['id_indikator']);
        $this->dbforge->create_table('analisis_parameter', true);

        //# Create Table analisis_partisipasi
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`id_subjek` int NOT NULL ');
        $this->dbforge->add_field('`id_master` int NOT NULL ');
        $this->dbforge->add_field('`id_periode` int NOT NULL ');
        $this->dbforge->add_field("`id_klassifikasi` int NOT NULL DEFAULT '1' ");
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key(['id_subjek', 'id_master', 'id_periode', 'id_klassifikasi']);
        $this->dbforge->create_table('analisis_partisipasi', true);

        //# Create Table analisis_periode
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`id_master` int NOT NULL ');
        $this->dbforge->add_field('`nama` varchar(50) NOT NULL ');
        $this->dbforge->add_field("`id_state` tinyint NOT NULL DEFAULT '1' ");
        $this->dbforge->add_field('`aktif` tinyint(1) NOT NULL ');
        $this->dbforge->add_field('`keterangan` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`tahun_pelaksanaan` year NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key(['id_master', 'id_state']);
        $this->dbforge->create_table('analisis_periode', true);

        //# Create Table analisis_ref_state
        $this->dbforge->add_field('`id` tinyint NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(40) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('analisis_ref_state', true);

        //# Create Table analisis_ref_subjek
        $this->dbforge->add_field('`id` tinyint NOT NULL auto_increment');
        $this->dbforge->add_field('`subjek` varchar(20) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('analisis_ref_subjek', true);

        //# Create Table analisis_respon
        $this->dbforge->add_field('`id_indikator` int NOT NULL ');
        $this->dbforge->add_field('`id_parameter` int NOT NULL ');
        $this->dbforge->add_field('`id_subjek` int NOT NULL ');
        $this->dbforge->add_field('`id_periode` int NOT NULL ');
        $this->dbforge->create_table('analisis_respon', true);

        //# Create Table analisis_respon_bukti
        $this->dbforge->add_field('`id_master` tinyint NOT NULL ');
        $this->dbforge->add_field('`id_periode` tinyint NOT NULL ');
        $this->dbforge->add_field('`id_subjek` int NOT NULL ');
        $this->dbforge->add_field('`pengesahan` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP DEFAULT_GENERATED');
        $this->dbforge->create_table('analisis_respon_bukti', true);

        //# Create Table analisis_respon_hasil
        $this->dbforge->add_field('`id_master` tinyint NOT NULL ');
        $this->dbforge->add_field('`id_periode` tinyint NOT NULL ');
        $this->dbforge->add_field('`id_subjek` int NOT NULL ');
        $this->dbforge->add_field('`akumulasi` double(8,3) NOT NULL ');
        $this->dbforge->add_field('`tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP DEFAULT_GENERATED');
        $this->dbforge->add_key(['id_master', 'id_periode', 'id_subjek']);
        $this->dbforge->create_table('analisis_respon_hasil', true);

        //# Create Table analisis_tipe_indikator
        $this->dbforge->add_field('`id` tinyint NOT NULL auto_increment');
        $this->dbforge->add_field('`tipe` varchar(20) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('analisis_tipe_indikator', true);

        //# Create Table area
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(50) NOT NULL ');
        $this->dbforge->add_field('`path` text NOT NULL ');
        $this->dbforge->add_field("`enabled` int NOT NULL DEFAULT '1' ");
        $this->dbforge->add_field('`ref_polygon` int NOT NULL ');
        $this->dbforge->add_field('`foto` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`id_cluster` int NOT NULL ');
        $this->dbforge->add_field('`desk` text NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('area', true);

        //# Create Table artikel
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`gambar` varchar(200) NOT NULL ');
        $this->dbforge->add_field('`isi` text NOT NULL ');
        $this->dbforge->add_field("`enabled` int NOT NULL DEFAULT '1' ");
        $this->dbforge->add_field('`tgl_upload` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP DEFAULT_GENERATED');
        $this->dbforge->add_field('`id_kategori` int NOT NULL ');
        $this->dbforge->add_field('`id_user` int NOT NULL ');
        $this->dbforge->add_field('`judul` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`headline` int NOT NULL ');
        $this->dbforge->add_field('`gambar1` varchar(200) NOT NULL ');
        $this->dbforge->add_field('`gambar2` varchar(200) NOT NULL ');
        $this->dbforge->add_field('`gambar3` varchar(200) NOT NULL ');
        $this->dbforge->add_field('`dokumen` varchar(400) NOT NULL ');
        $this->dbforge->add_field('`link_dokumen` varchar(200) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('artikel', true);

        //# Create Table config
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`nama_desa` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`kode_desa` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`nama_kepala_desa` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`nip_kepala_desa` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`kode_pos` varchar(6) NOT NULL ');
        $this->dbforge->add_field('`nama_kecamatan` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`kode_kecamatan` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`nama_kepala_camat` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`nip_kepala_camat` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`nama_kabupaten` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`kode_kabupaten` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`nama_propinsi` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`kode_propinsi` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`logo` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`lat` varchar(20) NOT NULL ');
        $this->dbforge->add_field('`lng` varchar(20) NOT NULL ');
        $this->dbforge->add_field('`zoom` tinyint NOT NULL ');
        $this->dbforge->add_field('`map_tipe` varchar(20) NOT NULL ');
        $this->dbforge->add_field('`path` text NOT NULL ');
        $this->dbforge->add_field('`alamat_kantor` varchar(200) NULL ');
        $this->dbforge->add_field('`g_analytic` varchar(200) NOT NULL ');
        $this->dbforge->add_field('`regid` varchar(60) NOT NULL ');
        $this->dbforge->add_field('`macid` varchar(60) NOT NULL ');
        $this->dbforge->add_field('`email_desa` varchar(100) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('config', true);

        //# Create Table data_persil
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`nik` varchar(64) NOT NULL ');
        $this->dbforge->add_field('`nama` varchar(128) NOT NULL ');
        $this->dbforge->add_field('`persil_jenis_id` tinyint NOT NULL ');
        $this->dbforge->add_field('`id_clusterdesa` varchar(64) NOT NULL ');
        $this->dbforge->add_field('`alamat_ext` varchar(64) NOT NULL ');
        $this->dbforge->add_field('`luas` decimal(7,2) NOT NULL ');
        $this->dbforge->add_field('`kelas` varchar(128) NULL ');
        $this->dbforge->add_field('`peta` text NULL ');
        $this->dbforge->add_field('`no_sppt_pbb` varchar(128) NOT NULL ');
        $this->dbforge->add_field('`persil_peruntukan_id` tinyint NOT NULL ');
        $this->dbforge->add_field('`rdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP DEFAULT_GENERATED');
        $this->dbforge->add_field('`userID` int NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('data_persil', true);

        //# Create Table data_persil_jenis
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(128) NOT NULL ');
        $this->dbforge->add_field('`ndesc` text NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('data_persil_jenis', true);

        //# Create Table data_persil_log
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`persil_id` int NOT NULL ');
        $this->dbforge->add_field('`persil_transaksi_jenis` tinyint NOT NULL ');
        $this->dbforge->add_field('`pemilik_lama` varchar(24) NOT NULL ');
        $this->dbforge->add_field('`pemilik_baru` varchar(24) NOT NULL ');
        $this->dbforge->add_field('`rdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP DEFAULT_GENERATED');
        $this->dbforge->add_field('`user_id` int NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('data_persil_log', true);

        //# Create Table data_persil_peruntukan
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(128) NOT NULL ');
        $this->dbforge->add_field('`ndesc` text NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('data_persil_peruntukan', true);

        //# Create Table detail_log_penduduk
        $this->dbforge->add_field('`id` int NOT NULL ');
        $this->dbforge->add_field('`nama` varchar(50) NOT NULL ');
        $this->dbforge->create_table('detail_log_penduduk', true);

        //# Create Table dokumen
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`id_pend` int NOT NULL ');
        $this->dbforge->add_field('`satuan` varchar(200) NOT NULL ');
        $this->dbforge->add_field('`nama` varchar(50) NOT NULL ');
        $this->dbforge->add_field("`enabled` int NOT NULL DEFAULT '1' ");
        $this->dbforge->add_field('`tgl_upload` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP DEFAULT_GENERATED');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('dokumen', true);

        //# Create Table gambar_gallery
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`parrent` int NOT NULL ');
        $this->dbforge->add_field('`gambar` varchar(200) NOT NULL ');
        $this->dbforge->add_field('`nama` varchar(50) NOT NULL ');
        $this->dbforge->add_field("`enabled` int NOT NULL DEFAULT '1' ");
        $this->dbforge->add_field('`tgl_upload` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP DEFAULT_GENERATED');
        $this->dbforge->add_field('`tipe` int NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key(['parrent']);
        $this->dbforge->create_table('gambar_gallery', true);

        //# Create Table garis
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(50) NOT NULL ');
        $this->dbforge->add_field('`path` text NOT NULL ');
        $this->dbforge->add_field("`enabled` int NOT NULL DEFAULT '1' ");
        $this->dbforge->add_field('`ref_line` int NOT NULL ');
        $this->dbforge->add_field('`foto` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`desk` text NOT NULL ');
        $this->dbforge->add_field('`id_cluster` int NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('garis', true);

        //# Create Table gis_simbol
        $this->dbforge->add_field('`simbol` varchar(40) NULL ');
        $this->dbforge->create_table('gis_simbol', true);

        //# Create Table inbox
        $this->dbforge->add_field('`ID` int unsigned NOT NULL auto_increment');
        $this->dbforge->add_field('`UpdatedInDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP DEFAULT_GENERATED on update CURRENT_TIMESTAMP');
        $this->dbforge->add_field('`ReceivingDateTime` timestamp NOT NULL DEFAULT 0000-00-00 00:00:00 ');
        $this->dbforge->add_field('`Text` text NOT NULL ');
        $this->dbforge->add_field('`SenderNumber` varchar(20) NOT NULL ');
        $this->dbforge->add_field("`Coding` enum('Default_No_Compression','Unicode_No_Compression','8bit','Default_Compression','Unicode_Compression') NOT NULL DEFAULT 'Default_No_Compression' ");
        $this->dbforge->add_field('`UDH` text NOT NULL ');
        $this->dbforge->add_field('`SMSCNumber` varchar(20) NOT NULL ');
        $this->dbforge->add_field("`Class` int NOT NULL DEFAULT '-1' ");
        $this->dbforge->add_field('`TextDecoded` text NOT NULL ');
        $this->dbforge->add_field('`RecipientID` text NOT NULL ');
        $this->dbforge->add_field("`Processed` enum('false','true') NOT NULL DEFAULT 'false' ");
        $this->dbforge->add_key('ID', true);
        $this->dbforge->create_table('inbox', true);

        //# Create Table kategori
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`kategori` varchar(100) NOT NULL ');
        $this->dbforge->add_field("`tipe` int NOT NULL DEFAULT '1' ");
        $this->dbforge->add_field('`urut` tinyint NOT NULL ');
        $this->dbforge->add_field('`enabled` tinyint NOT NULL ');
        $this->dbforge->add_field('`parrent` tinyint NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('kategori', true);

        //# Create Table kelompok
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`id_master` int NOT NULL ');
        $this->dbforge->add_field('`id_ketua` int NOT NULL ');
        $this->dbforge->add_field('`kode` varchar(16) NOT NULL ');
        $this->dbforge->add_field('`nama` varchar(50) NOT NULL ');
        $this->dbforge->add_field('`keterangan` varchar(100) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key(['id_master', 'id_ketua']);
        $this->dbforge->create_table('kelompok', true);

        //# Create Table kelompok_anggota
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`id_kelompok` int NOT NULL ');
        $this->dbforge->add_field('`id_penduduk` int NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key(['id_kelompok', 'id_penduduk']);
        $this->dbforge->create_table('kelompok_anggota', true);

        //# Create Table kelompok_master
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`kelompok` varchar(50) NOT NULL ');
        $this->dbforge->add_field('`deskripsi` varchar(400) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('kelompok_master', true);

        //# Create Table komentar
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field('`id_artikel` int NOT NULL ');
        $this->dbforge->add_field('`owner` varchar(50) NOT NULL ');
        $this->dbforge->add_field('`email` varchar(50) NOT NULL ');
        $this->dbforge->add_field('`komentar` text NOT NULL ');
        $this->dbforge->add_field('`tgl_upload` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP DEFAULT_GENERATED');
        $this->dbforge->add_field("`enabled` int NOT NULL DEFAULT '2' ");
        $this->dbforge->create_table('komentar', true);

        //# Create Table kontak
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`id_pend` int NULL ');
        $this->dbforge->add_field('`no_hp` varchar(15) NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('kontak', true);

        //# Create Table kontak_grup
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`nama_grup` varchar(30) NOT NULL ');
        $this->dbforge->add_field('`id_kontak` int NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('kontak_grup', true);

        //# Create Table line
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(50) NOT NULL ');
        $this->dbforge->add_field('`simbol` varchar(50) NOT NULL ');
        $this->dbforge->add_field("`color` varchar(10) NOT NULL DEFAULT 'ff0000' ");
        $this->dbforge->add_field('`tipe` int NOT NULL ');
        $this->dbforge->add_field("`parrent` int NULL DEFAULT '1' ");
        $this->dbforge->add_field("`enabled` int NOT NULL DEFAULT '1' ");
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key(['parrent']);
        $this->dbforge->create_table('line', true);

        //# Create Table log_bulanan
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`pend` int NOT NULL ');
        $this->dbforge->add_field('`lk` int NOT NULL ');
        $this->dbforge->add_field('`pr` int NOT NULL ');
        $this->dbforge->add_field('`kk` int NOT NULL ');
        $this->dbforge->add_field('`tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP DEFAULT_GENERATED on update CURRENT_TIMESTAMP');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('log_bulanan', true);

        //# Create Table log_penduduk
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`id_pend` int NOT NULL ');
        $this->dbforge->add_field('`id_detail` int NOT NULL ');
        $this->dbforge->add_field('`tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP DEFAULT_GENERATED');
        $this->dbforge->add_field('`bulan` varchar(2) NOT NULL ');
        $this->dbforge->add_field('`tahun` varchar(4) NOT NULL ');
        $this->dbforge->add_field('`tgl_peristiwa` date NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key(['id_pend', 'id_detail', 'tgl_peristiwa']);
        $this->dbforge->create_table('log_penduduk', true);

        //# Create Table log_perubahan_penduduk
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`id_pend` int NOT NULL ');
        $this->dbforge->add_field('`id_cluster` varchar(200) NOT NULL ');
        $this->dbforge->add_field('`tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP DEFAULT_GENERATED on update CURRENT_TIMESTAMP');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('log_perubahan_penduduk', true);

        //# Create Table log_surat
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`id_format_surat` int NOT NULL ');
        $this->dbforge->add_field('`id_pend` int NOT NULL ');
        $this->dbforge->add_field('`id_pamong` int NOT NULL ');
        $this->dbforge->add_field('`id_user` int NOT NULL ');
        $this->dbforge->add_field('`tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP DEFAULT_GENERATED');
        $this->dbforge->add_field('`bulan` varchar(2) NULL ');
        $this->dbforge->add_field('`tahun` varchar(4) NULL ');
        $this->dbforge->add_field('`no_surat` varchar(20) NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('log_surat', true);

        //# Create Table lokasi
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`desk` text NOT NULL ');
        $this->dbforge->add_field('`nama` varchar(50) NOT NULL ');
        $this->dbforge->add_field("`enabled` int NOT NULL DEFAULT '1' ");
        $this->dbforge->add_field('`lat` varchar(30) NOT NULL ');
        $this->dbforge->add_field('`lng` varchar(30) NOT NULL ');
        $this->dbforge->add_field('`ref_point` int NOT NULL ');
        $this->dbforge->add_field('`foto` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`id_cluster` int NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key(['ref_point']);
        $this->dbforge->create_table('lokasi', true);

        //# Create Table media_sosial
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`gambar` text NOT NULL ');
        $this->dbforge->add_field('`link` text NOT NULL ');
        $this->dbforge->add_field('`nama` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`enabled` int NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('media_sosial', true);

        //# Create Table menu
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(50) NOT NULL ');
        $this->dbforge->add_field('`link` varchar(500) NOT NULL ');
        $this->dbforge->add_field('`tipe` int NOT NULL ');
        $this->dbforge->add_field("`parrent` int NOT NULL DEFAULT '1' ");
        $this->dbforge->add_field('`link_tipe` tinyint(1) NOT NULL ');
        $this->dbforge->add_field("`enabled` int NOT NULL DEFAULT '1' ");
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('menu', true);

        //# Create Table outbox
        $this->dbforge->add_field('`ID` int unsigned NOT NULL auto_increment');
        $this->dbforge->add_field('`UpdatedInDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP DEFAULT_GENERATED on update CURRENT_TIMESTAMP');
        $this->dbforge->add_field('`InsertIntoDB` timestamp NOT NULL DEFAULT 0000-00-00 00:00:00 ');
        $this->dbforge->add_field('`SendingDateTime` timestamp NOT NULL DEFAULT 0000-00-00 00:00:00 ');
        $this->dbforge->add_field("`SendBefore` time NOT NULL DEFAULT '23:59:59' ");
        $this->dbforge->add_field("`SendAfter` time NOT NULL DEFAULT '00:00:00' ");
        $this->dbforge->add_field('`Text` text NULL ');
        $this->dbforge->add_field('`DestinationNumber` varchar(20) NOT NULL ');
        $this->dbforge->add_field("`Coding` enum('Default_No_Compression','Unicode_No_Compression','8bit','Default_Compression','Unicode_Compression') NOT NULL DEFAULT 'Default_No_Compression' ");
        $this->dbforge->add_field('`UDH` text NULL ');
        $this->dbforge->add_field("`Class` int NULL DEFAULT '-1' ");
        $this->dbforge->add_field('`TextDecoded` text NOT NULL ');
        $this->dbforge->add_field("`MultiPart` enum('false','true') NULL DEFAULT 'false' ");
        $this->dbforge->add_field("`RelativeValidity` int NULL DEFAULT '-1' ");
        $this->dbforge->add_field('`SenderID` varchar(255) NULL ');
        $this->dbforge->add_field('`SendingTimeOut` timestamp NULL DEFAULT 0000-00-00 00:00:00 ');
        $this->dbforge->add_field("`DeliveryReport` enum('default','yes','no') NULL DEFAULT 'default' ");
        $this->dbforge->add_field('`CreatorID` text NOT NULL ');
        $this->dbforge->add_key('ID', true);
        $this->dbforge->add_key(['SendingDateTime', 'SenderID', 'SendingTimeOut']);
        $this->dbforge->create_table('outbox', true);

        //# Create Table point
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(50) NOT NULL ');
        $this->dbforge->add_field('`simbol` varchar(50) NOT NULL ');
        $this->dbforge->add_field('`tipe` int NOT NULL ');
        $this->dbforge->add_field("`parrent` int NOT NULL DEFAULT '1' ");
        $this->dbforge->add_field("`enabled` int NOT NULL DEFAULT '1' ");
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key(['parrent']);
        $this->dbforge->create_table('point', true);

        //# Create Table polygon
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(50) NOT NULL ');
        $this->dbforge->add_field('`simbol` varchar(50) NOT NULL ');
        $this->dbforge->add_field("`color` varchar(10) NOT NULL DEFAULT 'ff0000' ");
        $this->dbforge->add_field('`tipe` int NOT NULL ');
        $this->dbforge->add_field("`parrent` int NULL DEFAULT '1' ");
        $this->dbforge->add_field("`enabled` int NOT NULL DEFAULT '1' ");
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key(['parrent']);
        $this->dbforge->create_table('polygon', true);

        //# Create Table program
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(256) NOT NULL ');
        $this->dbforge->add_field('`ndesc` text NOT NULL ');
        $this->dbforge->add_field('`sasaran` tinyint(1) NOT NULL ');
        $this->dbforge->add_field('`sdate` datetime NOT NULL ');
        $this->dbforge->add_field('`edate` datetime NOT NULL ');
        $this->dbforge->add_field('`userID` int NOT NULL ');
        $this->dbforge->add_field('`rdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP DEFAULT_GENERATED');
        $this->dbforge->add_field('`status` tinyint(1) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('program', true);

        //# Create Table program_peserta
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`program_id` int NOT NULL ');
        $this->dbforge->add_field('`peserta` decimal(18,0) NOT NULL ');
        $this->dbforge->add_field('`sasaran` tinyint(1) NOT NULL ');
        $this->dbforge->add_field('`userID` int NOT NULL ');
        $this->dbforge->add_field('`rdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP DEFAULT_GENERATED');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('program_peserta', true);

        //# Create Table sentitems
        $this->dbforge->add_field('`ID` int unsigned NOT NULL ');
        $this->dbforge->add_field("`SequencePosition` int NOT NULL DEFAULT '1' ");
        $this->dbforge->add_field('`UpdatedInDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP DEFAULT_GENERATED on update CURRENT_TIMESTAMP');
        $this->dbforge->add_field('`InsertIntoDB` timestamp NOT NULL DEFAULT 0000-00-00 00:00:00 ');
        $this->dbforge->add_field('`SendingDateTime` timestamp NOT NULL DEFAULT 0000-00-00 00:00:00 ');
        $this->dbforge->add_field('`DeliveryDateTime` timestamp NULL ');
        $this->dbforge->add_field('`Text` text NOT NULL ');
        $this->dbforge->add_field('`DestinationNumber` varchar(20) NOT NULL ');
        $this->dbforge->add_field("`Coding` enum('Default_No_Compression','Unicode_No_Compression','8bit','Default_Compression','Unicode_Compression') NOT NULL DEFAULT 'Default_No_Compression' ");
        $this->dbforge->add_field('`UDH` text NOT NULL ');
        $this->dbforge->add_field('`SMSCNumber` varchar(20) NOT NULL ');
        $this->dbforge->add_field("`Class` int NOT NULL DEFAULT '-1' ");
        $this->dbforge->add_field('`TextDecoded` text NOT NULL ');
        $this->dbforge->add_field('`SenderID` varchar(255) NOT NULL ');
        $this->dbforge->add_field("`Status` enum('SendingOK','SendingOKNoReport','SendingError','DeliveryOK','DeliveryFailed','DeliveryPending','DeliveryUnknown','Error') NOT NULL DEFAULT 'SendingOK' ");
        $this->dbforge->add_field("`StatusError` int NOT NULL DEFAULT '-1' ");
        $this->dbforge->add_field("`TPMR` int NOT NULL DEFAULT '-1' ");
        $this->dbforge->add_field("`RelativeValidity` int NOT NULL DEFAULT '-1' ");
        $this->dbforge->add_field('`CreatorID` text NOT NULL ');
        $this->dbforge->add_key('ID', true);
        $this->dbforge->add_key('SequencePosition', true);
        $this->dbforge->add_key(['DeliveryDateTime', 'DestinationNumber', 'SenderID', 'TPMR']);
        $this->dbforge->create_table('sentitems', true);

        //# Create Table setting_modul
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`modul` varchar(50) NOT NULL ');
        $this->dbforge->add_field('`url` varchar(50) NOT NULL ');
        $this->dbforge->add_field('`aktif` tinyint(1) NOT NULL ');
        $this->dbforge->add_field('`ikon` varchar(50) NOT NULL ');
        $this->dbforge->add_field('`urut` tinyint NOT NULL ');
        $this->dbforge->add_field("`level` tinyint(1) NOT NULL DEFAULT '2' ");
        $this->dbforge->add_field('`hidden` tinyint(1) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('setting_modul', true);

        //# Create Table setting_sms
        $this->dbforge->add_field('`autoreply_text` varchar(160) NULL ');
        $this->dbforge->create_table('setting_sms', true);

        //# Create Table sys_traffic
        $this->dbforge->add_field('`Tanggal` date NOT NULL ');
        $this->dbforge->add_field('`ipAddress` text NOT NULL ');
        $this->dbforge->add_field('`Jumlah` int NOT NULL ');
        $this->dbforge->add_key('Tanggal', true);
        $this->dbforge->create_table('sys_traffic', true);

        //# Create Table tweb_alamat_sekarang
        $this->dbforge->add_field('`id` int NOT NULL ');
        $this->dbforge->add_field('`jalan` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`rt` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`rw` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`dusun` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`desa` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`kecamatan` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`kabupaten` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`provinsi` varchar(100) NOT NULL ');
        $this->dbforge->create_table('tweb_alamat_sekarang', true);

        //# Create Table tweb_cacat
        $this->dbforge->add_field('`id` int unsigned NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(100) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('tweb_cacat', true);

        //# Create Table tweb_desa_pamong
        $this->dbforge->add_field('`pamong_id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`pamong_nama` varchar(100) NULL ');
        $this->dbforge->add_field('`pamong_nip` varchar(20) NULL ');
        $this->dbforge->add_field('`pamong_nik` varchar(20) NULL ');
        $this->dbforge->add_field('`jabatan` varchar(50) NULL ');
        $this->dbforge->add_field('`pamong_status` varchar(45) NULL ');
        $this->dbforge->add_field('`pamong_tgl_terdaftar` date NULL ');
        $this->dbforge->add_key('pamong_id', true);
        $this->dbforge->create_table('tweb_desa_pamong', true);

        //# Create Table tweb_golongan_darah
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(15) NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('tweb_golongan_darah', true);

        //# Create Table tweb_keluarga
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`no_kk` varchar(160) NULL ');
        $this->dbforge->add_field('`nik_kepala` varchar(200) NULL ');
        $this->dbforge->add_field('`tgl_daftar` timestamp NULL DEFAULT CURRENT_TIMESTAMP DEFAULT_GENERATED');
        $this->dbforge->add_field('`kelas_sosial` int NULL ');
        $this->dbforge->add_field("`raskin` int NOT NULL DEFAULT '2' ");
        $this->dbforge->add_field("`id_bedah_rumah` int NOT NULL DEFAULT '2' ");
        $this->dbforge->add_field("`id_pkh` int NOT NULL DEFAULT '2' ");
        $this->dbforge->add_field("`id_blt` int NOT NULL DEFAULT '2' ");
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key(['nik_kepala']);
        $this->dbforge->create_table('tweb_keluarga', true);

        //# Create Table tweb_penduduk
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`nik` decimal(16,0) NOT NULL ');
        $this->dbforge->add_field('`id_kk` int NULL ');
        $this->dbforge->add_field('`kk_level` tinyint NOT NULL ');
        $this->dbforge->add_field('`id_rtm` int NOT NULL ');
        $this->dbforge->add_field('`rtm_level` int NOT NULL ');
        $this->dbforge->add_field('`sex` tinyint unsigned NULL ');
        $this->dbforge->add_field('`tempatlahir` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`tanggallahir` date NOT NULL ');
        $this->dbforge->add_field('`agama_id` int unsigned NOT NULL ');
        $this->dbforge->add_field('`pendidikan_kk_id` int unsigned NOT NULL ');
        $this->dbforge->add_field('`pendidikan_id` int unsigned NOT NULL ');
        $this->dbforge->add_field('`pendidikan_sedang_id` int unsigned NOT NULL ');
        $this->dbforge->add_field('`pekerjaan_id` int unsigned NOT NULL ');
        $this->dbforge->add_field('`status_kawin` tinyint unsigned NOT NULL ');
        $this->dbforge->add_field('`warganegara_id` int unsigned NOT NULL ');
        $this->dbforge->add_field('`dokumen_pasport` varchar(45) NULL ');
        $this->dbforge->add_field('`dokumen_kitas` int NULL ');
        $this->dbforge->add_field('`ayah_nik` varchar(16) NOT NULL ');
        $this->dbforge->add_field('`ibu_nik` varchar(16) NOT NULL ');
        $this->dbforge->add_field('`nama_ayah` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`nama_ibu` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`foto` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`golongan_darah_id` int NOT NULL ');
        $this->dbforge->add_field('`id_cluster` int NOT NULL ');
        $this->dbforge->add_field('`status` int unsigned NULL ');
        $this->dbforge->add_field('`alamat_sebelumnya` varchar(200) NOT NULL ');
        $this->dbforge->add_field('`alamat_sekarang` varchar(200) NOT NULL ');
        $this->dbforge->add_field("`status_dasar` tinyint NOT NULL DEFAULT '1' ");
        $this->dbforge->add_field('`hamil` int NULL ');
        $this->dbforge->add_field('`cacat_id` int NULL ');
        $this->dbforge->add_field('`sakit_menahun_id` int NOT NULL ');
        $this->dbforge->add_field("`jamkesmas` int NOT NULL DEFAULT '2' ");
        $this->dbforge->add_field('`akta_lahir` varchar(40) NOT NULL ');
        $this->dbforge->add_field('`akta_perkawinan` varchar(40) NOT NULL ');
        $this->dbforge->add_field('`tanggalperkawinan` date NOT NULL ');
        $this->dbforge->add_field('`akta_perceraian` varchar(40) NOT NULL ');
        $this->dbforge->add_field('`tanggalperceraian` date NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('tweb_penduduk', true);

        //# Create Table tweb_penduduk_agama
        $this->dbforge->add_field('`id` int unsigned NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(100) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('tweb_penduduk_agama', true);

        //# Create Table tweb_penduduk_hubungan
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(100) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('tweb_penduduk_hubungan', true);

        //# Create Table tweb_penduduk_kawin
        $this->dbforge->add_field('`id` int unsigned NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(100) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('tweb_penduduk_kawin', true);

        //# Create Table tweb_penduduk_mandiri
        $this->dbforge->add_field('`nik` varchar(20) NOT NULL ');
        $this->dbforge->add_field('`pin` varchar(60) NOT NULL ');
        $this->dbforge->add_field('`tanggal_buat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP DEFAULT_GENERATED on update CURRENT_TIMESTAMP');
        $this->dbforge->add_field('`last_login` datetime NOT NULL ');
        $this->dbforge->add_key('nik', true);
        $this->dbforge->create_table('tweb_penduduk_mandiri', true);

        //# Create Table tweb_penduduk_map
        $this->dbforge->add_field('`id` int NOT NULL ');
        $this->dbforge->add_field('`lat` varchar(24) NOT NULL ');
        $this->dbforge->add_field('`lng` varchar(24) NOT NULL ');
        $this->dbforge->create_table('tweb_penduduk_map', true);

        //# Create Table tweb_penduduk_pekerjaan
        $this->dbforge->add_field('`id` int unsigned NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(100) NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('tweb_penduduk_pekerjaan', true);

        //# Create Table tweb_penduduk_pendidikan
        $this->dbforge->add_field('`id` tinyint NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(50) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('tweb_penduduk_pendidikan', true);

        //# Create Table tweb_penduduk_pendidikan_kk
        $this->dbforge->add_field('`id` int unsigned NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(50) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('tweb_penduduk_pendidikan_kk', true);

        //# Create Table tweb_penduduk_sex
        $this->dbforge->add_field('`id` int unsigned NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(15) NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('tweb_penduduk_sex', true);

        //# Create Table tweb_penduduk_status
        $this->dbforge->add_field('`id` int unsigned NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(50) NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('tweb_penduduk_status', true);

        //# Create Table tweb_penduduk_umur
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(25) NULL ');
        $this->dbforge->add_field('`dari` int NULL ');
        $this->dbforge->add_field('`sampai` int NULL ');
        $this->dbforge->add_field('`status` int NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('tweb_penduduk_umur', true);

        //# Create Table tweb_penduduk_warganegara
        $this->dbforge->add_field('`id` int unsigned NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(25) NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('tweb_penduduk_warganegara', true);

        //# Create Table tweb_rtm
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`nik_kepala` int NOT NULL ');
        $this->dbforge->add_field('`no_kk` varchar(20) NOT NULL ');
        $this->dbforge->add_field('`tgl_daftar` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP DEFAULT_GENERATED on update CURRENT_TIMESTAMP');
        $this->dbforge->add_field('`kelas_sosial` int NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('tweb_rtm', true);

        //# Create Table tweb_rtm_hubungan
        $this->dbforge->add_field('`id` tinyint NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(20) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('tweb_rtm_hubungan', true);

        //# Create Table tweb_sakit_menahun
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(255) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('tweb_sakit_menahun', true);

        //# Create Table tweb_status_dasar
        $this->dbforge->add_field('`id` int unsigned NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(50) NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('tweb_status_dasar', true);

        //# Create Table tweb_surat_atribut
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`id_surat` int NOT NULL ');
        $this->dbforge->add_field('`id_tipe` tinyint NOT NULL ');
        $this->dbforge->add_field('`nama` varchar(40) NOT NULL ');
        $this->dbforge->add_field('`long` tinyint NOT NULL ');
        $this->dbforge->add_field('`kode` tinyint NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('tweb_surat_atribut', true);

        //# Create Table tweb_surat_format
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`nama` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`url_surat` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`kode_surat` varchar(10) NOT NULL ');
        $this->dbforge->add_field('`kunci` tinyint(1) NOT NULL ');
        $this->dbforge->add_field('`favorit` tinyint(1) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('tweb_surat_format', true);

        //# Create Table tweb_wil_clusterdesa
        $this->dbforge->add_field('`id` int NOT NULL auto_increment');
        $this->dbforge->add_field('`rt` varchar(10) NOT NULL ');
        $this->dbforge->add_field('`rw` varchar(10) NOT NULL ');
        $this->dbforge->add_field('`dusun` varchar(50) NOT NULL ');
        $this->dbforge->add_field('`id_kepala` int NOT NULL ');
        $this->dbforge->add_field('`lat` varchar(20) NOT NULL ');
        $this->dbforge->add_field('`lng` varchar(20) NOT NULL ');
        $this->dbforge->add_field('`zoom` int NOT NULL ');
        $this->dbforge->add_field('`path` text NOT NULL ');
        $this->dbforge->add_field('`map_tipe` varchar(20) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key(['rt', 'rw', 'dusun', 'id_kepala']);
        $this->dbforge->create_table('tweb_wil_clusterdesa', true);

        //# Create Table user
        $this->dbforge->add_field('`id` mediumint unsigned NOT NULL auto_increment');
        $this->dbforge->add_field('`username` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`password` varchar(40) NOT NULL ');
        $this->dbforge->add_field('`id_grup` int NOT NULL ');
        $this->dbforge->add_field('`email` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`last_login` datetime NOT NULL ');
        $this->dbforge->add_field('`active` tinyint unsigned NULL ');
        $this->dbforge->add_field('`nama` varchar(50) NULL ');
        $this->dbforge->add_field('`company` varchar(100) NULL ');
        $this->dbforge->add_field('`phone` varchar(20) NULL ');
        $this->dbforge->add_field('`foto` varchar(100) NOT NULL ');
        $this->dbforge->add_field('`session` varchar(40) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('user', true);

        //# Create Table user_grup
        $this->dbforge->add_field('`id` tinyint NOT NULL ');
        $this->dbforge->add_field('`nama` varchar(20) NOT NULL ');
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('user_grup', true);
    }

    public function down()
    {
        $this->dbforge->drop_table('analisis_indikator', true);
        $this->dbforge->drop_table('analisis_kategori_indikator', true);
        $this->dbforge->drop_table('analisis_klasifikasi', true);
        $this->dbforge->drop_table('analisis_master', true);
        $this->dbforge->drop_table('analisis_parameter', true);
        $this->dbforge->drop_table('analisis_partisipasi', true);
        $this->dbforge->drop_table('analisis_periode', true);
        $this->dbforge->drop_table('analisis_ref_state', true);
        $this->dbforge->drop_table('analisis_ref_subjek', true);
        $this->dbforge->drop_table('analisis_respon', true);
        $this->dbforge->drop_table('analisis_respon_bukti', true);
        $this->dbforge->drop_table('analisis_respon_hasil', true);
        $this->dbforge->drop_table('analisis_tipe_indikator', true);
        $this->dbforge->drop_table('area', true);
        $this->dbforge->drop_table('artikel', true);
        $this->dbforge->drop_table('config', true);
        $this->dbforge->drop_table('data_persil', true);
        $this->dbforge->drop_table('data_persil_jenis', true);
        $this->dbforge->drop_table('data_persil_log', true);
        $this->dbforge->drop_table('data_persil_peruntukan', true);
        $this->dbforge->drop_table('detail_log_penduduk', true);
        $this->dbforge->drop_table('dokumen', true);
        $this->dbforge->drop_table('gambar_gallery', true);
        $this->dbforge->drop_table('garis', true);
        $this->dbforge->drop_table('gis_simbol', true);
        $this->dbforge->drop_table('inbox', true);
        $this->dbforge->drop_table('kategori', true);
        $this->dbforge->drop_table('kelompok', true);
        $this->dbforge->drop_table('kelompok_anggota', true);
        $this->dbforge->drop_table('kelompok_master', true);
        $this->dbforge->drop_table('komentar', true);
        $this->dbforge->drop_table('kontak', true);
        $this->dbforge->drop_table('kontak_grup', true);
        $this->dbforge->drop_table('line', true);
        $this->dbforge->drop_table('log_bulanan', true);
        $this->dbforge->drop_table('log_penduduk', true);
        $this->dbforge->drop_table('log_perubahan_penduduk', true);
        $this->dbforge->drop_table('log_surat', true);
        $this->dbforge->drop_table('lokasi', true);
        $this->dbforge->drop_table('media_sosial', true);
        $this->dbforge->drop_table('menu', true);
        $this->dbforge->drop_table('outbox', true);
        $this->dbforge->drop_table('point', true);
        $this->dbforge->drop_table('polygon', true);
        $this->dbforge->drop_table('program', true);
        $this->dbforge->drop_table('program_peserta', true);
        $this->dbforge->drop_table('sentitems', true);
        $this->dbforge->drop_table('setting_modul', true);
        $this->dbforge->drop_table('setting_sms', true);
        $this->dbforge->drop_table('sys_traffic', true);
        $this->dbforge->drop_table('tweb_alamat_sekarang', true);
        $this->dbforge->drop_table('tweb_cacat', true);
        $this->dbforge->drop_table('tweb_desa_pamong', true);
        $this->dbforge->drop_table('tweb_golongan_darah', true);
        $this->dbforge->drop_table('tweb_keluarga', true);
        $this->dbforge->drop_table('tweb_penduduk', true);
        $this->dbforge->drop_table('tweb_penduduk_agama', true);
        $this->dbforge->drop_table('tweb_penduduk_hubungan', true);
        $this->dbforge->drop_table('tweb_penduduk_kawin', true);
        $this->dbforge->drop_table('tweb_penduduk_mandiri', true);
        $this->dbforge->drop_table('tweb_penduduk_map', true);
        $this->dbforge->drop_table('tweb_penduduk_pekerjaan', true);
        $this->dbforge->drop_table('tweb_penduduk_pendidikan', true);
        $this->dbforge->drop_table('tweb_penduduk_pendidikan_kk', true);
        $this->dbforge->drop_table('tweb_penduduk_sex', true);
        $this->dbforge->drop_table('tweb_penduduk_status', true);
        $this->dbforge->drop_table('tweb_penduduk_umur', true);
        $this->dbforge->drop_table('tweb_penduduk_warganegara', true);
        $this->dbforge->drop_table('tweb_rtm', true);
        $this->dbforge->drop_table('tweb_rtm_hubungan', true);
        $this->dbforge->drop_table('tweb_sakit_menahun', true);
        $this->dbforge->drop_table('tweb_status_dasar', true);
        $this->dbforge->drop_table('tweb_surat_atribut', true);
        $this->dbforge->drop_table('tweb_surat_format', true);
        $this->dbforge->drop_table('tweb_wil_clusterdesa', true);
        $this->dbforge->drop_table('user', true);
        $this->dbforge->drop_table('user_grup', true);
    }
}
