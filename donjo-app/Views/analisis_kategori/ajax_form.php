<script src="<?php echo base_url()?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url()?>assets/js/validasi.js"></script>
<form action="<?php echo $form_action?>" method="post" id="validasi">
    <table class="form">
        <tr>
            <th>Nama Kategori/Variabel</th>
            <td><input name="kategori" type="text" class="inputbox required" size="50" value="<?php echo $analisis_kategori['kategori']?>"></td>
        </tr>
    </table>
    <div class="buttonpane" style="text-align: right; width:400px;position:absolute;bottom:0px;">
        <div class="uibutton-group">
            <button class="uibutton confirm" type="submit">Simpan</button>
        </div>
    </div>
</form>
