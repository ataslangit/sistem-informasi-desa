<script type="text/javascript" src="<?= base_url()?>assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/validasi.js"></script>
<form action="<?= $form_action?>" method="post" id="validasi">
	<table class="form">
		<tr>
			<th>Klasifikasi</th>
			<td><input name="nama" type="text" class="inputbox" size="40" value="<?= $analisis_klasifikasi['nama']?>"/></td>
		</tr>
		<tr>
			<th>Nilai Minimal</th>
			<td><input name="minval" type="text" class="inputbox" size="10" value="<?= $analisis_klasifikasi['minval']?>"/></td>
		</tr>
		<tr>
			<th>Nilai Maksimal</th>
			<td><input name="maxval" type="text" class="inputbox" size="10" value="<?= $analisis_klasifikasi['maxval']?>"/></td>
		</tr>
	</table>
	<div class="buttonpane" style="text-align: right; width:420px;position:absolute;bottom:0px;">
		<div class="uibutton-group">
			<button class="uibutton confirm" type="submit">Simpan</button>
		</div>
	</div>
</form>