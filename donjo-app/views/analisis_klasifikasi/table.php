<script>
	$(function() {
		var keyword = <?= $keyword?> ;
		$( "#cari" ).autocomplete({
			source: keyword
		});
	});
</script>
<div id="pageC">
<?php $this->load->view('analisis_master/left', $data); ?>
<div class="content-header">
</div>
<div id="contentpane">
	<form id="mainform" name="mainform" action="" method="post">
	<div class="ui-layout-north panel">
		<h3>Manajemen Klasifikasi Analisis - <a href="<?= site_url()?>/analisis_master/menu/<?= $_SESSION['analisis_master']?>"><?= $analisis_master['nama']?></a></h3>
		<div class="left">
			<div class="uibutton-group">
				<a href="<?= site_url('analisis_klasifikasi/form')?>" class="uibutton tipsy south" title="Tambah Data" target="ajax-modal" rel="window" header="Form Data Parameter"><span class="icon-plus-sign icon-large">&nbsp;</span>Tambah Klasifikasi Baru</a>
				<button type="button" title="Hapus Data" onclick="deleteAllBox('mainform','<?= site_url("analisis_klasifikasi/delete_all/{$p}/{$o}")?>')" class="uibutton tipsy south"><span class="icon-trash icon-large">&nbsp;</span>Hapus Data
			</div>
		</div>
	</div>
	<div class="ui-layout-center" id="maincontent" style="padding: 5px;">
	<div class="table-panel top">
		<div class="left">
		</div>
		<div class="right">
			<input name="cari" id="cari" type="text" class="inputbox help tipped" size="20" value="<?= $cari?>" title="Cari.." onkeypress="if (event.keyCode == 13) {$('#'+'mainform').attr('action','<?= site_url('analisis_klasifikasi/search')?>');$('#'+'mainform').submit();}" />
			<button type="button" onclick="$('#'+'mainform').attr('action','<?= site_url('analisis_klasifikasi/search')?>');$('#'+'mainform').submit();" class="uibutton tipsy south" title="Cari Data"><span class="icon-search icon-large">&nbsp;</span>Cari</button>
		</div>
	</div>
<table class="list">
	<thead>
	<tr>
		<th width="10">No</th>
		<th><input type="checkbox" class="checkall"/></th>
		<th width="100">Aksi</th>

		<?php if ($o === 4): ?>
			<th align="left" width='250'><a href="<?= site_url("analisis_klasifikasi/index/{$p}/3")?>">Klasifikasi<span class="ui-icon ui-icon-triangle-1-n">&nbsp;</span></a></th>
		<?php elseif ($o === 3): ?>
			<th align="left" width='250'><a href="<?= site_url("analisis_klasifikasi/index/{$p}/4")?>">Klasifikasi<span class="ui-icon ui-icon-triangle-1-s">&nbsp;</span></a></th>
		<?php else: ?>
			<th align="left" width='250'><a href="<?= site_url("analisis_klasifikasi/index/{$p}/3")?>">Klasifikasi<span class="ui-icon ui-icon-triangle-2-n-s">&nbsp;</span></a></th>
		<?php endif; ?>

		<?php if ($o === 2): ?>
			<th align="left" width='50'><a href="<?= site_url("analisis_klasifikasi/index/{$p}/1")?>">Min<span class="ui-icon ui-icon-triangle-1-n">&nbsp;</span></a></th>
		<?php elseif ($o === 1): ?>
			<th align="left" width='50'><a href="<?= site_url("analisis_klasifikasi/index/{$p}/2")?>">Min<span class="ui-icon ui-icon-triangle-1-s">&nbsp;</span></a></th>
		<?php else: ?>
			<th align="left" width='50'><a href="<?= site_url("analisis_klasifikasi/index/{$p}/1")?>">Min<span class="ui-icon ui-icon-triangle-2-n-s">&nbsp;</span></a></th>
		<?php endif; ?>

		<?php if ($o === 2): ?>
			<th align="left" width='50'><a href="<?= site_url("analisis_klasifikasi/index/{$p}/1")?>">Maks<span class="ui-icon ui-icon-triangle-1-n">&nbsp;</span></a></th>
		<?php elseif ($o === 1): ?>
			<th align="left" width='50'><a href="<?= site_url("analisis_klasifikasi/index/{$p}/2")?>">Maks<span class="ui-icon ui-icon-triangle-1-s">&nbsp;</span></a></th>
		<?php else: ?>
			<th align="left" width='50'><a href="<?= site_url("analisis_klasifikasi/index/{$p}/1")?>">Maks<span class="ui-icon ui-icon-triangle-2-n-s">&nbsp;</span></a></th>
		<?php endif; ?>

		<th></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($main as $data): ?>
		<tr>
			<td align="center" width="2"><?= $data['no']?></td>
			<td align="center" width="5">
				<input type="checkbox" name="id_cb[]" value="<?= $data['id']?>" />
			</td>
			<td><div class="uibutton-group">
				<a href="<?= site_url("analisis_klasifikasi/form/{$p}/{$o}/{$data['id']}")?>" class="uibutton tipsy south" title="Ubah Data" target="ajax-modal" rel="window" header="Form Data Parameter">
					<span class="icon-edit icon-large"> Ubah </span>
				</a>
				<a href="<?= site_url("analisis_klasifikasi/delete/{$p}/{$o}/{$data['id']}")?>" class="uibutton tipsy south" title="Hapus Data" target="confirm" message="Apakah Anda Yakin?" header="Hapus Data">
					<span class="icon-trash icon-large"></span>
				</a>
				</div>
			</td>
			<td><?= $data['nama']?></td>
			<td><?= $data['minval']?></td>
			<td><?= $data['maxval']?></td>
			<td></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
</div>
	</form>
<div class="ui-layout-south panel bottom">
	<div class="left">
		<div class="table-info">
		<form id="paging" action="<?= site_url('analisis_klasifikasi')?>" method="post">
			<a href="<?= site_url()?>/analisis_klasifikasi/leave" class="uibutton icon prev">Kembali</a>
			<select name="per_page" onchange="$('#paging').submit()" >
				<option value="20" <?php selected($per_page, 20); ?> >20</option>
				<option value="50" <?php selected($per_page, 50); ?> >50</option>
				<option value="100" <?php selected($per_page, 100); ?> >100</option>
			</select>
			<label>Dari</label>
			<label><?= $paging->num_rows?></label>
			<label>Total Data</label>
		</form>
		</div>
	</div>
	<div class="right">
		<div class="uibutton-group">
			<?php if ($paging->start_link): ?>
				<a href="<?= site_url("analisis_klasifikasi/index/{$paging->start_link}/{$o}")?>" class="uibutton" >Awal</a>
			<?php endif; ?>
			<?php if ($paging->prev): ?>
				<a href="<?= site_url("analisis_klasifikasi/index/{$paging->prev}/{$o}")?>" class="uibutton" >Prev</a>
			<?php endif; ?>
			</div>
			<div class="uibutton-group">
			<?php for ($i = $paging->start_link; $i <= $paging->end_link; $i++): ?>
				<a href="<?= site_url("analisis_klasifikasi/index/{$i}/{$o}")?>" <?php jecho($p, $i, "class='uibutton special'")?> class="uibutton"><?= $i?></a>
			<?php endfor; ?>
			</div>
			<div class="uibutton-group">
			<?php if ($paging->next): ?>
				<a href="<?= site_url("analisis_klasifikasi/index/{$paging->next}/{$o}")?>" class="uibutton">Next</a>
			<?php endif; ?>
			<?php if ($paging->end_link): ?>
				<a href="<?= site_url("analisis_klasifikasi/index/{$paging->end_link}/{$o}")?>" class="uibutton">Akhir</a>
			<?php endif; ?>
		</div>
	</div>
</div>
</div>
</div>