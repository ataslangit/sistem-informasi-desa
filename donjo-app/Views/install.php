<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/screen.css') ?>">

    <style>
        body {
            background: url(<?= base_url('assets/files/bg.jpg') ?>) no-repeat center center fixed;
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

<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div id="full">
        <h1>Instalasi Database Sistem Informasi Desa</h1>
        <hr>
        <div style="width:400px;margin:0px auto;">
            <h4>Klik “Lanjut” untuk memulai proses instalasi database SID. Proses instalasi memerlukan waktu singkat. Setelah selesai, Anda akan mendapatkan “username” dan “password”. Catat/simpan “username” dan “password” sebelum meneruskan ke langkah selanjutnya.</h4><br>
            <a href="<?= site_url('main/install') ?>" class="uibutton special">Lanjut</a>
        </div>
    </div>
<?= $this->endSection() ?>
