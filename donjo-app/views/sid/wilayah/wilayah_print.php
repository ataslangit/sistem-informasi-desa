<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<title>Data Wilayah</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="<?= base_url()?>assets/css/surat.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url()?>assets/css/report.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="container" style="min-width:800px;max-width:1024px;">
<table width="100%">
<tr> <img src="<?= base_url()?>assets/files/logo/<?= $desa['desa']['logo']?>" alt="" class="logo"></tr>
<div class="header">
<h4 class="kop">PEMERINTAH KABUPATEN <?= strtoupper(unpenetration($desa['desa']['nama_kabupaten']))?> </h4>
<h4 class="kop">KECAMATAN <?= strtoupper(unpenetration($desa['desa']['nama_kecamatan']))?> </h4>
<h4 class="kop">DESA <?= strtoupper(unpenetration($desa['desa']['nama_desa']))?></h4>
<h5 class="kop2"><?= unpenetration($desa['desa']['alamat_kantor'])?> </h5>
<hr />
</div>
<div align="center">
<br>
<h2>Data Kependudukan berdasarkan Wilayah</h2>
<br>
</div>
</table>
<div class="clear"></div>
<div id="body">
 <table class="border thick">
	<thead>
		<tr class="border thick">
 <th>No</th>
				<th width="100">Nama Dusun</th>
				<th width="100">Nama Kadus</th>
				<th width="50">RW</th>
				<th width="50">RT</th>
				<th width="50">KK</th>
				<th width="50">Jiwa</th>
				<th width="50">LK</th>
				<th width="50">PR</th>
			</tr>
		</thead>
		<tbody>
 <?php foreach ($main as $data): ?>
		<tr>
 <td align="center" width="2"><?= $data['no']?></td>

			<td><?= strtoupper(unpenetration(ununderscore($data['dusun'])))?></td>
			<td><?= $data['nama_kadus']?></td>
			<td align="right"><?= $data['jumlah_rw']?></td>
			<td align="right"><?= $data['jumlah_rt']?></td>
			<td align="right"><?= $data['jumlah_kk']?></td>
			<td align="right"><?= $data['jumlah_warga']?></td>
			<td align="right"><?= $data['jumlah_warga_l']?></td>
			<td align="right"><?= $data['jumlah_warga_p']?></td>
		</tr>
 <?php endforeach; ?>
		</tbody>

 <tr style="background-color:#BDD498;font-weight:bold;">
 <td colspan="3" align="left"><label>TOTAL</label></td>
				<td align="right"><?= $total['total_rw']?></td>
				<td align="right"><?= $total['total_rt']?></td>
				<td align="right"><?= $total['total_kk']?></td>
				<td align="right"><?= $total['total_warga']?></td>
				<td align="right"><?= $total['total_warga_l']?></td>
				<td align="right"><?= $total['total_warga_p']?></td>
			</tr>
	</tbody>
</table>
</div>
<label>Tanggal cetak : &nbsp; </label><?= tgl_indo(date('Y m d'))?>
</div>
</body>
</html>