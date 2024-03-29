<!DOCTYPE html>
<html lang="id">

<head>
    <title>Data Analisis</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="<?php echo base_url('assets/css/report.css') ?>" rel="stylesheet">
    <style>
        td {
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
            <div class="header" align="center"><label align="left"><?php echo get_identitas()?></label>
                <h3> DATA Analisis </h3>
                <h4><?php echo $analisis_statistik_pertanyaan['pertanyaan']?></h4>
                <h4><?php echo $analisis_statistik_jawaban['jawaban']?></h4>
            </div>
            <br>
            <table class="border thick">
                <thead>
                    <tr class="border thick">
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Dusun</th>
                        <th>RW</th>
                        <th>RT</th>
                        <th>Umur</th>
                        <th>J. Kelamin</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach($main as $data): ?>
                    <tr>
                        <td width="2"><?php echo $data['no']?></td>
                        <td class="textx"><?php echo $data['nik']?></td>
                        <td><?php echo strtoupper($data['nama'])?></td>
                        <td><?php echo strtoupper(ununderscore($data['dusun']))?></td>
                        <td><?php echo $data['rw']?></td>
                        <td><?php echo $data['rt']?></td>
                        <td align="right"><?php echo $data['umur']?></td>
                        <td><?php echo $data['sex']?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <label>Tanggal cetak : &nbsp; </label><?php echo tgl_indo(date("Y m d"))?>
    </div>
</body>

</html>
