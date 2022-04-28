<?php $this->load->view('print/headjs.php'); ?>

<body>
<div id="content" class="container_12 clearfix">
<div id="content-main" class="grid_7">

<link href="<?= base_url()?>assets/css/surat.css" rel="stylesheet" type="text/css" />
<div>
<table width="100%">

<tr> <img src="<?= base_url()?>assets/images/logo/<?= $desa['logo']?>" alt=""  class="logo"></tr>

<div class="header">
<h4 class="kop">PEMERINTAH KABUPATEN <?= strtoupper(unpenetration($desa['nama_kabupaten']))?> </h4>
<h4 class="kop">KECAMATAN <?= strtoupper(unpenetration($desa['nama_kecamatan']))?> </h4>
<h4 class="kop">DESA <?= strtoupper(unpenetration($desa['nama_desa']))?></h4>
<h5 class="kop2"><?= unpenetration($desa['alamat_kantor'])?> </h5>
<div style="text-align: center;">
<hr /></div></div>
</table>
<div class="clear"></div>

<div id="isi3">

<table width="100%">
<tr>
<td width="10%"></td><td></td>
<td width="50%" align="left"></td>
<td align="left"><?= $desa['nama_desa']?>, <?= $tanggal_sekarang?></td>
</tr>

<tr>
<td ></td><td></td>
<td align="left"></td>
</tr><tr>
<td >Nomor</td><td>:</td><td  align="left"><?= $input['nomor'] ?>  </td></tr><tr>
<td>Perihal</td><td>:</td><td>Permohonan Akta Kelahiran </td>
</tr>
</table>

</tr><tr>
<tr></tr>
<tr></tr>
<tr></tr>
<table width="100%">
<tr></tr>
<tr></tr>
<tr></tr>
<tr><td colspan="3" align="left"><p>Kepada Yth. </td></tr>
<tr><td>Kepala Pengadilan Agama</td></tr>
<tr><td>Kabupaten  <?= unpenetration($desa['nama_kabupaten']) ?></td></tr>
</tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
</table>
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
<table width="100%">

<td class="indentasi">Yang bertanda tangan dibawah ini <?= unpenetration($input['jabatan'])?> <?= unpenetration($desa['nama_desa'])?>, Kecamatan <?= unpenetration($desa['nama_kecamatan'])?>,
     Kabupaten <?= unpenetration($desa['nama_kabupaten'])?>, Provinsi <?= unpenetration($desa['nama_propinsi'])?> menerangkan bahwa:  </td></tr>
</table>

<table width="100%">
<tr><td width="35%">Nama Lengkap</td><td width="3%">:</td><td ><?= unpenetration($data['nama'])?></td></tr>
<tr><td>Tempat dan Tgl. Lahir </td><td>:</td><td><?= $data['tempatlahir']?>, <?= tgl_indo($data['tanggallahir'])?> </td></tr>
<tr><td>Pekerjaan </td><td>:</td><td><?= $data['pekerjaan']?> </td></tr>
<tr><td>Alamat</td><td>:</td><td>RT. <?= $data['rt']?>, RW. <?= $data['rw']?>, Dusun <?= unpenetration(ununderscore($data['dusun']))?>, Desa <?= unpenetration($desa['nama_desa'])?>, Kec. <?= unpenetration($desa['nama_kecamatan'])?>, Kab. <?= unpenetration($desa['nama_kabupaten'])?></td></tr>
<td class="indentasi" colspan="4">Mengajukan permohonan untuk diterbitkan penetapan Pengadilan Negeri sebagai persyaratan pencatatan peristiwa kelahiran dan penerbitan kutipan Akta Kelahiran atas nama:</tr>
<tr><td>Nama</td><td>:</td><td><?= unpenetration($input['nama_anak'])?> </td></tr>
<tr><td>Tempat dan Tanggal Lahir</td><td>:</td><td><?= $input['tempatlahir_anak']?>, <?= tgl_indo(tgl_indo_in($input['tanggallahir_anak']))?> </td ></td></tr>
<tr><td>Hari Lahir</td><td>:</td><td><?= $input['harilahir_anak']?> </td></tr>
<tr><td>Alamat</td><td>:</td><td><?= $input['alamat_anak']?> </td></tr>

<tr></tr>
<tr></tr>

<tr><td colspan="3">Nama Orang Tua</td><td></td><td></td></tr>
<tr><td>Nama Ayah</td><td>:</td><td><?= unpenetration($input['nama_ayah'])?> </td></tr>
<tr><td>Nama Ibu</td><td>:</td><td><?= unpenetration($input['nama_ibu'])?> </td></tr>
<tr><td>Alamat Orang Tua</td><td>:</td><td><?= unpenetration($input['nama_ortu'])?> </td></tr>
</table>
<table>
<tr></tr>
<tr></tr>
</table>

<table width="100%">
<tr></tr>
<tr></tr>
<tr>
<td class="indentasi">Demikian Surat Keterangan ini dibuat dengan sesungguhnya agar dapat dipergunakan sebagaimana mestinya.</td>
</tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
</table>
<table width="100%">
<tr></tr>
<tr><td width="10%"></td><td width="30%"></td><td align="center"><?= unpenetration($input['jabatan'])?> <?= unpenetration($desa['nama_desa'])?></td></tr>
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
<tr><td> <td></td><td align="center">( <?= unpenetration($pamong['pamong_nama'])?> )</td></tr>
</table>  </div></div>
<div id="aside">
</div>
</div>
</body>
</html>
