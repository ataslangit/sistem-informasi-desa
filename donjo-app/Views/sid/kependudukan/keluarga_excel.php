<?php $tgl_cetak = date("d-m-Y");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Data_Keluarga_$tgl_cetak_$tgl.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Data Keluarga</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="<?php echo base_url()?>assets/css/report.css" rel="stylesheet">
    <style>
        td {
            mso-number-format: "\@";
        }

        td,
        th {
            font-size: 6.5pt;
        }

    </style>
</head>

<body>
    <div id="container">
        <!-- Print Body -->
        <div id="body">
            <div class="header" align="center"><label align="left"><?php echo get_identitas()?></label>
                <h3> DATA KELUARGA </h3>
            </div>
            <br>
            <table class="border thick">
                <thead>
                    <tr class="border thick">
                        <th>No</th>
                        <th width="150">Nomor KK</th>
                        <th width="150">NIK Kepala Keluarga</th>
                        <th width="200">Kepala Keluarga</th>
                        <th width="100">Jumlah Anggota</th>
                        <th width="60">Jenis Kelamin</th>
                        <th width="60">Dusun</th>
                        <th width="30">RW</th>
                        <th width="30">RT</th>
                        <th width="100">Tanggal Terdaftar</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($main as $data): ?>
                    <tr>
                        <td width="2"><?php echo $data['no']?></td>
                        <td><?php echo $data['no_kk']?></td>
                        <td><?php echo $data['nik']?></td>
                        <td><?php echo strtoupper($data['kepala_kk'])?></td>
                        <td><?php echo $data['jumlah_anggota']?></td>
                        <td><?php echo $data['sex']?></td>
                        <td><?php echo strtoupper(ununderscore($data['dusun']))?></td>
                        <td><?php echo strtoupper($data['rw'])?></td>
                        <td><?php echo strtoupper($data['rt'])?></td>
                        <td><?php echo tgl_indo($data['tgl_daftar'])?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <label>Tanggal cetak : &nbsp; </label><?php echo tgl_indo(date("Y m d"))?>
    </div>
</body>

</html>
