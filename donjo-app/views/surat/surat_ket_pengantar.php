<script>
	$(function(){
		var nik = {};
		nik.results = [
			<? foreach($penduduk as $data){?>
				{id:'<?=$data['id']?>',name:"<?=$data['nik']." - ".($data['nama'])?>",info:"<?=($data['alamat'])?>"},
			<? }?>
		];
		
		$('#nik').flexbox(nik, {
			resultTemplate: '<div><label>No nik : </label>{name}</div><div>{info}</div>',
			watermark: <? if($individu){?>'<?=$individu['nik']?> - <?=($individu['nama'])?>'<? }else{?>'Ketik no nik di sini..'<? }?>,
			width: 260,
			noResultsText :'Tidak ada no nik yang sesuai..',
			onSelect: function() {
				$('#'+'main').submit();
		}  
		});
	
	});
</script>


<style>
table.form.detail th{
padding:5px;
background:#fafafa;
border-right:1px solid #eee;
}
table.form.detail td{
padding:5px;
}
</style>
<div id="pageC">
<table class="inner">
<tr style="vertical-align:top">
<?/*<td class="side-menu">
<fieldset>
<legend>Surat Administrasi</legend>
<div id="sidecontent2"  class="lmenu">
<ul>
<?foreach($menu_surat AS $data){?>
        <li <? if($data['url_surat']==$lap){?>class="selected"<? }?>><a href="<?=site_url()?>surat/<?=$data['url_surat']?>"><?=unpenetration($data['nama'])?></a></li>
<?}?>
</ul>
</div>
</fieldset>
</td>
*/?>
<td style="background:#fff;padding:0px;"> 
<div id="contentpane">
<div class="ui-layout-center" id="maincontent" style="padding: 5px;">
<h3>Surat Keterangan</h3>
<table class="form">
<tr>
<th width="150">NIK / Nama</th>
<td>
<form action="" id="main" name="main" method="POST">
<div id="nik" name="nik"></div>
</form>
</tr>
<form id="validasi" action="" method="POST" target="_blank">
<input type="hidden" name="nik" value="<?=$individu['id']?>" class="inputbox required" >
<?if($individu){ //bagian info setelah terpilih?>
<tr>
<th>Tempat Tanggal Lahir (Umur)</th>
<td>
<?=$individu['tempatlahir']?> <?=tgl_indo($individu['tanggallahir'])?> (<?=$individu['umur']?> Tahun)
</td>
</tr>
<tr>
<th>Alamat</th>
<td>
<?=unpenetration($individu['alamat']); ?>
</td>
</tr>
<tr>
<th>Pendidikan</th>
<td>
<?=$individu['pendidikan']?>
</td>
</tr>
<tr>
<th>Warganegara / Agama</th>
<td>
<?=$individu['warganegara']?> / <?=$individu['agama']?>
</td>
</tr>
<?}?>
<tr>
<th>Nomor Surat</th>
<td>
<input name="nomor" type="text" class="inputbox required" size="12"/>
</td>
</tr>
<tr>
<th>Keperluan</th>
<td>
<textarea name="keperluan" class=" required" style="resize: none; height:80px; width:300px;" size="500"></textarea>
</td>
</tr>
<tr>
<th>Keterangan</th>
<td>
<input name="keterangan" type="text" class="inputbox" size="40"/>
</td>
</tr>
<tr>
<th>Berlaku</th>
<td>
<input name="berlaku_dari" type="text" class="inputbox required datepicker" size="20"/> sampai <input name="berlaku_sampai" type="text" class="inputbox datepicker " size="20"/>
</td>
</tr>
<tr>
<th>Staf Pemerintah Desa</th>
<td>
<select name="pamong"  class="inputbox required">
<option value="">Pilih Staf Pemerintah Desa</option>
<?foreach($pamong AS $data){?>
<option value="<?=$data['pamong_nama']?>"><?=$data['pamong_nama']?>(<?=$data['jabatan']?>)</option>
<?}?>
</select>
</td>
</tr>
<tr>
<th>Sebagai</th>
<td>
<select name="jabatan"  class="inputbox required">
<option value="">Pilih Jabatan</option>
<?foreach($pamong AS $data){?>
<option ><?=$data['jabatan']?></option>
<?}?>
</select>
</td>
</tr>
</table>
</div>
<div class="ui-layout-south panel bottom">
<div class="left">     
<a href="<?=site_url()?>surat" class="uibutton icon prev">Kembali</a>
</div>
<div class="right">
<div class="uibutton-group">
<button class="uibutton" type="reset">Clear</button>
<button type="button" onclick="$('#'+'validasi').attr('action','<?=$form_action?>');$('#'+'validasi').submit();" class="uibutton special"><span class="ui-icon ui-icon-print">&nbsp;</span>Cetak</button>
<button type="button" onclick="$('#'+'validasi').attr('action','<?=$form_action2?>');$('#'+'validasi').submit();" class="uibutton confirm"><span class="ui-icon ui-icon-document">&nbsp;</span>Export Doc</button>
</div>
</div>
</div></form>
</div>
</td></tr></table>
</div>