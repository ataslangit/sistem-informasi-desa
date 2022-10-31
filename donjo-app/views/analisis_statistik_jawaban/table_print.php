<!DOCTYPE html>
<html lang="id">

<head>
    <title>Data Analisis</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="<?php echo base_url()?>assets/css/report.css" rel="stylesheet">
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
            </div>
            <br>
            <table class="border thick">
                <thead>
                    <tr class="border thick">
                        <th width="10">No</th>
                        <th align="left">Pertanyaan</th>
                        <th align="left">Total</th>
                        <th align="left">Kode</th>
                        <th align="left" colspan="2">Jawaban</th>
                        <th align="left">Responden</th>
                        <th align="left">Tipe Indikator</th>
                        <th align="left">Kategori Indikator</th>
                        <th align="left">Aksi Analisis</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach($main as $data): ?>
                    <tr>
                        <td align="center" width="2"><?php echo $data['no']?></td>
                        <td><?php echo $data['pertanyaan']?></a></td>
                        <td align="right"><?php echo $data['bobot']?></td>
                        <td><?php echo $data['nomor']?></td>
                        <td align="right">
                            <?php foreach($data['par'] as $par): ?>
                            <?php echo $par['kode_jawaban']?>.<br>
                            <?php endforeach; ?>
                        </td>
                        <td>
                            <?php foreach($data['par'] as $par): ?>
                            <?php echo $par['jawaban']?><br>
                            <?php endforeach; ?>
                        </td>
                        <td align="right">
                            <?php foreach($data['par'] as $par): ?>
                            <?php echo $par['jml_p']?><br>
                            <?php endforeach; ?>
                        </td>
                        <td><?php echo $data['tipe_indikator']?></td>
                        <td><?php echo $data['kategori']?></td>
                        <td><?php echo $data['act_analisis']?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <label>Tanggal cetak : &nbsp; </label><?php echo tgl_indo(date("Y m d"))?>
    </div>
</body>

</html>
