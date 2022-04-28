<div id="pageC">
	<table class="inner">
	<tr style="vertical-align:top">
	<td style="background:#fff;padding:0px;">
<div id="contentpane">
<div class="content-header">
</div>
	<form id="mainform" name="mainform" action="" method="post">
    <div class="ui-layout-north panel">
    <h3>Daftar Anggota Rumah Tangga : <?= $kepala_kk['nama']?> - <?= $kepala_kk['no_kk']?></h3>
        <div class="left">
            <div class="uibutton-group">
                <a href="<?= site_url("rtm/ajax_add_anggota/{$p}/{$o}/{$kk}")?>" class="uibutton tipsy south" title="Tambah Data" target="ajax-modalx" rel="window"><span class="icon-plus icon-large">&nbsp;</span>Tambah Anggota</a>
                <button type="button" title="Hapus Data" onclick="deleteAllBox('mainform','<?= site_url("rtm/delete_all_anggota/{$p}/{$o}/{$kk}")?>')" class="uibutton tipsy south"><span class="icon-trash icon-large">&nbsp;</span>Hapus Data</button>
                <?php /*<a href="<?php echo site_url("rtm/lepas_anggota/$p/$o/$kk")?>" type="button" title="Lepas KK" class="uibutton tipsy south"  target="ajax-modal" rel="window" header="Lepas KK"><span class="ui-icon ui-icon-next">&nbsp;</span>Lepas KK</a>*/?>
            </div>
        </div>
    </div>
    <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
        <div class="table-panel top">
            <div class="left">
            </div>
            <div class="right">
            </div>
        </div>
        <table class="list">
		<thead>
            <tr>
                <th>No</th>
                <th><input type="checkbox" class="checkall"/></th>
                <th width="80">Aksi</th>
				<th width='100'>NIK</th>
				<th>Nama</th>
				<th width="150">Hubungan</th>
				<th>Alamat</th>

			</tr>
		</thead>
		<tbody>
        <?php  foreach ($main as $data): ?>
		<tr>
          <td align="center" width="2"><?= $data['no']?></td>
			<td align="center" width="5">
				<input type="checkbox" name="id_cb[]" value="<?= $data['id']?>" />
			</td>
			<td>
				<div class="uibutton-group">
				<a href="<?= site_url("rtm/delete_anggota/{$p}/{$o}/{$kk}/{$data['id']}")?>" class="uibutton tipsy south" title="Hapus dari Ruta" target="confirm" message="Apakah Anda Yakin?" header="Hapus"><span class="icon-minus-sign icon-large"></span> Hapus</a>
				<a href="<?= site_url("rtm/edit_anggota/{$p}/{$o}/{$kk}/{$data['id']}")?>" class="uibutton tipsy south" title="Ubah Hubungan rtm" target="ajax-modal" rel="window" header="Ubah Data"><span class="icon-link icon-large"></span></a>
				</div>
			</td>
          <td><label><?= $data['nik']?></label></td>
		  <td><label><?= strtoupper(unpenetration($data['nama']))?></label></td>

		  <td><?= $data['hubungan']?></td>
          <td><?= unpenetration($data['alamat'])?></td>
		  </tr>
        <?php  endforeach; ?>
		</tbody>
        </table>
    </div>
	</form>
    <div class="ui-layout-south panel bottom">
        <div class="left">
            <a href="<?= site_url("rtm/index/{$p}/{$o}")?>" class="uibutton icon prev">Kembali</a>
        </div>
        <div class="right">
            <a href="<?= site_url("rtm/kartu_rtm/{$p}/{$o}/{$kk}")?>" class="uibutton confirm icon next">Kartu rtm</a>
        </div>
    </div>
</div>
</td></tr></table>
</div>
