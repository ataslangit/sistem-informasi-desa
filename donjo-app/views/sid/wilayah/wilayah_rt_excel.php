<?php
$tgl = date('d_m_Y');
header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=wilayah_rt_{$tgl}.xls");
header('Pragma: no-cache');
header('Expires: 0');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

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
                <h3> DATA RT DAN JUMLAH PENDUDUK </h3>
                <h4> DUSUN <?= strtoupper(unpenetration(ununderscore($dusun))) ?> RW <?= unpenetration(ununderscore($rw)) ?></h4>
            </div>
            <br>
            <table class="border thick">
                <thead>
                    <tr class="border thick">
                        <th>No</th>
                        <th width="50">RT</th>
                        <th width="100">NIK Ketua RT</th>
                        <th width="100">Nama Ketua RT</th>
                        <th width="50">Jumlah KK</th>
                        <th width="50">Jiwa</th>
                        <th width="50">LK</th>
                        <th width="50">PR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($main as $data) : ?>
                        <tr>
                            <td align="center" width="2"><?= $data['no'] ?></td>
                            <td><?= $data['rt'] ?></td>
                            <td><?= $data['nik_ketua'] ?></td>
                            <td><?= $data['nama_ketua'] ?></td>
                            <td align="right"><?= $data['jumlah_kk'] ?></td>
                            <td align="right"><?= $data['jumlah_warga'] ?></td>
                            <td align="right"><?= $data['jumlah_warga_l'] ?></td>
                            <td align="right"><?= $data['jumlah_warga_p'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tr style="background-color:#BDD498;font-weight:bold;">
                    <td colspan="4" width="50"><label>TOTAL</label></th>
                    <td align="right"><?= $total['jmlkk'] ?></th>
                    <td align="right"><?= $total['jmlwarga'] ?></th>
                    <td align="right"><?= $total['jmlwargal'] ?></th>
                    <td align="right"><?= $total['jmlwargap'] ?></th>
                </tr>
                </tbody>
            </table>
        </div>

        <label>Tanggal cetak : &nbsp; </label><?= tgl_indo(date('Y m d')) ?>
    </div>
</body>

</html>
