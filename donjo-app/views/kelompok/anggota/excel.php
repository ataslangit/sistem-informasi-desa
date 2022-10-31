<?php
$tgl =  date('d_m_Y');
$nk = $kelompok['nama'];
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=data_anggota_kelompok_$nk_$tgl.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Data Kelompok - <?php echo $kelompok['nama']?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="<?php echo base_url()?>assets/css/report.css" rel="stylesheet">
    <style>
        .textx {
            mso-number-format: "\@";
        }

        td,
        th {
            font-size: 8pt;
        }

    </style>
</head>

<body>
    <div id="container">
        <!-- Print Body -->
        <div id="body">
            <div class="header" align="center">
                <label align="left"><?php echo get_identitas()?></label>
                <h3> DATA KELOMPOK - <?php echo $kelompok['nama']?></h3>
            </div>
            <table border=1 class="border thick">
                <thead>
                    <tr class="border thick">
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Umur (Tahun)</th>
                        <th>Jenis Kelamin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($main as $data): ?>
                    <tr>
                        <td><?php echo $data['no']?></td>
                        <td><?php echo $data['nik']?></td>
                        <td><?php echo $data['nama']?></td>
                        <td><?php echo $data['alamat']?></td>
                        <td><?php echo $data['umur']?></td>
                        <td><?php if($data['sex']==1) echo "Laki-laki"; else echo "Perempuan";?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <label>Tanggal cetak : &nbsp; </label><?php echo tgl_indo(date("Y m d"))?>
    </div>
</body>

</html>
