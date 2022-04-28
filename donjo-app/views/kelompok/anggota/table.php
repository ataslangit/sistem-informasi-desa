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
                <a href="<?= site_url('kelompok/clear')?>" class="uibutton tipsy south" title="Kelompok" ><span class="icon-list icon-large">&nbsp;</span>Kelompok</a>
                <a href="<?= site_url("kelompok/form_anggota/{$kel}")?>" class="uibutton tipsy south" title="Tambah Data" ><span class="icon-plus-sign icon-large">&nbsp;</span>Tambah Anggota Baru</a>
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
                <th width="10">No</th>
                <th width="50">Aksi</th>
                <th width="100">Nik</th>
                <th>Nama</th>
			</tr>
		</thead>
		<tbody>
        <?php  foreach ($main as $data): ?>
		<tr>
          <td align="center" width="2"><?= $data['no']?></td>
          <td><div class="uibutton-group"><a href="<?= site_url("kelompok/delete_a/{$kel}/{$data['id']}")?>" class="uibutton tipsy south" title="Hapus Data" target="confirm" message="Apakah Anda Yakin?" header="Hapus Data"><span class="icon-trash icon-large"></span> Hapus</a>
			</div>
          </td>
          <td><?= $data['nik']?></td>
          <td><?= $data['nama']?></td>
		  </tr>
        <?php  endforeach; ?>
		</tbody>
        </table>
    </div>
	</form>
    <div class="ui-layout-south panel bottom">
        <div class="left">
        </div>
        <div class="right">
    </div>
</div>
</td></tr></table>
</div>
