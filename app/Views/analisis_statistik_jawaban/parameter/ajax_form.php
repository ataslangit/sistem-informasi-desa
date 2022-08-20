<script type="text/javascript" src="<?= base_url() ?>/assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/js/validasi.js"></script>
<?= form_open($form_action, ['id' => 'validasi']) ?>
    <table class="form">
        <tr>
            <th>Kode</th>
            <td><input name="kode_jawaban" type="text" class="inputbox" size="5" value="<?= $analisis_parameter['kode_jawaban'] ?>" /></td>
        </tr>
        <tr>
            <th>Jawaban</th>
            <td><textarea name="jawaban" class="required" style="resize:none;width:300px;height:30px;"><?= $analisis_parameter['jawaban'] ?></textarea></td>
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
