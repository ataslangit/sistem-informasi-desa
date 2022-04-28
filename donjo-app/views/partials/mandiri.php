<div class="artikel">
<h3> BIODATA PENDUDUK</h3>

<a href="<?= site_url("first/cetak_biodata/{$penduduk['id']}"); ?>" target="_blank" class="uibutton special"  >Cetak Biodata</a>
<table class="form" >

<tr>
<td width="150">Nama</td><td width="1">:</td>
<td><?= strtoupper(unpenetration($penduduk['nama']))?></td>
</tr>

<tr>
<td width="150">NIK</td><td width="1">:</td>
<td><?= $penduduk['nik']?></td>
</tr>

<tr>
<td width="150">NO KK</td><td width="1">:</td>
<td><?= $penduduk['no_kk']?></td>
</tr>

<tr>
<td>Akta lahir</td><td >:</td>
<td><?= strtoupper($penduduk['akta_lahir'])?></td>
</tr>

<tr>
<td>Dusun</td><td >:</td>
<td><?= strtoupper(ununderscore(unpenetration($penduduk['dusun'])))?></td>
</tr>

<tr>
<td>RT/ RW</td><td >:</td>
<td><?= strtoupper($penduduk['rt'])?> / <?= $penduduk['rw']?></td>
</tr>

<tr>
<td>Jenis Kelamin</td><td >:</td>
<td><?= strtoupper($penduduk['sex'])?></td>
</tr>

<tr>
<td>Tempat / Tanggal Lahir</td><td >:</td>
<td><?= strtoupper($penduduk['tempatlahir'])?> / <?= strtoupper($penduduk['tanggallahir'])?></td>
</tr>

<tr>
<td>Agama</td><td >:</td>
<td><?= strtoupper($penduduk['agama'])?></td>
</tr>

<tr>
<td>Pendidikan dalam KK</td><td >:</td>
<td><?= strtoupper($penduduk['pendidikan_kk'])?></td>
</tr>

<tr>
<td>Pendidikan sedang ditempuh</td><td >:</td>
<td><?= strtoupper($penduduk['pendidikan_sedang'])?></td>
</tr>

<tr>
<td>Pekerjaan</td><td >:</td>
<td><?= strtoupper($penduduk['pekerjaan'])?></td>
</tr>

<tr>
<td>Status Kawin</td><td >:</td>
<td><?= strtoupper($penduduk['kawin'])?></td>
</tr>

<tr>
<td>Warga Negara</td><td >:</td>
<td><?= strtoupper($penduduk['warganegara'])?></td>
</tr>

<tr>
<td>Dokumen Paspor</td><td >:</td>
<td><?= strtoupper($penduduk['dokumen_pasport'])?></td>
</tr>

<tr>
<td>Dokumen KITAS</td><td >:</td>
<td><?= strtoupper($penduduk['dokumen_kitas'])?></td>
</tr>


<tr>
<td>Alamat Sebelumnya</td><td >:</td>
<td><?= strtoupper($penduduk['alamat_sebelumnya'])?></td>
</tr>

<tr>
<td>Alamat Sekarang</td><td >:</td>
<td><?= strtoupper($penduduk['alamat_sekarang'])?></td>
</tr>

<tr>
<td>Akta perkawinan</td><td >:</td>
<td><?= strtoupper($penduduk['akta_perkawinan'])?></td>
</tr>

<tr>
<td>Tanggal perkawinan</td><td >:</td>
<td><?= strtoupper($penduduk['tanggalperkawinan'])?></td>
</tr>

<tr>
<td>Akta perceraian</td><td >:</td>
<td><?= strtoupper($penduduk['akta_perceraian'])?></td>
</tr>

<tr>
<td>Tanggal perceraian</td><td >:</td>
<td><?= strtoupper($penduduk['tanggalperceraian'])?></td>
</tr>

<tr>
<td>Data Orang Tua</td>
</tr>

<tr>
<td>NIK Ayah</td><td >:</td>
<td><?= strtoupper($penduduk['ayah_nik'])?></td>
</tr>

<tr>
<td>Nama Ayah</td><td >:</td>
<td><?= strtoupper(unpenetration($penduduk['nama_ayah']))?></td>
</tr>

<tr>
<td>NIK Ibu</td><td >:</td>
<td><?= strtoupper($penduduk['ibu_nik'])?></td>
</tr>


<tr>
<td>Nama Ibu</td><td >:</td>
<td><?= strtoupper(unpenetration($penduduk['nama_ibu']))?></td>
</tr>


<tr>
<td>Cacat</td><td >:</td>
<td><?= strtoupper($penduduk['cacat_id'])?></td>
</tr>


<tr>
<td>Status</td><td >:</td>
<td><?= strtoupper($penduduk['status'])?></td>
</tr>
</table>

</div>
