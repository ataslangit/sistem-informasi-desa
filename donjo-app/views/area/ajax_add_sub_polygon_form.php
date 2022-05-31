<?= form_open_multipart($form_action, ['id' => 'validasi']) ?>
    <table style="width:100%">
        <tr>
            <th width="100">Nama area</th>
            <td><input class="inputbox" type="text" name="nama" value="<?= $area['nama'] ?>" size="40" /></td>
        </tr>
        <tr>
            <th>Simbol</th>
            <td>
                <input class="inputbox" type="file" name="simbol" value="<?= $area['simbol'] ?>" size="20" />
            </td>
        </tr>
    </table>
    <div class="buttonpane" style="text-align: right; width:400px;position:absolute;bottom:0px;">
        <div class="uibutton-group">
            <button class="uibutton" type="button" onclick="$('#window').dialog('close');">Close</button>
            <button class="uibutton confirm" type="submit">Simpan</button>
        </div>
    </div>
<?= form_close() ?>
