<?php /*
<div class="form-group">
    <?php if (is_array($komentar)) { ?>
            <div class="box box-default box-solid">
                <div class="box-header"><h3 class="box-title">Komentar atas <?= esc($single_artikel['judul']) ?></h3></div>
                <div class="box-body">


        <?php foreach ($komentar as $data) { ?>
            <?php if ($data['enabled'] === 1) { ?>
                    <div class="kom-box">
                        <div style="font-size:.8em;font-color:#aaa;">
                            <i class="fa fa-user"></i> ' . $data['owner'] . ' <i class="fa fa-clock-o"></i> ' . tgl_indo2($data['tgl_upload']) . '
                        </div>
                        <div>
                            <blockquote>' . $data['komentar'] . '</blockquote>
                        </div>
                    </div>';
            }
        }
        echo '
                </div>
            </div>
            ';
    } else {
        echo '<div>Belum ada komentar atas artikel ini, silakan tuliskan dalam formulir berikut ini</div>';
    }
    echo '
        </div>
        <div class="form-group">
            <div class="box box-default">
                <div class="box-header"><h3 class="box-title">Formulir Penulisan Komentar</h3></div>
                <div class="box-body">
                    ' . form_open('first/add_comment/' . $single_artikel['id'], ['onSubmit' => 'return validasi(this)']) . '
                    <table width=100%>
                        <tr class="komentar"><td>Nama</td><td> <input type=text name="owner" size=20 maxlength=30></td></tr>
                        <tr class="komentar"><td>Alamat e-mail</td><td> <input type=text name="email" size=20 maxlength=30></td></tr>
                        <tr class="komentar"><td valign=top>Komentar</td><td> <textarea name="komentar" style="width: 300px; height: 100px;"></textarea></td></tr>
                        <tr><td>&nbsp;</td><td><input type="submit" value="Kirim"></td></tr>
                    </table>
                    ' . form_close() . '
                </div>
            </div>
        </div>
    </div>

    */
