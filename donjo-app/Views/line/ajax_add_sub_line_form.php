<form id="" action="<?php echo $form_action?>" method="POST">
    <table style="width:100%">
        <tr>
            <th width="100">Nama line</th>
            <td><input class="inputbox" type="text" name="nama" value="<?php echo $line['nama']?>" size="40"></td>
        </tr>
        <tr>
            <th>Warna</th>
            <td>
                <input class="color inputbox" size="7" value="<?php echo $line['color']?>" name="color">
            </td>
        </tr>
    </table>
    <div class="buttonpane" style="text-align: right; width:400px;position:absolute;bottom:0px;">
        <div class="uibutton-group">
            <button class="uibutton" type="button" onclick="$('#window').dialog('close');">Close</button>
            <button class="uibutton confirm" type="submit">Simpan</button>
        </div>
    </div>
</form>
<script src="<?php echo base_url()?>assets/js/jscolor/jscolor.js"></script>
