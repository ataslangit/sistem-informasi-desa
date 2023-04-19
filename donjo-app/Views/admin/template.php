<?php

use App\Cells\AdminModul;
use App\Models\Config_model;
use App\Models\User_model;

$configModel = new Config_model();
$userModel = new User_model();

$desa = $configModel->first();
$user = $userModel->find(session()->get('id'));

$foto = '';
$nama = 'Unknown';
if($user !== null) {
    $foto = $user[0]['foto'];
    $nama = $user[0]['nama'];
}

$modul = [];
$act = 0;


?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>SID - Desa <?php echo $desa['nama_desa'] ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link rel="shortcut icon" href="<?php echo base_url('assets/files/logo/' . $desa['logo']) ?>">
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo base_url('rss.xml') ?>">
    <link href="<?php echo base_url('assets/css/screen.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style2.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/noJS.css') ?>">

    <script src="<?php echo base_url('assets/js/jquery-1.5.2.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery-ui-1.8.16.custom.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery-layout.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.formtips.1.2.2.packed.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.tipsy.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.elastic.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.flexbox.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.easing-1.3.pack.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/donjoscript/donjoscript2.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/donjoscript/donjo.ui.layout.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/donjoscript/donjo.ui.mainmenu.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/donjoscript/donjo.ui.dialog.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/donjoscript/donjo.ui.attribut.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/validasi.js') ?>"></script>
</head>

<body>
    <div class="ui-layout-north" id="header">
        <div id="sid-logo"><a href="<?php echo site_url('first') ?>" target="_blank"><img src="<?php echo base_url('assets/files/logo/' . $desa['logo']) ?>" alt=""></a></div>
        <div id="sid-judul">Sistem Informasi Desa</div>
        <div id="sid-info">Desa <?php echo $desa['nama_desa'] ?>, <?php echo $desa['nama_kecamatan'] ?>, <?php echo $desa['nama_kabupaten'] ?> </div>
        <div id="userbox" class="wrapper-dropdown-3" tabindex="1">
            <div class="avatar">
                <?php if ($foto) { ?>
                    <img src="<?php echo base_url('assets/files/user_pict/kecil_' . $foto) ?>" alt="">
                <?php } else { ?>
                    <img src="<?php echo base_url('assets/files/user_pict/kuser.png') ?>" alt="">
                <?php } ?>
            </div>
            <div class="info">
                <div><strong>Anda Login sebagai</strong></div>
                <div><?php echo $nama ?></div>
            </div>

            <ul class="dropdown" tabindex="1">
                <li><a href="<?php echo site_url('user_setting') ?>" target="ajax-modalz" rel="window-lok" header="Pengaturan Pengguna" title="Pengaturan Pengguna"><i class="fa fa-user"></i>Setting User</a></li>
                <?php if (session()->get('grup') == 1) { ?>
                    <li><a href="<?php echo site_url('modul/clear') ?>"><i class="fa fa-cogs"></i>Pengaturan</a></li>
                <?php } ?>
                <li><a href="<?php echo site_url('siteman') ?>"><i class="fa fa-sign-out"></i>Log Out</a></li>
            </ul>

        </div>
    </div>
    <div class="ui-layout-center" id="wrapper">

        <?php if (@$_SESSION['success'] == 1) : ?>
            <script>
                $(function() {
                    notification('success', 'Data Berhasil Disimpan')();
                });
            </script>
        <?php elseif (@$_SESSION['success'] == -1) : ?>
            <script>
                $(function() {
                    notification('error', 'Data Gagal Disimpan')();
                });
            </script>
        <?php endif; ?>

        <?php $_SESSION['success'] = 0; ?>

        <?= view_cell('AdminModul::nav') ?>

        <div id="nav">
            <ul>
                <?php if ($_SESSION['grup'] == 1) { ?>
                    <li <?php if ($act == 0) { ?>class="selected" <?php } ?>>
                        <a href="<?php echo site_url('hom_desa') ?>">Identitas Desa</a>
                    </li>
                <?php } ?>
                <li <?php if ($act == 1) { ?>class="selected" <?php } ?>>
                    <a href="<?php echo site_url('pengurus') ?>">Pemerintah Desa</a>
                </li>
                <li <?php if ($act == 2) { ?>class="selected" <?php } ?>>
                    <a href="<?php echo site_url('hom_desa/about') ?>">SID <?= VERSI_SID ?></a>
                </li>
            </ul>
        </div>


        <?= $this->renderSection('content') ?>



    </div>
    <div class="ui-layout-south" id="footer">
        <span style="color:#002301;">Aplikasi SID versi <?= VERSI_SID ?> dikembangkan oleh</span>
        <a href="http://combine.or.id" target="_blank" style="color:#006f00;text-decoration:none;font-weight:bold;">Combine Resource Institution</a> merujuk pada <a target="_blank" href="http://www.gnu.org/licenses/gpl.html" target="_blank" style="color:#006f00;text-decoration:none;font-weight:bold;"> GNU GENERAL PUBLIC LICENSE Version 3.</a>
    </div>
</body>

</html>
