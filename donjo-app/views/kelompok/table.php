<script>
	$(function() {
		var keyword = <?= $keyword?> ;
		$( "#cari" ).autocomplete({
			source: keyword
		});
	});
</script>

<div id="pageC">
	<table class="inner">
<tr style="vertical-align:top">
		<td style="background:#fff;padding:0px;">
<div class="content-header">
</div>
<div id="contentpane">
	<form id="mainform" name="mainform" action="" method="post">
    <div class="ui-layout-north panel">
    <h3>Modul kelompok</h3>
        <div class="left">
            <div class="uibutton-group">
                <a href="<?= site_url('kelompok_master/clear')?>" class="uibutton tipsy south" title="Master Kelompok" ><span class="icon-list icon-large">&nbsp;</span>Kelola Master Kelompok</a>
                <a href="<?= site_url('kelompok/form')?>" class="uibutton tipsy south" title="Tambah Data" ><span class="icon-plus-sign icon-large">&nbsp;</span>Tambah kelompok Baru</a>
                <button type="button" title="Hapus Data" onclick="deleteAllBox('mainform','<?= site_url("kelompok/delete_all/{$p}/{$o}")?>')" class="uibutton tipsy south"><span class="icon-trash icon-large">&nbsp;</span>Hapus Data
            </div>
        </div>
    </div>
    <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
        <div class="table-panel top">
            <div class="left">
                <select name="filter" onchange="formAction('mainform','<?= site_url('kelompok/filter')?>')">
                    <option value="">-- Filter by master --</option>
					<?php  foreach ($list_master as $data) {?>
					<option value="<?= $data['id']?>" <?php if ($filter === $data['id']) :?>selected<?php endif?>><?= $data['kelompok']?></option>
					<?php  }?>
                </select>
            </div>
            <div class="right">
                <input name="cari" id="cari" type="text" class="inputbox help tipped" size="20" value="<?= $cari?>" title="Cari.." onkeypress="if (event.keyCode == 13) {$('#'+'mainform').attr('action','<?= site_url('kelompok/search')?>');$('#'+'mainform').submit();}" />
                <button type="button" onclick="$('#'+'mainform').attr('action','<?= site_url('kelompok/search')?>');$('#'+'mainform').submit();" class="uibutton tipsy south"  title="Cari Data"><span class="icon-search icon-large">&nbsp;</span>Cari</button>
            </div>
        </div>
        <table class="list">
		<thead>
            <tr>
                <th width="10">No</th>
                <th><input type="checkbox" class="checkall"/></th>
                <th width="100">Aksi</th>

	 		<?php  if ($o === 4): ?>
				<th align="left"><a href="<?= site_url("kelompok/index/{$p}/3")?>">Nama<span class="ui-icon ui-icon-triangle-1-n">&nbsp;</span></a></th>
			<?php  elseif ($o === 3): ?>
				<th align="left"><a href="<?= site_url("kelompok/index/{$p}/4")?>">Nama<span class="ui-icon ui-icon-triangle-1-s">&nbsp;</span></a></th>
			<?php  else: ?>
				<th align="left"><a href="<?= site_url("kelompok/index/{$p}/3")?>">Nama<span class="ui-icon ui-icon-triangle-2-n-s">&nbsp;</span></a></th>
			<?php  endif; ?>

                <th width="100">Ketua Kelompok</th>
			<?php  if ($o === 6): ?>
				<th align="left" width='170'><a href="<?= site_url("kelompok/index/{$p}/5")?>">Master Kelompok<span class="ui-icon ui-icon-triangle-1-n">&nbsp;</span></a></th>
			<?php  elseif ($o === 5): ?>
				<th align="left" width='170'><a href="<?= site_url("kelompok/index/{$p}/6")?>">Master Kelompok<span class="ui-icon ui-icon-triangle-1-s">&nbsp;</span></a></th>
			<?php  else: ?>
				<th align="left" width='170'><a href="<?= site_url("kelompok/index/{$p}/5")?>">Master Kelompok<span class="ui-icon ui-icon-triangle-2-n-s">&nbsp;</span></a></th>
			<?php  endif; ?>

                <th width="100">Anggota Kelompok</th>
			</tr>
		</thead>
		<tbody>
        <?php  foreach ($main as $data): ?>
		<tr>
          <td align="center" width="2"><?= $data['no']?></td>
			<td align="center" width="5">
				<input type="checkbox" name="id_cb[]" value="<?= $data['id']?>" />
			</td>
          <td><div class="uibutton-group">
            <a href="<?= site_url("kelompok/form/{$p}/{$o}/{$data['id']}")?>" class="uibutton tipsy south" title="Ubah Data"><span class="icon-edit icon-large"> Ubah </span></a><a href="<?= site_url("kelompok/delete/{$p}/{$o}/{$data['id']}")?>" class="uibutton tipsy south" title="Hapus Data" target="confirm" message="Apakah Anda Yakin?" header="Hapus Data"><span class="icon-trash icon-large"></span></a>
			</div>
          </td>
          <td><?= $data['nama']?></td>
		  <td><?= $data['ketua']?></td>
		  <td><?= $data['master']?></td>
          <td align="center"><a href="<?= site_url("kelompok/anggota/{$data['id']}")?>" class="uibutton"><span class="icon-list icon-large"> Rincian </span></a></td>
		  </tr>
        <?php  endforeach; ?>
		</tbody>
        </table>
    </div>
	</form>
    <div class="ui-layout-south panel bottom">
        <div class="left">
		<div class="table-info">
          <form id="paging" action="<?= site_url('kelompok')?>" method="post">
		  <label>Tampilkan</label>
            <select name="per_page" onchange="$('#paging').submit()" >
              <option value="20" <?php  selected($per_page, 20); ?> >20</option>
              <option value="50" <?php  selected($per_page, 50); ?> >50</option>
              <option value="100" <?php  selected($per_page, 100); ?> >100</option>
            </select>
            <label>Dari</label>
            <label><strong><?= $paging->num_rows?></strong></label>
            <label>Total Data</label>
          </form>
          </div>
        </div>
        <div class="right">
            <div class="uibutton-group">
            <?php  if ($paging->start_link): ?>
				<a href="<?= site_url("kelompok/index/{$paging->start_link}/{$o}")?>" class="uibutton"  >Awal</a>
			<?php  endif; ?>
			<?php  if ($paging->prev): ?>
				<a href="<?= site_url("kelompok/index/{$paging->prev}/{$o}")?>" class="uibutton"  >Prev</a>
			<?php  endif; ?>
            </div>
            <div class="uibutton-group">

				<?php  for ($i = $paging->start_link; $i <= $paging->end_link; $i++): ?>
				<a href="<?= site_url("kelompok/index/{$i}/{$o}")?>" <?php  jecho($p, $i, "class='uibutton special'")?> class="uibutton"><?= $i?></a>
				<?php  endfor; ?>
            </div>
            <div class="uibutton-group">
			<?php  if ($paging->next): ?>
				<a href="<?= site_url("kelompok/index/{$paging->next}/{$o}")?>" class="uibutton">Next</a>
			<?php  endif; ?>
			<?php  if ($paging->end_link): ?>
                <a href="<?= site_url("kelompok/index/{$paging->end_link}/{$o}")?>" class="uibutton">Akhir</a>
			<?php  endif; ?>
            </div>
        </div>
    </div>
</div>
</td></tr></table>
</div>
