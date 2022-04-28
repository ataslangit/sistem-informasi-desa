<?php
/*
 * create.php
 *
 * Backend View untuk Nulis Program Bantuan Baru
 *
 * Copyright 2015 Isnu Suntoro <isnusun@gmail.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 *
 *
 */

header('Content-type: application/octet-stream');
header('Content-Disposition: attachment; filename=print.xls');
header('Pragma: no-cache');
header('Expires: 0');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<title>Peserta Program <?= $peserta[0]['nama']; ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="<?= base_url()?>assets/css/report.css" rel="stylesheet" type="text/css">
</head>
<body>
<!-- Print Body -->
<div id="body">
	<div class="header">
		<label><?= get_identitas()?></label>
		<h3> Daftar Peserta Program <?= $peserta[0]['nama']; ?></h3>
		<h4><?= fTampilTgl($peserta[0]['sdate'], $peserta[0]['edate']); ?></h4>
		<div><?= $peserta[0]['ndesc']; ?></div>
	</div>

	<div id="table">
	<table class="border thick">
		<thead>
			<tr class="border thick">
				<th width="150" >No</th>
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
