<div class="artikel">
    <?php if($_SESSION['sukses']==1){echo "DATA TELAH TERKIRIM DAN AKAN SEGERA KAMI TINDAKLANJUTI";unset($_SESSION['sukses']);} ?>
    <form id="validasi" action="<?php echo site_url()?>first/add_comment/775" method="POST" enctype="multipart/form-data">
        Sila laporkan perubahan data dan/atau informasi penting lainnya yang terkait dengan profil Anda kepada pemerintah desa melalui formulir ini.
        <table class="form">
            <tr>
                <th>Pengirim </th>
                <td> <input class="inputbox" type="text" name="owner" value="<?php echo $_SESSION['nama']?>" size="30"></td>
            </tr>
            <tr>
                <th>NIK</th>
                <td> <input class="inputbox" type="text" name="email" value="<?php echo $_SESSION['nik']?>" size="30"></td>
            </tr>
            <tr>
                <td>Laporan </td>
                <td> <textarea name="komentar" rows="15" cols="80" style="width: 90%; height: 100%">
</textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Kirim"> </td>
            </tr>
        </table>
    </form>
</div>
