<?php
$tgl = date('d_m_Y');

header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=penduduk_{$tgl}.xls");
header('Pragma: no-cache');
header('Expires: 0');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Data Penduduk</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="<?= base_url() ?>assets/css/report.css" rel="stylesheet" type="text/css">
    <style>
        .textx {
            mso-number-format: "\@";
        }

        td,
        th {
            font-size: 8pt;
            mso-number-format: "\@";
        }
    </style>
</head>

<body>
    <div id="container">
        <!-- Print Body -->
        <div id="body">
            <table border=1 class="border thick">
                <thead>
                    <tr class="border thick">
                        <th>Dusun</th>
                        <th>RW</th>
                        <th>RT</th>
                        <th>Nama</th>
                        <th>Nomor KK</th>
                        <th>Nomor NIK</th>
                        <th>Jenis Kelamin</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Agama</th>
                        <th>Pendidikan (dLm KK)</th>
                        <th>Pendidikan (sdg ditemph)</th>
                        <th>Pekerjaan</th>
                        <th>Kawin</th>
                        <th>Hub. Keluarga</th>
                        <th>Kewarganegaraan</th>
                        <th>Nama Ayah</th>
                        <th>Nama Ibu</th>
                        <th>Gol. Darah</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($main as $data) : ?>
                        <tr>
                            <td><?= strtoupper(ununderscore($data['dusun'])) ?></td>
                            <td><?= $data['rw'] ?></td>
                            <td><?= $data['rt'] ?></td>
                            <td><?= strtoupper($data['nama']) ?></td>
                            <td><?= $data['no_kk'] ?> </td>
                            <td><?= $data['nik'] ?></td>
                            <td><?= $data['sex'] ?></td>
                            <td><?= $data['tempatlahir'] ?></td>
                            <td><?= $data['tanggallahir'] ?></td>
                            <td><?= $data['agama_id'] ?></td>
                            <td><?= $data['pendidikan_kk_id'] ?></td>
                            <td><?= $data['pendidikan_sedang_id'] ?></td>
                            <td><?= $data['pekerjaan_id'] ?></td>
                            <td><?= $data['status_kawin'] ?></td>
                            <td><?= $data['kk_level'] ?></td>
                            <td><?= $data['warganegara_id'] ?></td>
                            <td><?= $data['nama_ayah'] ?></td>
                            <td><?= $data['nama_ibu'] ?></td>
                            <td><?= $data['golongan_darah_id'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
