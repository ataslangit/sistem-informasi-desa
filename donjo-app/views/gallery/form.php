<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <td style="background:#fff;padding:0px;">
                <div class="content-header">
                    <h3>Form Manajemen Gallery</h3>
                </div>
                <div id="contentpane">
                    <?= form_open_multipart($form_action, ['id' => 'validasi']) ?>
                        <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                            <table class="form">
                                <tr>
                                    <th>Nama Album</th>
                                    <td><input name="nama" type="text" class="inputbox" size="60" value="<?= $gallery['nama'] ?>" /></td>
                                </tr>
                                <?php if ($gallery['gambar']) { ?>
                                    <tr>
                                        <th class="top">Gambar</th>
                                        <td>
                                            <div>
                                                <img width="440" height="300" src="<?= base_url() ?>assets/files/galeri/sedang_<?= $gallery['gambar'] ?>" alt="" />
                                            </div>
                                        </td>
                                        <input type="hidden" name="old_gambar" value="<?= $gallery['gambar'] ?>">
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <th>Upload Gambar</th>
                                    <td><input type="file" name="gambar" /> <span style="color: #aaa;">(Kosongi jika tidak ingin mengubah gambar)</span></td>
                                </tr>
                            </table>
                        </div>

                        <div class="ui-layout-south panel bottom">
                            <div class="left">
                                <a href="<?= site_url() ?>gallery" class="uibutton icon prev">Kembali</a>
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
