<!DOCTYPE html>
<html lang="id">

<head>
    <title>Sistem Informasi Desa (SID)</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link rel="shortcut icon" href="<?php echo base_url('favicon.ico')?>">
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo base_url('rss.xml') ?>">

    <link rel="stylesheet" href="<?php echo base_url('assets/css/screen.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style2.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/noJS.css') ?>">

    <script src="<?php echo base_url('assets/js/jquery-1.5.2.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery-ui-1.8.16.custom.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.formtips.1.2.2.packed.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.tipsy.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.elastic.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.flexbox.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.easing-1.3.pack.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/donjoscript/donjoscript2.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/donjoscript/donjo.ui.dialog.js') ?>"></script>
    <style>
        body {
            background: url(<?php echo base_url('assets/files/bg.jpg') ?>) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            margin: 0px;
            padding: 0px;
        }

        #full {
            background: #ddddff repeat-x;
            text-align: center;
            margin: 150px 0px 0px 0px;
            padding: 10px;
            box-shadow: 0px 0px 15px #777;
            -moz-box-shadow: 0px 0px 15px #777;
            -webkit-box-shadow: 0px 0px 15px #777;
        }

    </style>
</head>

<body>
    <div id="full">
        <h1>Instalasi Database SID <?= VERSI_SID ?></h1>
        <hr>
        <div style="width:400px;margin:0px auto;">
            <h4>Klik “Lanjut” untuk memulai proses instalasi database SID. Proses instalasi memerlukan waktu singkat. Setelah selesai, Anda akan mendapatkan “username” dan “password”. Catat/simpan “username” dan “password” sebelum meneruskan ke langkah selanjutnya.</h4><br>
            <a href="<?php echo site_url('install/run') ?>" class="uibutton special">Lanjut</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
    </div>
</body>

</html>
