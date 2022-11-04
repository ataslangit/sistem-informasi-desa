<!DOCTYPE html>
<html lang="id">

<head>
    <title>Laporan Statistik</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="<?php echo base_url()?>assets/css/report.css" rel="stylesheet">
</head>

<body>
    <div id="container">
        <!-- Print Body -->
        <div id="body">
            <table>
                <tbody>
                    <tr>
                        <td align="center">
                            <img src="1_files/logo-pemprov-diy-print.jpg" alt="" style="float: left;">
                            <h1>PEMERINTAH KABUPATEN <?php echo strtoupper($config['nama_kabupaten'])?> </h1>
                            <h1 style="text-transform: uppercase;"></h1>
                            <h1>KECAMATAN <?php echo strtoupper($config['nama_kecamatan'])?> </h1>
                            <h1>DESA <?php echo strtoupper($config['nama_desa'])?></h1>
                            <h1>LAPORAN DATA STATISTIK KEPENDUDUKAN MENURUT <?php echo strtoupper($stat)?></h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 20px;">
                            <br>
                            <table>
                                <tbody>
                                </tbody>
                            </table>
                            <table class="noborder">
                                <tbody>
                                    <tr>
                                        <td class="top">
                                            <div class="nowrap">
                                                <span style="width: 150px;"> <?php echo $stat?></span>
                                                <span></span>
                                                <strong style="font-size: 13px;"></strong>
                                            </div>
                                            <div class="nowrap">
                                                <span style="width: 150px;"></span>
                                                <span></span>
                                                <strong style="font-size: 14px;font-style:italic"></strong>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="noborder">
                                <tbody>
                                    <tr>
                                        <td class="top">
                                            <div class="nowrap">
                                                <span></span>
                                                <span>:</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <table class="border thick data">
                                <thead>
                                    <tr class="thick">
                                        <th class="thick">No</th>
                                        <th class="thick">Statistik</th>
                                        <th class="thick">Jumlah</th>
                                        <?php if($lap<20){?>
                                        <th class="thick" width="60">Laki-laki</th>
                                        <th class="thick" width="60">Perempuan</th>
                                        <?php }?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($main as $data): ?>
                                    <tr>
                                        <td class="thick" align="center" width="2"><?php echo $data['no']?></td>
                                        <td class="thick"><?php echo $data['nama']?></td>
                                        <td class="thick"><?php echo $data['jumlah']?></td>
                                        <?php if($lap<20){?>
                                        <td class="thick"><?php echo $data['laki']?></td>
                                        <td class="thick"><?php echo $data['perempuan']?></td>
                                        <?php }?>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <br>
                            <table class="noborder">
                                <tbody>
                                    <tr>
                                        <td class="top">
                                            <div class="nowrap">
                                                <label>Laporan data statistik kependudukan menurut <?php echo strtolower($stat)?> pada tanggal</label>
                                                <label>:</label>
                                                <strong><?php echo tgl_indo(date("Y m d"))?></strong>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <table class="noborder">
                                <tbody>
                                    <tr>
                                        <td class="top" align="center" width="30%">
                                            <div class="nowrap"><label></label></div>
                                            <div class="nowrap"><label><br></label></div>
                                            <div style="height: 70px;"></div>
                                            <div class="nowrap"><strong style="text-transform: uppercase;"></strong></div>
                                            <div class="nowrap"><label></label></div>
                                        </td>
                                        <td class="top" align="center" width="40%">
                                            <div class="nowrap"><label>&nbsp;</label></div>
                                            <div class="nowrap"><label><br></label></div>
                                        </td>
                                        <td class="top" align="center" width="30%">
                                            <div class="nowrap"><label>&nbsp;</label></div>
                                            <div class="nowrap"><label><br>KEPALA DESA <?php echo strtoupper($config['nama_desa'])?></label></div>
                                            <div style="height: 50px;"></div>
                                            <div class="nowrap"><strong style="text-transform: uppercase;"><?php echo strtoupper($config['nama_kepala_desa'])?></strong></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <table class="noborder">
                                <tbody>
                                    <tr>
                                        <td class="top">
                                            <div class="nowrap" style="font-style:italic;">
                                                <label></label>
                                                <label>:</label>
                                                <strong>-</strong>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </td>
                    </tr>
                </tbody>
            </table>
</body>

</html>
