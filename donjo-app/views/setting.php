<style>
    .bawah {
        position: absolute;
        bottom: 10px;
        right: 10px;
        width: 430px;
    }

</style>
<form action="<?php echo site_url("user_setting/update/$main[id]")?>" method="POST" id="validasi" enctype="multipart/form-data">
    <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
        <table>
            <input name="nama" type="hidden" value="<?php echo $main['nama']?>">
            <tr>
                <th width="100" align="left">Username</th>
                <td><input type="text" class="inputbox" size="30" value="<?php echo $main['username']?>" disabled="disabled"></td>
            </tr>
            <tr>
                <th align="left">Nama</th>
                <td><input name="nama" type="text" class="inputbox" size="30" value="<?php echo $main['nama']?>"></td>
            </tr>
            <tr>
                <th align="left">Password Lama</th>
                <td><input name="pass_lama" type="password" class="inputbox" size="20"></td>
            </tr>
            <tr>
                <th align="left">Password Baru</th>
                <td><input name="pass_baru" type="password" class="inputbox" size="20"></td>
            </tr>
            <tr>
                <th align="left">Password Baru [Ulangi]</th>
                <td><input name="pass_baru1" type="password" class="inputbox" size="20"></td>
            </tr>
            <tr>
                <th align="left" class="top">Foto</th>
                <td>
                    <div class="userbox-avatar">
                        <?if($main['foto']){?>
                        <img src="<?php echo base_url()?>assets/files/user_pict/kecil_<?php echo $main['foto']?>" alt="">
                        <?}else{?>
                        <img src="<?php echo base_url()?>assets/files/user_pict/kuser.png" alt="">
                        <?}?>
                    </div>
                </td>
                <input type="hidden" name="old_foto" value="<?php echo $main['foto']?>">
            </tr>
            <tr>
                <th>Ganti Foto</th>
                <td><input type="file" name="foto"> <span style="color: #aaa;">(Kosongi jika tidak ingin merubah foto)</span></td>
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
</form>
