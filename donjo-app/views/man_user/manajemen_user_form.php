<script>
    $(function() {
        if ($('input[name=group]:checked').next('label').text() == 'SKPD' || $('input[name=group]:checked').next('label').text() == 'UPTD') {
            $('tr.skpd_uptd').show();
        }
        $('input[name=group]').click(function() {
            if ($(this).next('label').text() == 'SKPD' || $(this).next('label').text() == 'UPTD') {
                $('tr.skpd_uptd').show();
            } else {
                $('tr.skpd_uptd').hide();
            }
        });
        if ($('input[name=group]:checked').next('label').text() == 'SKPD') {
            $('tr.skpd').show();
        }
        $('input[name=group]').click(function() {
            if ($(this).next('label').text() == 'SKPD') {
                $('tr.skpd').show();
            } else {
                $('tr.skpd').hide();
            }
        });
        if ($('input[name=group]:checked').next('label').text() == 'UPTD') {
            $('tr.uptd').show();
        }
        $('input[name=group]').click(function() {
            if ($(this).next('label').text() == 'UPTD') {
                $('tr.uptd').show();
            } else {
                $('tr.uptd').hide();
            }
        });
    });
</script>
<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <td style="background:#fff;padding:0px;">
                <div class="content-header">
                </div>
                <div id="contentpane">
                    <div class="ui-layout-north panel">
                        <h3>Form Manajemen Pengguna / User</h3>
                    </div>
                    <?= form_open_multipart($form_action, ['id' => 'validasi']) ?>
                        <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                            <table class="form">
                                <tr>
                                    <th width="100">Level</th>
                                    <td>
                                        <div class="uiradio">
                                            <?php $ch = 'checked'; ?>
                                            <?php if ($user['id_grup'] !== '1') { ?>
                                                <input type="radio" id="group4" name="id_grup" value="4" /<?php if ($user['id_grup'] === '4' || $user['id_grup'] === '') {
                                                    echo $ch;
                                                } ?>><label for="group4">Kontributor</label>
                                                <input type="radio" id="group3" name="id_grup" value="3" /<?php if ($user['id_grup'] === '3') {
                                                    echo $ch;
                                                } ?>><label for="group3">Redaksi</label>
                                                <input type="radio" id="group2" name="id_grup" value="2" /<?php if ($user['id_grup'] === '2') {
                                                    echo $ch;
                                                } ?>><label for="group2">Operator</label>
                                            <?php } ?>
                                            <input type="radio" id="group1" name="id_grup" value="1" /<?php if ($user['id_grup'] === '1') {
                                                echo $ch;
                                            } ?>><label for="group1">Administrator</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td><input name="username" type="text" class="inputbox required" size="40" value="<?= $user['username'] ?>" /></td>
                                </tr>
                                <tr>
                                    <th>Password</th>
                                    <td>
                                        <?= form_password([
                                            'name'        => 'password',
                                            'placeholder' => 'password',
                                            'required'    => true,
                                            'class'       => 'inputbox',
                                            'size'        => '20',
                                            'value'       => ($user ? 'radiisi' : ''),
                                        ]) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <td><input name="nama" type="text" class="inputbox" size="40" value="<?= $user['nama'] ?>" /></td>
                                </tr>
                                <tr>
                                    <th>Nomor HP</th>
                                    <td><input name="phone" type="text" class="inputbox" size="20" value="<?= $user['phone'] ?>" /></td>
                                </tr>
                                <tr>
                                    <th>e-mail</th>
                                    <td><input name="email" type="text" class="inputbox" size="20" value="<?= $user['email'] ?>" /></td>
                                </tr>
                                <tr>
                                    <th class="top">Foto</th>
                                    <td>
                                        <div class="userbox-avatar">
                                            <?php if ($user['foto']) { ?>
                                                <img src="<?= base_url() ?>assets/files/user_pict/kecil_<?= $user['foto'] ?>" alt="" />
                                            <?php } else { ?>
                                                <img src="<?= base_url() ?>assets/files/user_pict/kuser.png" alt="" />
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <input type="hidden" name="old_foto" value="<?= $user['foto'] ?>">
                                </tr>
                                <tr>
                                    <th>Ganti Foto</th>
                                    <td><input type="file" name="foto" /> <span style="color: #aaa;">(Kosongkan jika tidak ingin mengubah foto)</span></td>
                                </tr>
                            </table>
                        </div>

                        <div class="ui-layout-south panel bottom">
                            <div class="left">
                                <a href="<?= site_url() ?>man_user" class="uibutton icon prev">Kembali</a>
                            </div>
                            <div class="right">
                                <div class="uibutton-group">

                                    <button class="uibutton confirm" type="submit">Simpan</button>
                                </div>
                            </div>
                        </div>
                    <?= form_close() ?>
                </div>
            </td>
        </tr>
    </table>
</div>
