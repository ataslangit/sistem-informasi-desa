<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <td style="background:#fff;padding:0px;">
                <div id="contentpane">
                    <?= form_open_multipart($form_action, ['id' => 'validasi']) ?>
                        <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                            <table class="form">
                                <tr>
                                    <th width="100">Nama Kategori</th>
                                    <td><input class="inputbox" type="text" name="nama" value="<?= $polygon['nama'] ?>" size="40" /></td>
                                </tr>
                                <tr>
                                    <th>Warna</th>
                                    <td>
                                        <input class="color inputbox" size="7" value="<?= $polygon['color'] ?>" name="color">
                                    </td>
                                </tr>
                                <?php ?>
                            </table>
                        </div>

                        <div class="ui-layout-south panel bottom">
                            <div class="left">
                                <a href="<?= site_url() ?>polygon" class="uibutton icon prev">Kembali</a>
                            </div>
                            <div class="right">
                                <div class="uibutton-group">

                                    <button class="uibutton confirm" type="submit">Simpan</button>
                                </div>
                            </div>
                        </div>
                    <?= form_close() ?>
                </div>
            </td>
        </tr>
    </table>
</div>
