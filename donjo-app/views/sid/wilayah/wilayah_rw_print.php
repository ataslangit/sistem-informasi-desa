<!DOCTYPE html>
<html lang="id">

<head>
    <title>Data Wilayah</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="<?php echo base_url()?>assets/css/report.css" rel="stylesheet">
</head>

<body>
    <div id="container">
        <!-- Print Body -->
        <div id="body">
            <div class="header" align="center"><label align="left"><?php echo get_identitas()?></label>
                <h3> DATA RW DAN JUMLAH PENDUDUK </h3>
                <h4> DUSUN <?php echo strtoupper(unpenetration(ununderscore($dusun)))?></h4>
            </div>
            <br>
            <table class="border thick">
                <thead>
                    <tr class="border thick">
                        <th>No</th>
                        <th width="50">RW</th>
                        <th width="100">NIK Ketua RW</th>
                        <th width="100">Nama Ketua RW</th>
                        <th width="50">Jumlah RT</th>
                        <th width="50">Jumlah KK</th>
                        <th width="50">Jiwa</th>
                        <th width="50">LK</th>
                        <th width="50">PR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($main as $data): ?>
                    <tr>
                        <td align="center" width="2"><?php echo $data['no']?></td>
                        <td><?php echo $data['rw']?></td>
                        <td><?php echo $data['nik_ketua']?></td>
                        <td><?php echo $data['nama_ketua']?></td>
                        <td align="right"><?php echo $data['jumlah_rt']?></td>
                        <td align="right"><?php echo $data['jumlah_kk']?></td>
                        <td align="right"><?php echo $data['jumlah_warga']?></td>
                        <td align="right"><?php echo $data['jumlah_warga_l']?></td>
                        <td align="right"><?php echo $data['jumlah_warga_p']?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tr style="background-color:#BDD498;font-weight:bold;">
                    <td colspan="4" width="50"><label>TOTAL</label></th>
                    <td align="right"><?php echo $total['jmlrt']?></th>
                    <td align="right"><?php echo $total['jmlkk']?></th>
                    <td align="right"><?php echo $total['jmlwarga']?></th>
                    <td align="right"><?php echo $total['jmlwargal']?></th>
                    <td align="right"><?php echo $total['jmlwargap']?></th>
                </tr>
                </tbody>
            </table>
        </div>

        <label>Tanggal cetak : &nbsp; </label><?php echo tgl_indo(date("Y m d"))?>
    </div>
</body>

</html>
