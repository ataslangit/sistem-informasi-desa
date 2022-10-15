<div class="form-group">
    <div>Belum ada komentar atas artikel ini, silakan tuliskan dalam formulir berikut ini</div>
</div>
<div class="form-group">
    <div class="box box-default">
        <div class="box-header">
            <h3 class="box-title">Formulir Penulisan Komentar</h3>
        </div>
        <div class="box-body">
            <form name="form" action="/first/add_comment/<?= $artikel->id ?>" method="POST" onsubmit="return validasi(this)">
                <table width="100%">
                    <tbody>
                        <tr class="komentar">
                            <td>Nama</td>
                            <td> <input type="text" name="owner" size="20" maxlength="30"></td>
                        </tr>
                        <tr class="komentar">
                            <td>Alamat e-mail</td>
                            <td> <input type="text" name="email" size="20" maxlength="30"></td>
                        </tr>
                        <tr class="komentar">
                            <td valign="top">Komentar</td>
                            <td> <textarea name="komentar" style="width: 300px; height: 100px;"></textarea></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><input class="btn" type="submit" value="Kirim"></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
