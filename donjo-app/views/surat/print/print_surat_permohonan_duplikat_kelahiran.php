<?php $this->load->view('print/headjs.php'); ?>

<body>
<div id="content" class="container_12 clearfix">
<div id="content-main" class="grid_7">

<link href="<?= base_url()?>assets/css/surat.css" rel="stylesheet" type="text/css" />
<div>
<table width="100%">

<tr> <img src="<?= base_url()?>assets/files/logo/<?= $desa['logo']?>" alt=""  class="logo"></tr>

<div class="header">
<h4 class="kop">PEMERINTAH KABUPATEN <?= strtoupper(unpenetration($desa['nama_kabupaten']))?> </h4>
<h4 class="kop">KECAMATAN <?= strtoupper(unpenetration($desa['nama_kecamatan']))?> </h4>
<h4 class="kop">DESA <?= strtoupper(unpenetration($desa['nama_desa']))?></h4>
<h5 class="kop2"><?= unpenetration($desa['alamat_kantor'])?> </h5>
<div style="text-align: center;">
<hr /></div></div>


<div align="center"><u><h4 class="kop">SURAT PERMOHONAN DUPLIKAT KELAHIRAN</h4></u></div>
<div align="center"><h4 class="kop3">Nomor : <?= $input['nomor']?></h4></div>
</table>
<div class="clear"></div>

<table width="100%">
<td class="indentasi">Dengan ini kami mengajukan orang untuk mengadakan Permohonan Duplikat Kelahiran seperti tersebut di bawah ini :  </td></tr>
</table>
<div id="isi">
<table width="100%">
	<tr><td width="23%">Nama Lengkap</td><td width="3%">:</td><td width="64%"><?= unpenetration($data['nama'])?></td></tr>
	<tr><td >NIK</td><td >:</td><td ><?= $data['nik']?></td></tr>
	<tr><td >Jenis Kelamin</td><td >:</td><td ><?= $data['sex']?></td></tr>
	<tr><td >Tanggal Lahir</td><td >:</td><td ><?= tgl_indo($data['tanggallahir'])?></td></tr>
	<tr><td >Agama</td><td >:</td><td ><?= $data['agama']?></td></tr>
	<tr><td >Alamat</td><td >:</td><td >RT. <?= unpenetration($data['rt'])?>, RW. <?= unpenetration($data['rw'])?>, Dusun <?= unpenetration(ununderscore($data['dusun']))?>, Desa <?= unpenetration($desa['nama_desa'])?>, Kec. <?= unpenetration($desa['nama_kecamatan'])?>, Kab. <?= unpenetration($desa['nama_kabupaten'])?></td></tr>
	<tr><td >Telah lahir pada :</td><td ></td><td ></td></tr>
	<tr><td >Hari, Tanggal, Pukul</td><td >:</td><td ><?= $input['hari_bayi']?>,  <?= $input['jam_bayi']?></td></tr>
	<tr><td >Bertempat di</td><td >:</td><td ><?= $input['tempatlahir_bayi']?></td></tr>
	<tr></tr>
	<tr><td >Nama Ibu</td><td >:</td><td ><?= unpenetration($ibu['nama'])?></td></tr>
	<tr><td >NIK</td><td >:</td><td ><?= $ibu['nik']?></td></tr>
	<tr><td >Tanggal lahir</td><td >:</td><td ><?= tgl_indo($ibu['tanggallahir'])?></td></tr>
	<tr><td >Pekerjaan</td><td >:</td><td ><?= $ibu['pek']?></td></tr>
	<tr><td >Alamat</td><td >:</td><td >RT. <?= unpenetration($ibu['rt'])?>, RW. <?= unpenetration($ibu['rw'])?>, Dusun <?= unpenetration(ununderscore($ibu['dusun']))?>, Desa <?= unpenetration($desa['nama_desa'])?>, Kec. <?= unpenetration($desa['nama_kecamatan'])?>, Kab. <?= unpenetration($desa['nama_kabupaten'])?></td></tr>
	<tr><td >Nama Ayah</td><td >:</td><td ><?= unpenetration($ayah['nama'])?></td></tr>
	<tr><td >NIK</td><td >:</td><td ><?= $ayah['nik']?></td></tr>
	<tr><td >Tanggal lahir</td><td >:</td><td ><?= tgl_indo($ayah['tanggallahir'])?></td></tr>
	<tr><td >Pekerjaan</td><td >:</td><td ><?= $ayah['pek']?></td></tr>
	<tr><td >Alamat</td><td >:</td><td >RT. <?= unpenetration($ayah['rt'])?>, RW. <?= unpenetration($ayah['rw'])?>, Dusun <?= unpenetration(ununderscore($ayah['dusun']))?>, Desa <?= unpenetration($desa['nama_desa'])?>, Kec. <?= unpenetration($desa['nama_kecamatan'])?>, Kab. <?= unpenetration($desa['nama_kabupaten'])?></td></tr>
</table>
<div id="isi2">
<table width="100%">
<tr>Surat Keterangan ini dibuat berdasarkan keterangan pelapor :</tr>
<tr><td width="23%">Nama Lengkap</td><td width="3%">:</td><td width="64%"><?= unpenetration($input['nama_pelapor'])?></td></tr>
<tr><td width="23%">NIK/ No. KTP</td><td width="3%">:</td><td width="64%"><?= $input['nik_pelapor']?></td></tr>
<tr><td>Tempat dan Tgl. Lahir </td><td>:</td><td><?= $input['tempatlahir_pelapor']?> <?= tgl_indo(tgl_indo_in($input['tanggallahir_pelapor']))?> </td></tr>
<tr><td>Jenis Kelamin</td><td>:</td><td><?= $input['sex_pelapor']?></td></tr>
<tr><td>Pekerjaan</td><td>:</td><td><?= $input['pek_pelapor']?></td></tr>
<tr><td>Alamat</td><td>:</td><td><?= $input['alamat_pelapor']?></td></tr>
</table>
<table width="100%">
<tr></tr>
<td class="indentasi">Demikian surat keterangan ini dibuat, atas perhatian dan terkabulnya diucapkan terimakasih. </td>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
</table></div>
<table width="100%">
<tr></tr>
<tr></tr>
<tr></tr>
<tr><td width="23%"></td><td width="30%"></td><td  align="center"><?= unpenetration($desa['nama_desa'])?>, <?= $tanggal_sekarang?></td></tr>
<tr><td width="23%"></td><td width="30%"></td><td align="center"><?= unpenetration($input['jabatan'])?> <?= unpenetration($desa['nama_desa'])?></td></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr><td> <td></td><td align="center">( <?= unpenetration($input['pamong'])?> )</td></tr>
</table>  </div></div>
<div id="aside">
</div>
</div>
</body>
</html>
