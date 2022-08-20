<div id="pageC">
    <div id="contentpane">
        <?= form_open('', ['id' => 'mainform', 'name' => 'mainform']) ?>
            <div class="ui-layout-north panel">
                <h3>Dokumen / Kelengkpan Penduduk - <?= $penduduk['nama'] ?> [<?= $penduduk['nik'] ?>]</h3>
                <div class="left">
                    <div class="uibutton-group">
                        <a header="Form Dokumen" target="ajax-modal" rel="dokumen" href="<?= site_url("penduduk/dokumen_form/{$penduduk['id']}") ?>" class="uibutton"><span class="icon-plus-sign icon-large"></span> Tambah Dokumen</a>
                        <button type="button" title="Hapus Data" onclick="deleteAllBox('mainform','<?= site_url("penduduk/delete_all_dokumen/{$penduduk['id']}") ?>')" class="uibutton tipsy south"><span class="icon-trash icon-large">&nbsp;</span>Hapus
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
                            <th width="2">No</th>
                            <th width="20"><input type="checkbox" class="checkall" /></th>
                            <th width="20">Aksi</th>
                            <th width="220">Nama Dokumen</th>
                            <th width="360">File</th>
                            <th width="200">Tanggal Upload</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list_dokumen as $data) { ?>
                            <tr>
                                <td align="center" width="2"><?= $data['no'] ?></td>
                                <td align="center" width="5">
                                    <input type="checkbox" name="id_cb[]" value="<?= $data['id'] ?>" />
                                </td>
                                <td>
                                    <div class="uibutton-group">
                                        <a href="<?= site_url("penduduk/delete_dokumen/{$penduduk['id']}/{$data['id']}") ?>" class="uibutton tipsy south" title="Hapus Data" target="confirm" message="Apakah Anda Yakin?" header="Hapus Data"><span class="icon-trash icon-large"><span></a>
                                </td>
                                <td><?= $data['nama'] ?></td>
                                <td><a href="<?= base_url() ?>/assets/files/dokumen/<?= urlencode($data['satuan']) ?>"><?= $data['satuan'] ?></a></td>
                                <td><?= tgl_indo2($data['tgl_upload']) ?></td>
                                <td></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <br>
                <div class="left">
                    <div class="uibutton-group">
                        <a href="<?= site_url("penduduk/form/1/0/{$penduduk['id']}") ?>" class="uibutton icon prev"><span class="icon-prev icon-large"></span> Kembali</a>
                    </div>
                </div>
            </div>
        <?= form_close() ?>
    </div>
</div>
