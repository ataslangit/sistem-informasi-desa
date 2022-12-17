<!DOCTYPE html>
<html lang="id">

<head>
    <title>Sistem Informasi Desa</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link rel="shortcut icon" href="<?= base_url('favicon.ico') ?>">
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?= base_url('rss.xml') ?>">

    <link rel="stylesheet" href="<?= base_url('assets/css/screen.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style2.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/noJS.css') ?>">


    <script src="<?= base_url('assets/js/jquery-1.5.2.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery-ui-1.8.16.custom.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery-layout.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery.formtips.1.2.2.packed.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery.tipsy.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery.elastic.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery.flexbox.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery.easing-1.3.pack.js') ?>"></script>
    <script src="<?= base_url('assets/js/donjoscript/donjoscript2.js') ?>"></script>
    <script src="<?= base_url('assets/js/donjoscript/donjo.ui.layout.js') ?>"></script>
    <script src="<?= base_url('assets/js/donjoscript/donjo.ui.mainmenu.js') ?>"></script>
    <script src="<?= base_url('assets/js/donjoscript/donjo.ui.dialog.js') ?>"></script>
    <script src="<?= base_url('assets/js/donjoscript/donjo.ui.attribut.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery.validate.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/validasi.js') ?>"></script>
    <script src="http://maps.googleapis.com/maps/api/js?v=4&sensor=false"></script>
    <!---->
    <!--[if lte IE 6]>
<style>
img, div,span,a,button { behavior: url(assets/js/iepngfix.htc) }
</style>
<link href="=base_url('assets/css/ie6.css') ?>" rel="stylesheet">
<![endif]-->

    <style>
        .iconic {
            -moz-box-shadow: inset 0px 1px 0px 0px #ffffff;
            -webkit-box-shadow: inset 0px 1px 0px 0px #ffffff;
            box-shadow: inset 0px 1px 0px 0px #ffffff;
            background-color: transparent;
            -webkit-border-top-left-radius: 6px;
            -moz-border-radius-topleft: 6px;
            border-top-left-radius: 6px;
            -webkit-border-top-right-radius: 6px;
            -moz-border-radius-topright: 6px;
            border-top-right-radius: 6px;
            -webkit-border-bottom-right-radius: 6px;
            -moz-border-radius-bottomright: 6px;
            border-bottom-right-radius: 6px;
            -webkit-border-bottom-left-radius: 6px;
            -moz-border-radius-bottomleft: 6px;
            border-bottom-left-radius: 6px;
            text-indent: 0;
            border: 1px solid #cccccc;
            display: inline-block;
            color: #ffffff;
            line-height: 25px;
            width: 30px;
            text-align: center;
            text-shadow: 1px 1px 0px #ffffff;
        }

        .iconic:active {
            position: relative;
            top: 1px;
        }
    </style>
</head>

<body>
    <div class="ui-layout-north" id="header">
        <div id="sid-logo"><a href="<?= site_url('first') ?>" target="_blank"><img src="<?= base_url('assets/files/logo/' . $desa['logo']) ?>" alt=""></a></div>
        <div id="sid-judul">SID Sistem Informasi Desa</div>
        <div id="sid-info"><?= unpenetration($desa['nama_desa']) ?>, Kec. <?= unpenetration($desa['nama_kecamatan']) ?>, <?= unpenetration($desa['nama_kabupaten']) ?></div>
        <div id="userbox" class="wrapper-dropdown-3" tabindex="1">
            <div class="avatar">
                <?php if ($foto) { ?>
                    <img src="<?= base_url('assets/files/user_pict/kecil_' . $foto) ?>" alt="">
                <?php } else { ?>
                    <img src="<?= base_url('assets/files/user_pict/kuser.png') ?>" alt="">
                <?php } ?>
            </div>
            <div class="info">
                <div><strong>Anda Login sebagai</strong></div>
                <div><?= $nama ?></div>
            </div>

            <ul class="dropdown" tabindex="1">
                <?php if ($_SESSION['grup'] === 1 || $_SESSION['grup'] === 2) { ?>
                    <li><a href="<?= site_url('hom_desa') ?>"><i class="fa fa-home"></i>SID Home</a></li>
                    <li><a href="<?= site_url('sid_core') ?>"><i class="icon-group icon-large"></i>Penduduk</a></li>
                    <li><a href="<?= site_url('statistik') ?>"><i class="fa fa-bar-chart"></i>Statistik</a></li>
                    <li><a href="<?= site_url('surat') ?>"><i class="fa fa-print"></i>Cetak Surat</a></li>
                    <li><a href="<?= site_url('analisis') ?>"><i class="icon-dashboard icon-large"></i>Analisis</a></li>
                <?php } ?>
                <?php if ($_SESSION['grup'] === 1 || $_SESSION['grup'] === 2) { ?>
                    <?php if ($_SESSION['grup'] === 1) { ?>
                        <li><a href="<?= site_url('man_user') ?>/clear"><i class="fa fa-user"></i>Pengguna</a></li>
                        <li><a href="<?= site_url('database') ?>"><i class="icon-hdd icon-large"></i>Database</a></li>
                    <?php } ?>
                    <li><a href="<?= site_url('sms') ?>"><i class="icon-envelope-alt icon-large"></i>SMS</a></li>
                    <li><a href="<?= site_url('web') ?>"><i class="icon-cloud icon-large"></i>Admin Web</a></li>
                <?php } ?>
                <li><a href="<?= site_url('siteman') ?>"><i class="fa fa-sign-out"></i>Log Out</a></li>
            </ul>

        </div>
    </div>
