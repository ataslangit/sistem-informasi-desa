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
	<td class="side-menu">
				<fieldset>
<legend>Surat Administrasi</legend>
<div  id="sidecontent2" class="lmenu">
<ul>
<?php foreach ($menu_surat as $data) {?>
        <li <?php if ($data['url_surat'] === $lap) {?>class="selected"<?php }?>><a href="<?= site_url()?>/surat/<?= $data['url_surat']?>"><?= $data['nama']?></a></li>
<?php }?>
</ul>
</div>
</fieldset>

	</td>
		<td style="background:#fff;padding:5px;">

<div class="content-header">

</div>
<div id="contentpane">
<div class="ui-layout-north panel">
<h3>Surat Permohonan Penduduk</h3>
</div>

    <form id="validasi" action="<?= $form_action?>" method="POST" target="_blank">
    <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
        <table class="form">
		<tr>
				<th>NIK</th>
				<td>
					<input name="nik" type="text" class="inputbox required" size="12"/>
				</td>
			</tr>
			<tr>
				<th>Nomor Surat</th>
				<td>
					<input name="nomor" type="text" class="inputbox required" size="12"/>
				</td>
			</tr>
			<tr>
				<th>Keperluan</th>
				<td>
					<input name="keperluan" type="text" class="inputbox required" size="40"/>
				</td>
			</tr>
			<tr>
				<th>Kantor Tujuan</th>
				<td>
					<input name="kantor_tujuan" type="text" class="inputbox required" size="40"/>
				</td>
			</tr>
			<tr>
				<th>Masa Berlaku</th>
				<td>
					<input name="awal" type="text" class="inputbox required datepicker" size="20"/> S/d
					<input name="akhir" type="text" class="inputbox required datepicker" size="20"/>
				</td>
			</tr>
			<tr>
				<th>Keterangan Lain</th>
				<td>
					<input name="lain" type="text" class="inputbox" value="" size="40"/>
				</td>
			</tr>
		<tr>
<th>Staf Pemerintah Desa</th>
<td>
<select name="pamong"  class="inputbox required">
<option value="">Pilih Staf Pemerintah Desa</option>
<?php foreach ($pamong as $data) {?>
<option value="<?= $data['pamong_nama']?>"><font style="bold"><?= $data['pamong_nama']?></font> (<?= $data['jabatan']?>)</option>
<?php }?>
</select>
</td>
</tr>
<tr>
<th>Sebagai</th>
<td>
<select name="jabatan"  class="inputbox required">
<option value="">Pilih Jabatan</option>
<?php foreach ($pamong as $data) {?>
<option ><?= $data['jabatan']?></option>
<?php }?>
</select>
</td>
</tr>

        </table>
    </div>

    <div class="ui-layout-south panel bottom">
        <div class="left">
            <a href="<?= site_url()?>/surat" class="uibutton icon prev">Kembali</a>
        </div>
        <div class="right">
            <div class="uibutton-group">
                <button class="uibutton" type="reset">Clear</button>

							<button type="button" onclick="$('#'+'validasi').attr('action','<?= $form_action?>');$('#'+'validasi').submit();" class="uibutton special"><span class="ui-icon ui-icon-print">&nbsp;</span>Cetak</button>
							<?php if (file_exists("surat/{$url}/{$url}.rtf")) { ?><button type="button" onclick="$('#'+'validasi').attr('action','<?= $form_action2?>');$('#'+'validasi').submit();" class="uibutton confirm"><span class="ui-icon ui-icon-document">&nbsp;</span>Export Doc</button><?php } ?>
            </div>
        </div>
    </div> </form>
</div>
</td></tr></table>
</div>
