<!DOCTYPE html>
<html>

<head>
    <title>SID - Desa <?= $desa['nama_desa'] ?></title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="shortcut icon" href="<?= base_url() ?>favicon.ico" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?= base_url() ?>rss.xml" />
    <link href="<?= base_url() ?>assets/css/screen.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/style-gis.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/noJS.css" /></noscript>


    <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-1.5.2.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-ui-1.8.16.custom.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-layout.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.formtips.1.2.2.packed.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.tipsy.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.elastic.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.flexbox.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.easing-1.3.pack.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/donjoscript/donjoscript2.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/donjoscript/donjo.ui.layout.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/donjoscript/donjo.ui.mainmenu.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/donjoscript/donjo.ui.dialog.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/donjoscript/donjo.ui.attribut.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/validasi.js"></script>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/jscolor/jscolor.js"></script>
    <?php $ipend = $this->header_model->init_penduduk(); ?>
</head>

<body>
    <div class="ui-layout-north" id="header">
        <div id="sid-logo"><a href="<?= site_url() ?>first" target="_blank"><img src="<?= base_url() ?>assets/files/logo/<?= $desa['logo'] ?>" alt="" /></a></div>
        <div id="sid-judul">SID Sistem Informasi Desa</div>
        <div id="sid-info">Desa <?= $desa['nama_desa'] ?>, <?= $desa['nama_kecamatan'] ?>, <?= $desa['nama_kabupaten'] ?> </div>
        <div id="userbox" class="wrapper-dropdown-3" tabindex="1">
            <div class="avatar">
                <?php if ($foto) { ?>
                    <img src="<?= base_url() ?>assets/files/user_pict/kecil_<?= $foto ?>" alt="" />
                <?php } else { ?>
                    <img src="<?= base_url() ?>assets/files/user_pict/kuser.png" alt="" />
                <?php } ?>
            </div>
            <div class="info">
                <div><strong>Anda Login sebagai</strong></div>
                <div><?= $nama ?></div>
            </div>

            <ul class="dropdown" tabindex="1">
                <li><a href="<?= site_url('admin/dashboard') ?>"><i class="icon-home icon-large"></i>SID Home</a></li>
                <li><a href="<?= site_url() ?>user_setting" target="ajax-modalz" rel="window-lok" header="Pengaturan Pengguna" title="Pengaturan Pengguna"><i class="icon-user icon-large"></i>Setting User</a></li>
                <?php if ($_SESSION['grup'] === 1) { ?>
                    <li><a href="<?= site_url() ?>modul/clear"><i class="icon-gear icon-large"></i>Pengaturan</a></li>
                <?php } ?>
                <li><a href="<?= site_url() ?>siteman"><i class="icon-off icon-large"></i>Log Out</a></li>
            </ul>

        </div>
    </div>
    <div id="sidebar">
    </div>
    <div class="ui-layout-center" id="wrapper">


        <!-- NOTIFICATION
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>--><?php if ($_SESSION['success'] === 1) : ?>
            <script type="text/javascript">
                $('document').ready(function() {
                    notification('success', 'Data Berhasil Disimpan')();
                });
            </script><?php elseif ($_SESSION['success'] === -1) : ?>
            <script type="text/javascript">
                $('document').ready(function() {
                    notification('error', 'Data Gagal Disimpan')();
                });
            </script><?php elseif ($_SESSION['success'] === -2) : ?>
            <script type="text/javascript">
                $('document').ready(function() {
                    notification('error', 'Simpan data gagal, nama id sudah ada!')();
                });
            </script><?php elseif ($_SESSION['success'] === -3) : ?>
            <script type="text/javascript">
                $('document').ready(function() {
                    notification('error', 'Simpan data gagal, nama id sudah ada!')();
                });
            </script><?php endif; ?><?php $_SESSION['success'] = 0; ?>
            <!-- ************ -->
            <!-- ************ -->

            <div class="module-panel">
                <div class="contentm" style="overflow: hidden;">
                    <?php foreach ($modul as $mod) { ?>
                        <a class="cpanel" href="<?= site_url() ?><?= $mod['url'] ?>">
                            <img src="<?= base_url() ?>assets/images/cpanel/<?= $mod['ikon'] ?>" alt="" />
                            <span><?= $mod['modul'] ?></span>
                        </a>
                    <?php } ?>
                </div>
            </div>
