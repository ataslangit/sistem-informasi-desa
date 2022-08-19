<?php
$tgl = date('d_m_Y');
header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=Statistik_penduduk_{$tgl}.xls");
header('Pragma: no-cache');
header('Expires: 0');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Statistik Kependudukan menurut</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="<?= base_url() ?>assets/css/report.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="container">
        <!-- Print Body -->
        <div id="body">
            <table>
                <tbody>
                    <tr>
                        <td style="padding: 5px 20px;">

                            <br>
                            <table class="border thick data">
                                <thead>
                                    <tr class="thick">
                                        <th class="thick">No</th>
                                        <th class="thick">Kategori Kelompok</th>
                                        <th class="thick">Jumlah</th>
                                        <th class="thick" width="60">Laki-laki</th>
                                        <th class="thick" width="60">Perempuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($main as $data) : ?>
                                        <tr>
                                            <td class="thick" align="center" width="2"><?= $data['no'] ?></td>
                                            <td class="thick"><?= $data['nama'] ?></td>
                                            <td class="thick"><?= $data['jumlah'] ?></td>
                                            <td class="thick"><?= $data['laki'] ?></td>
                                            <td class="thick"><?= $data['perempuan'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>


                            <br>


                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <label>Tanggal cetak : &nbsp; </label><?= tgl_indo(date('Y m d')) ?>
    </div>
</body>

</html>
