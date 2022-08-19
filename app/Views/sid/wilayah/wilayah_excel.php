<?php
$tgl = date('d_m_Y');
header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=wilayah_administatif_{$tgl}.xls");
header('Pragma: no-cache');
header('Expires: 0');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Data Wilayah</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="<?= base_url() ?>assets/css/report.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="container">
        <!-- Print Body -->
        <div id="body">
            <div class="header" align="center"><label align="left"><?= get_identitas() ?></label>
                <h3> DATA WILAYAH ADMINISTRASI </h3>
            </div>
            <br>
            <table class="border">
                <thead>
                    <tr class="border">
                        <th width="30">No</th>
                        <th width="200">Nama Dusun</th>
                        <th width="200">Nama Kadus</th>
                        <th width="150">RW</th>
                        <th width="150">RT</th>
                        <th width="150">KK</th>
                        <th width="150">Jiwa</th>
                        <th width="150">LK</th>
                        <th width="150">PR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($main as $data) : ?>
                        <tr>
                            <td align="center" width="2"><?= $data['no'] ?></td>

                            <td><?= strtoupper(ununderscore($data['dusun'])) ?></td>
                            <td><?= $data['nama_kadus'] ?></td>
                            <td align="right"><?= $data['jumlah_rw'] ?></td>
                            <td align="right"><?= $data['jumlah_rt'] ?></td>
                            <td align="right"><?= $data['jumlah_kk'] ?></td>
                            <td align="right"><?= $data['jumlah_warga'] ?></td>
                            <td align="right"><?= $data['jumlah_warga_l'] ?></td>
                            <td align="right"><?= $data['jumlah_warga_p'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

                <tr style="background-color:#BDD498;font-weight:bold;">
                    <td colspan="3" align="left"><label>TOTAL</label></td>
                    <td align="right"><?= $total['total_rw'] ?></td>
                    <td align="right"><?= $total['total_rt'] ?></td>
                    <td align="right"><?= $total['total_kk'] ?></td>
                    <td align="right"><?= $total['total_warga'] ?></td>
                    <td align="right"><?= $total['total_warga_l'] ?></td>
                    <td align="right"><?= $total['total_warga_p'] ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <label>Tanggal cetak : &nbsp; </label><?= tgl_indo(date('Y m d')) ?>
    </div>
</body>

</html>
