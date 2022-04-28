<?php
header('Content-type: application/octet-stream');
header('Content-Disposition: attachment; filename=Penduduk.xls');
header('Pragma: no-cache');
header('Expires: 0');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<title>Data Penduduk</title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="<?= base_url()?>assets/css/report.css" rel="stylesheet" type="text/css">
<style>
.textx{
  mso-number-format:"\@";
}
td,th{
	font-size:8pt;
}
</style>
</head>
<body>
<div id="container">
<!-- Print Body --><div id="body">
<div class="header" align="center">
<label align="left"><?= get_identitas()?></label>
<h3> DATA PENDUDUK </h3>
</div>
    <table border=1 class="border thick">
	<thead>
		<tr class="border thick">
			<th>No</th>
			<th>NIK</th>
			<th>Nama</th>
			<th>No. KK</th>
			<th >Dusun</th>
			<th >RW</th>
			<th >RT</th>
			<th >Pendidikan (dLm KK)</th>
			<th >Pendidikan (sdg ditemph)</th>
			<th >Pekerjaan</th>
			<th >Tanggal Lahir</th>
			<th >Tempat Lahir</th>
			<th>Umur</th>
			<th >Kawin</th>
			<th >Hub. Keluarga</th>
			<th >Gol. Darah</th>
			<th >Nama Ayah</th>
			<th >Nama Ibu</th>
			<th >Status</th>

		</tr>
	</thead>
	<tbody>
		 <?php  foreach ($main as $data): ?>
		 <tr>
			<td  width="2"><?= $data['no']?></td>
			<td class="textx"><?= $data['nik']?></td>
			<td><?= strtoupper($data['nama'])?></td>
			<td  class="textx"><?= $data['no_kk']?> </td>
			<td><?= strtoupper(ununderscore($data['dusun']))?></td>
			<td><?= $data['rw']?></td>
			<td><?= $data['rt']?></td>
			<td><?= $data['pendidikan']?></td>
			<td><?= $data['pendidikan_sedang']?></td>
			<td><?= $data['pekerjaan']?></td>
			<td><?= $data['tanggallahir']?></td>
			<td><?= $data['tempatlahir']?></td>
			<td align="right"><?= $data['umur']?></td>
			<td><?= $data['kawin']?></td>
			<td><?= $data['hubungan']?></td>
			<td><?= $data['gol_darah']?></td>
			<td><?= $data['nama_ayah']?></td>
			<td><?= $data['nama_ibu']?></td>
			<td><?php if ($data['status'] === 1) {
    echo 'Tetap';
} else {
    echo 'Pendatang';
}?></td>
		</tr>
		<?php  endforeach; ?>
	</tbody>
</table>
</div>
   <label>Tanggal cetak : &nbsp; </label><?= tgl_indo(date('Y m d'))?>
</div>
</body>
</html>