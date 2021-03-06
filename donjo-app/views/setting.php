<style>
    .bawah {
        position: absolute;
        bottom: 10px;
        right: 10px;
        width: 430px;
    }
</style>
<?= form_open_multipart('user_setting/update/' . $main['id'], ['id' => 'validasi'], ['nama' => $main['nama']], ['old_foto' => $main['foto']]) ?>
    <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
        <table>
            <tr>
                <th width="100" align="left">Username</th>
                <td><input type="text" class="inputbox" size="30" value="<?= $main['username'] ?>" disabled="disabled" /></td>
            </tr>
            <tr>
                <th align="left">Nama</th>
                <td><input name="nama" type="text" class="inputbox" size="30" value="<?= $main['nama'] ?>" /></td>
            </tr>
            <tr>
                <th align="left">Password Lama</th>
                <td>
                    <?= form_password([
                        'class' => 'inputbox',
                        'name'  => 'pass_lama',
                        'size'  => '20',
                    ]) ?>
                </td>
            </tr>
            <tr>
                <th align="left">Password Baru</th>
                <td>
                    <?= form_password([
                        'class' => 'inputbox',
                        'name'  => 'pass_baru',
                        'size'  => '20',
                    ]) ?>
                </td>
            </tr>
            <tr>
                <th align="left">Password Baru [Ulangi]</th>
                <td>
                    <?= form_password([
                        'class' => 'inputbox',
                        'name'  => 'pass_baru1',
                        'size'  => '20',
                    ]) ?>
                </td>
            </tr>
            <tr>
                <th align="left" class="top">Foto</th>
                <td>
                    <div class="userbox-avatar">
                        <?php if ($main['foto']) { ?>
                            <img src="<?= base_url() ?>assets/files/user_pict/kecil_<?= $main['foto'] ?>" alt="" />
                        <?php } else { ?>
                            <img src="<?= base_url() ?>assets/files/user_pict/kuser.png" alt="" />
                        <?php } ?>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Ganti Foto</th>
                <td><input type="file" name="foto" /> <span style="color: #aaa;">(Kosongi jika tidak ingin merubah foto)</span></td>
            </tr>
        </table>
    </div>
    <div class="ui-layout-south panel bottom bawah">
        <div class="right">
            <div class="uibutton-group">
                <button class="uibutton" type="button" onclick="$('#window').dialog('close');">Close</button><button class="uibutton confirm" type="submit">Simpan</button>
            </div>
        </div>
    </div>
<?= form_close() ?>
