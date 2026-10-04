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
        ];

        foreach ($templates as $item) {
            LetterTemplate::updateOrCreate(
                ['code' => $item['code']],
                $item
            );
        }
    }
}
