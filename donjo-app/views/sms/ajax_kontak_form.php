<script src="<?php echo base_url()?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url()?>assets/js/validasi.js"></script>
<form action="<?php echo $form_action?>" method="post" id="validasi">
    <table style="width:100%">
        <tr>
            <th>Nama</th>
            <td>
                <select name="id_pend">
                    <option value=""> -- </option>
                    <?php foreach($nama AS $data){
				?>
                    <option value="<?php echo $data['id'] ?>"><?php echo unpenetration($data['nama'])?></option>
                    <?php }?>
                </select>
            </td>
        </tr>
        <tr>
            <th>No HP</th>
            <td><input name="no_hp" type="text" class="inputbox required" size="30" maxlength='15' /></td>
        </tr>
    </table>
    <div class="buttonpane" style="text-align: right; width:400px;position:absolute;bottom:0px;>
 <div class=" uibutton-group">
        <button class="uibutton" type="button" onclick="$('#window').dialog('close');">Tutup</button>
        <button class="uibutton confirm" type="submit">Simpan</button>
    </div>
    </div>
</form>
