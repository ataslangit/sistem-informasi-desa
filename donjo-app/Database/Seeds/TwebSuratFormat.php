<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebSuratFormat extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `tweb_surat_format` (`id`, `nama`, `url_surat`, `kode_surat`, `kunci`, `favorit`) VALUES
        (1, 'Keterangan', 'surat_ket_pengantar', 'F1', 0, 0),
        (2, 'Keterangan Penduduk', 'surat_ket_penduduk', 'FS-00X/DES', 0, 0),
        (3, 'Biodata Penduduk', 'surat_bio_penduduk', 'FS-00X/DES', 0, 0),
        (4, 'Keterangan Pindah Penduduk', 'surat_ket_pindah_penduduk', 'FS-00X/DES', 0, 0),
        (5, 'Keterangan Jual Beli', 'surat_ket_jual_beli', 'FS-00X/DES', 0, 0),
        (6, 'Pengantar Pindah Antar Kabupaten/ Provinsi', 'surat_pindah_antar_kab_prov', 'FS-00X/DES', 0, 0),
        (7, 'Pengantar SKCK', 'surat_ket_catatan_kriminal', 'FS-00X/DES', 0, 0),
        (8, 'Keterangan KTP dalam Proses', 'surat_ket_ktp_dlm_proses', 'FS-00X/DES', 0, 0),
        (9, 'Keterangan Beda Nama', 'surat_ket_beda_nama', 'FS-00X/DES', 0, 0),
        (10, 'Keterangan Bepergian / Jalan', 'surat_jalan', 'FS-00X/DES', 0, 0),
        (11, 'Keterangan Kurang Mampu', 'surat_ket_kurang_mampu', 'FS-00X/DES', 0, 0),
        (12, 'Pengantar Izin Keramaian', 'surat_izin_keramaian', 'FS-00X/DES', 0, 0),
        (13, 'Pengantar Laporan Kehilangan', 'surat_lap_kehilangan', 'FS-00X/DES', 0, 0),
        (14, 'Keterangan Usaha', 'surat_ket_usaha', 'FS-00X/DES', 0, 0),
        (16, 'Keterangan Domisili Usaha', 'surat_ket_domisili_usaha', 'FS-00X/DES', 0, 0),
        (17, 'Keterangan Kelahiran', 'surat_ket_kelahiran', 'FS-00X/DES', 0, 0),
        (18, 'Keterangan Kehilangan', 'surat_ket_kehilangan', 'FS-00X/DES', 0, 0),
        (19, 'Permohonan Akta Lahir', 'surat_permohonan_akta', 'FS-00X/DES', 0, 0),
        (20, 'Pernyataan Akta Lahir', 'surat_pernyataan_akta', 'FS-00X/DES', 0, 0),
        (21, 'Permohonan Duplikat Kelahiran', 'surat_permohonan_duplikat_kelahiran', 'FS-00X/DES', 0, 0),
        (22, 'Keterangan Kematian', 'surat_ket_kematian', 'FS-00X/DES', 0, 0),
        (23, 'Keterangan Lahir Mati', 'surat_ket_lahir_mati', 'FS-00X/DES', 0, 0),
        (24, 'Keterangan Untuk Nikah (N-1)', 'surat_ket_nikah', 'FS-00X/DES', 0, 0),
        (25, 'Keterangan Asal Usul (N-2)', 'surat_ket_asalusul', 'FS-00X/DES', 0, 0),
        (26, 'Persetujuan Mempelai (N-3)', 'surat_persetujuan_mempelai', 'FS-00X/DES', 0, 0),
        (27, 'Keterangan Tentang Orang Tua (N-4)', 'surat_ket_orangtua', 'FS-00X/DES', 0, 0),
        (28, 'Izin Orang Tua(N-5)', 'surat_izin_orangtua', 'FS-00X/DES', 0, 0),
        (29, 'Keterangan Kematian Suami/Istri(N-6)', 'surat_ket_kematian_suami_istri', 'FS-00X/DES', 0, 0),
        (30, 'Pemberitahuan Kehendak Nikah (N-7)', 'surat_kehendak_nikah', 'FS-00X/DES', 0, 0);");
    }
}
