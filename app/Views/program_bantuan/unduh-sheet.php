<?php
$tgl = date('d_m_Y');
header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=bantuan_{$tgl}.xls");
header('Pragma: no-cache');
header('Expires: 0');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Peserta Program <?= $peserta[0]['nama']; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="<?= base_url() ?>/assets/css/report.css" rel="stylesheet" type="text/css">
</head>

<body>
    <!-- Print Body -->
    <div id="body">
        <div class="header">
            <label><?= get_identitas() ?></label>
            <h3> Daftar Peserta Program <?= $peserta[0]['nama']; ?></h3>
            <h4><?= fTampilTgl($peserta[0]['sdate'], $peserta[0]['edate']); ?></h4>
            <div><?= $peserta[0]['ndesc']; ?></div>
        </div>
        <div id="table">
            <table class="border thick">
                <thead>
                    <tr class="border thick">
                        <th width="150">No</th>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;

foreach ($peserta[1] as $key => $item) {
    echo '<tr><td>' . $i . "</td>
					<td>'" . $item['nik'] . '</td>
					<td>' . $item['nama'] . '</td>
					<td>' . $item['info'] . '</td>
				</tr>';
    $i++;
}
?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
