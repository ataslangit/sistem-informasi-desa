<div id="pageC">
    <div class="content-header"> </div>
    <div id="contentpane">
        <div class="ui-layout-north panel">
            <h3>Form Pengaturan Modul</h3>
        </div>
        <?= form_open_multipart($form_action, ['id' => 'validasi']) ?>
            <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                <table class="form">
                    <tr>
                        <th>Nama Modul</th>
                        <td><input name="modul" type="text" class="inputbox required" size="40" value="<?= $modul['modul'] ?>" /></td>
                    </tr>
                    <tr>
                        <th>URL</th>
                        <td><input name="url" type="text" class="inputbox" size="20" value="<?= $modul['url'] ?>" /></td>
                    </tr>
                    <tr>
                        <th>Ikon</th>
                        <td><input name="ikon" type="text" class="inputbox" size="20" value="<?= $modul['ikon'] ?>" /></td>
                    </tr>
                    <tr>
                        <th width="100">Status</th>
                        <td>
                            <div class="uiradio">
                                <input type="radio" id="g1" name="aktif" value="1" <?php if ($modul['aktif'] === '1' || $modul['aktif'] === '') {
                                                                                        echo 'checked';
                                                                                    } ?>><label for="g1">Aktif</label>
                                <input type="radio" id="g2" name="aktif" value="2" <?php if ($modul['aktif'] === '2') {
                                                                                        echo 'checked';
                                                                                    } ?>><label for="g2">Tidak Aktif</label>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="ui-layout-south panel bottom">
                <div class="left">
                    <a href="<?= site_url() ?>modul" class="uibutton icon prev">Kembali</a>
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
