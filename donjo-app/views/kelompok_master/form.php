<div id="pageC">
    <div class="content-header">
    </div>
    <div id="contentpane">
        <div class="ui-layout-north panel">
            <h3>Form Kategori Kelompok</h3>
        </div>
        <?= form_open_multipart($form_action, ['id' => 'validasi']) ?>
        <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
            <table class="form">
                <tr>
                    <th>Kategori/ Kategori Kelompok</th>
                    <td><input name="kelompok" type="text" class="inputbox" size="80" value="<?= $kelompok_master['kelompok'] ?? '' ?>" /></td>
                </tr>
                <tr>
                <tr>
                    <th width="120" colspan="2">Deskripsi</th>
                </tr>
                <tr>
                    <td colspan="2">
                        <textarea name="deskripsi" style="width:600px; height:300px;resize:none;"><?= $kelompok_master['deskripsi'] ?? '' ?></textarea>
                    </td>
                </tr>
            </table>
        </div>

        <div class="ui-layout-south panel bottom">
            <div class="left">
                <a href="<?= site_url('kelompok_master') ?>" class="uibutton icon prev">Kembali</a>
            </div>
            <div class="right">
                <div class="uibutton-group">
                    <button class="uibutton confirm" type="submit">Simpan</button>
                </div>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>
