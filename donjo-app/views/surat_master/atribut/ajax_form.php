<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/validasi.js"></script>
<?= form_open($form_action, ['id' => 'validasi']) ?>
    <table class="form">
        <tr>
            <th>Atribut</th>
            <td><input name="nilai" type="text" class="inputbox" size="10" value="<?= $analisis_parameter['nama'] ?>" /></td>
        </tr>
        <tr>
            <th>Tipe</th>
            <td><input name="id_tipe" type="text" class="inputbox" size="10" value="<?= $analisis_parameter['nilai'] ?>" /></td>
        </tr>
        <tr>
            <th>Nilai</th>
            <td><input name="nilai" type="text" class="inputbox" size="10" value="<?= $analisis_parameter['nilai'] ?>" /></td>
        </tr>
        <tr>
            <th>Nilai</th>
            <td><input name="nilai" type="text" class="inputbox" size="10" value="<?= $analisis_parameter['nilai'] ?>" /></td>
        </tr>
        </tr>
    </table>
    <div class="buttonpane" style="text-align: right; width:400px;position:absolute;bottom:0px;">
        <div class="uibutton-group">
            <button class="uibutton confirm" type="submit">Simpan</button>
        </div>
    </div>
<?= form_close() ?>
