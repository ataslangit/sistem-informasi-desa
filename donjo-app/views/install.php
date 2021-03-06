<!DOCTYPE html>
<html>

<head>
    <title>Sistem Informasi Desa (SID)</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="shortcut icon" href="<?= base_url() ?>favicon.ico" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?= base_url() ?>rss.xml" />
    <link href="<?= base_url() ?>assets/css/screen.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/style2.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/noJS.css" />
    <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-1.5.2.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-ui-1.8.16.custom.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.formtips.1.2.2.packed.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.tipsy.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.elastic.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.flexbox.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.easing-1.3.pack.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/donjoscript/donjoscript2.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/donjoscript/donjo.ui.dialog.js"></script>
    <style>
        body {
            background: url("<?= base_url() ?>assets/files/bg.jpg") no-repeat center center fixed;
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
        <h1>Instalasi Database SID <?= APP_VERSION ?></h1>
        <hr>
        <div style="width:400px;margin:0px auto;">
            <h4>Klik ???Lanjut??? untuk memulai proses instalasi database SID. Proses instalasi memerlukan waktu singkat. Setelah selesai, Anda akan mendapatkan ???username??? dan ???password???. Catat/simpan ???username??? dan ???password??? sebelum meneruskan ke langkah selanjutnya.</h4><br>
            <a href="<?= site_url(); ?>main/install" class="uibutton special">Lanjut</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
    </div>
</body>

</html>
