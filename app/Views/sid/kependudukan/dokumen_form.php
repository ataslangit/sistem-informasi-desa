<style>
    .bawah {
        position: absolute;
        bottom: 10px;
        right: 10px;
        width: 430px;
    }
</style>
<?= form_open_multipart($form_action, ['id' => 'validasi']) ?>
    <table class="form">
        <tr>
            <td width="90">Nama / Jenis Dokumen</td>
            <td>
                <input class="inputbox" type="text" name="nama" size="40" />
            </td>
        </tr>
        <tr>
            <td>Berkas Dokumen</td>
            <td>
                <input type="file" name="satuan" />
            </td>
        </tr>
    </table>
    <input type="hidden" name="id_pend" value="<?= $penduduk['id'] ?>" />
    <div class="ui-layout-south panel bottom bawah">
        <div class="right">
            <div class="uibutton-group">
                <button class="uibutton confirm" type="submit">Upload</button>
            </div>
        </div>
    </div>
<?= form_close() ?>
