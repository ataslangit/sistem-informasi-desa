<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\LetterTemplate;
use Illuminate\Database\Seeder;

class LetterTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'code' => 'SKTM',
                'name' => 'Surat Keterangan Tidak Mampu (SKTM)',
                'description' => 'Surat keterangan untuk persyaratan beasiswa, keringanan biaya pendidikan, pengajuan BPJS PBI, atau bantuan sosial.',
                'content_template' => '<p>Yang bertanda tangan di bawah ini Kepala Desa <strong>[NAMA_DESA]</strong>, Kecamatan <strong>[NAMA_KECAMATAN]</strong>, Kabupaten <strong>[NAMA_KABUPATEN]</strong>, dengan ini menerangkan bahwa:</p>
<table style="width: 100%; margin-top: 10px; margin-bottom: 10px;">
    <tr><td style="width: 30%;">Nama Lengkap</td><td style="width: 5%;">:</td><td><strong>[NAMA]</strong></td></tr>
    <tr><td>NIK</td><td>:</td><td>[NIK]</td></tr>
    <tr><td>Nomor KK</td><td>:</td><td>[NO_KK]</td></tr>
    <tr><td>Tempat / Tgl Lahir</td><td>:</td><td>[TEMPAT_TANGGAL_LAHIR]</td></tr>
    <tr><td>Jenis Kelamin</td><td>:</td><td>[JENIS_KELAMIN]</td></tr>
    <tr><td>Agama</td><td>:</td><td>[AGAMA]</td></tr>
    <tr><td>Pekerjaan</td><td>:</td><td>[PEKERJAAN]</td></tr>
    <tr><td>Alamat</td><td>:</td><td>[ALAMAT], RT [RT] / RW [RW], [DUSUN]</td></tr>
</table>
<p>Berdasarkan data kependudukan dan pemantauan di lapangan, yang bersangkutan benar-benar merupakan warga desa kami yang berpenghasilan rendah dan tergolong dalam keluarga <strong>Kurang Mampu / Pra-Sejahtera</strong>.</p>
<p>Surat keterangan ini diberikan untuk keperluan: <strong>[KEPERLUAN]</strong>.</p>
<p>Demikian surat keterangan ini kami buat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya.</p>',
                'required_fields' => [
                    ['name' => 'school_or_institution', 'label' => 'Nama Instansi / Sekolah Tujuan', 'type' => 'text', 'required' => false],
                ],
                'is_active' => true,
            ],
            [
                'code' => 'SKCK',
                'name' => 'Surat Pengantar SKCK',
                'description' => 'Surat pengantar untuk pengurusan Surat Keterangan Catatan Kepolisian di Polsek / Polres.',
                'content_template' => '<p>Kepala Desa <strong>[NAMA_DESA]</strong>, Kecamatan <strong>[NAMA_KECAMATAN]</strong>, Kabupaten <strong>[NAMA_KABUPATEN]</strong>, menerangkan dengan sebenarnya bahwa:</p>
<table style="width: 100%; margin-top: 10px; margin-bottom: 10px;">
    <tr><td style="width: 30%;">Nama Lengkap</td><td style="width: 5%;">:</td><td><strong>[NAMA]</strong></td></tr>
    <tr><td>NIK</td><td>:</td><td>[NIK]</td></tr>
    <tr><td>Nomor KK</td><td>:</td><td>[NO_KK]</td></tr>
    <tr><td>Tempat / Tgl Lahir</td><td>:</td><td>[TEMPAT_TANGGAL_LAHIR]</td></tr>
    <tr><td>Jenis Kelamin</td><td>:</td><td>[JENIS_KELAMIN]</td></tr>
    <tr><td>Status Perkawinan</td><td>:</td><td>[STATUS_KAWIN]</td></tr>
    <tr><td>Agama</td><td>:</td><td>[AGAMA]</td></tr>
    <tr><td>Pendidikan</td><td>:</td><td>[PENDIDIKAN]</td></tr>
    <tr><td>Pekerjaan</td><td>:</td><td>[PEKERJAAN]</td></tr>
    <tr><td>Alamat</td><td>:</td><td>[ALAMAT], RT [RT] / RW [RW], [DUSUN]</td></tr>
</table>
<p>Adalah benar yang bersangkutan penduduk Desa [NAMA_DESA] yang berkelakuan baik, tidak sedang menjalani proses pidana hukum, serta belum pernah terlibat dalam tindak kriminalitas.</p>
<p>Surat pengantar ini dibuat untuk kelengkapan berkas: <strong>[KEPERLUAN]</strong>.</p>
<p>Demikian surat pengantar ini dibuat untuk dapat dipergunakan di Kepolisian Sektor / Resor setempat.</p>',
                'required_fields' => [],
                'is_active' => true,
            ],
            [
                'code' => 'DOMISILI',
                'name' => 'Surat Keterangan Domisili',
                'description' => 'Surat keterangan bukti bertempat tinggal atau berdomisili sah di wilayah desa.',
                'content_template' => '<p>Yang bertanda tangan di bawah ini Kepala Desa <strong>[NAMA_DESA]</strong>, Kecamatan <strong>[NAMA_KECAMATAN]</strong>, Kabupaten <strong>[NAMA_KABUPATEN]</strong>, dengan ini menerangkan bahwa:</p>
<table style="width: 100%; margin-top: 10px; margin-bottom: 10px;">
    <tr><td style="width: 30%;">Nama Lengkap</td><td style="width: 5%;">:</td><td><strong>[NAMA]</strong></td></tr>
    <tr><td>NIK</td><td>:</td><td>[NIK]</td></tr>
    <tr><td>Tempat / Tgl Lahir</td><td>:</td><td>[TEMPAT_TANGGAL_LAHIR]</td></tr>
    <tr><td>Jenis Kelamin</td><td>:</td><td>[JENIS_KELAMIN]</td></tr>
    <tr><td>Pekerjaan</td><td>:</td><td>[PEKERJAAN]</td></tr>
    <tr><td>Agama</td><td>:</td><td>[AGAMA]</td></tr>
    <tr><td>Alamat Domisili</td><td>:</td><td>[ALAMAT], RT [RT] / RW [RW], [DUSUN]</td></tr>
</table>
<p>Bahwa nama yang bersangkutan benar pada saat ini berdomisili dan bertempat tinggal di alamat tersebut di atas di lingkungan Desa kami.</p>
<p>Surat keterangan ini dipergunakan untuk keperluan: <strong>[KEPERLUAN]</strong>.</p>
<p>Demikian keterangan ini kami buat agar yang berkepentingan maklum adanya.</p>',
                'required_fields' => [],
                'is_active' => true,
            ],
            [
                'code' => 'SKU',
                'name' => 'Surat Keterangan Usaha (SKU)',
                'description' => 'Surat keterangan kepemilikan usaha mikro/kecil untuk pengajuan kredit bank/KUR atau legalitas usaha.',
                'content_template' => '<p>Pemerintah Desa <strong>[NAMA_DESA]</strong>, Kecamatan <strong>[NAMA_KECAMATAN]</strong>, Kabupaten <strong>[NAMA_KABUPATEN]</strong>, menerangkan bahwa:</p>
<table style="width: 100%; margin-top: 10px; margin-bottom: 10px;">
    <tr><td style="width: 30%;">Nama Lengkap</td><td style="width: 5%;">:</td><td><strong>[NAMA]</strong></td></tr>
    <tr><td>NIK</td><td>:</td><td>[NIK]</td></tr>
    <tr><td>Tempat / Tgl Lahir</td><td>:</td><td>[TEMPAT_TANGGAL_LAHIR]</td></tr>
    <tr><td>Pekerjaan</td><td>:</td><td>[PEKERJAAN]</td></tr>
    <tr><td>Alamat Pemilik</td><td>:</td><td>[ALAMAT], RT [RT] / RW [RW], [DUSUN]</td></tr>
</table>
<p>Benar nama tersebut di atas mempunyai dan menjalankan bidang usaha sebagai berikut:</p>
<table style="width: 100%; margin-top: 10px; margin-bottom: 10px;">
    <tr><td style="width: 30%;">Nama / Jenis Usaha</td><td style="width: 5%;">:</td><td><strong>[NAMA_USAHA]</strong></td></tr>
    <tr><td>Lokasi Usaha</td><td>:</td><td>[LOKASI_USAHA]</td></tr>
    <tr><td>Lama Berdiri</td><td>:</td><td>[LAMA_USAHA]</td></tr>
</table>
<p>Surat Keterangan Usaha ini diterbitkan untuk keperluan: <strong>[KEPERLUAN]</strong>.</p>
<p>Demikian surat keterangan ini kami berikan untuk dipergunakan sebagaimana mestinya.</p>',
                'required_fields' => [
                    ['name' => 'business_name', 'label' => 'Nama / Jenis Usaha', 'type' => 'text', 'required' => true],
                    ['name' => 'business_location', 'label' => 'Alamat Lokasi Usaha', 'type' => 'text', 'required' => true],
                    ['name' => 'business_since', 'label' => 'Tahun / Lama Berdiri Usaha', 'type' => 'text', 'required' => true],
                ],
                'is_active' => true,
            ],
            [
                'code' => 'SKPWNI',
                'name' => 'Surat Keterangan Pindah (SKPWNI)',
                'description' => 'Surat keterangan pengantar pindah domisili penduduk antar desa, kecamatan, kabupaten, atau provinsi.',
                'content_template' => '<p>Yang bertanda tangan di bawah ini Kepala Desa <strong>[NAMA_DESA]</strong>, Kecamatan <strong>[NAMA_KECAMATAN]</strong>, Kabupaten <strong>[NAMA_KABUPATEN]</strong>, Provinsi <strong>[NAMA_PROVINSI]</strong>, menerangkan bahwa:</p>
<table style="width: 100%; margin-top: 10px; margin-bottom: 10px;">
    <tr><td style="width: 30%;">Nama Lengkap</td><td style="width: 5%;">:</td><td><strong>[NAMA]</strong></td></tr>
    <tr><td>NIK</td><td>:</td><td>[NIK]</td></tr>
    <tr><td>Nomor KK</td><td>:</td><td>[NO_KK]</td></tr>
    <tr><td>Alamat Asal</td><td>:</td><td>[ALAMAT], RT [RT] / RW [RW], [DUSUN]</td></tr>
    <tr><td>Desa / Kelurahan Asal</td><td>:</td><td>[NAMA_DESA]</td></tr>
    <tr><td>Kecamatan Asal</td><td>:</td><td>[NAMA_KECAMATAN]</td></tr>
    <tr><td>Kabupaten / Kota Asal</td><td>:</td><td>[NAMA_KABUPATEN]</td></tr>
    <tr><td>Provinsi Asal</td><td>:</td><td>[NAMA_PROVINSI]</td></tr>
</table>
<p>Yang bersangkutan telah mengajukan permohonan pindah domisili dengan data tujuan kepindahan sebagai berikut:</p>
<table style="width: 100%; margin-top: 10px; margin-bottom: 10px;">
    <tr><td style="width: 30%;">Alamat Tujuan</td><td style="width: 5%;">:</td><td><strong>[ALAMAT_TUJUAN]</strong></td></tr>
    <tr><td>Desa / Kelurahan Tujuan</td><td>:</td><td>[DESA_TUJUAN]</td></tr>
    <tr><td>Kecamatan Tujuan</td><td>:</td><td>[KECAMATAN_TUJUAN]</td></tr>
    <tr><td>Kabupaten / Kota Tujuan</td><td>:</td><td>[KABUPATEN_TUJUAN]</td></tr>
    <tr><td>Provinsi Tujuan</td><td>:</td><td>[PROVINSI_TUJUAN]</td></tr>
    <tr><td>Alasan Pindah</td><td>:</td><td>[ALASAN_PINDAH]</td></tr>
    <tr><td>Jumlah Pengikut</td><td>:</td><td>[JUMLAH_PENGIKUT] Orang</td></tr>
</table>
<p>Surat keterangan pindah ini diterbitkan untuk keperluan: <strong>[KEPERLUAN]</strong>.</p>
<p>Demikian surat keterangan ini kami buat untuk dapat dipergunakan sebagaimana mestinya.</p>',
                'required_fields' => [
                    ['name' => 'target_province', 'label' => 'Provinsi Tujuan', 'type' => 'text', 'required' => true],
                    ['name' => 'target_regency', 'label' => 'Kabupaten / Kota Tujuan', 'type' => 'text', 'required' => true],
                    ['name' => 'target_district', 'label' => 'Kecamatan Tujuan', 'type' => 'text', 'required' => true],
                    ['name' => 'target_village', 'label' => 'Desa / Kelurahan Tujuan', 'type' => 'text', 'required' => true],
                    ['name' => 'target_address', 'label' => 'Alamat Spesifik Tujuan (Jalan/RT/RW)', 'type' => 'text', 'required' => true],
                    ['name' => 'move_reason', 'label' => 'Alasan Kepindahan', 'type' => 'text', 'required' => true],
                    ['name' => 'family_members_count', 'label' => 'Jumlah Anggota Keluarga yang Pindah', 'type' => 'number', 'required' => false],
                ],
                'is_active' => true,
            ],
        ];

        foreach ($templates as $item) {
            LetterTemplate::updateOrCreate(
                ['code' => $item['code']],
                $item
            );
        }
    }
}
