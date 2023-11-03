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
            max-width: 400px;
            background: #ddddff repeat-x;
            margin: 150px auto 0px auto;
            padding: 10px;
            box-shadow: 0px 0px 15px #777;
            -moz-box-shadow: 0px 0px 15px #777;
            -webkit-box-shadow: 0px 0px 15px #777;
            font-size: 1.5em;
        }

    </style>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div id="full">
        <p>
            Selamat datang. <br>Sebelum memulai, Sistem Informasi Desa membutuhkan informasi terkait database yang akan digunakan.
            Silakan isi informasi yang dibutuhkan.
        </p>
        <?= form_open(route_to('install.process')) ?>
        <ol>
            <li>
                Nama database<br>
                <input name="db_name" required>
            </li>
            <li>
                Database username<br>
                <input name="db_user" required>
            </li>
            <li>
                Database password<br>
                <input name="db_pass" required>
            </li>
            <li>
                Database host<br>
                <input name="db_host" required value="localhost">
            </li>
            <!-- <li>Prefix Table</li> -->
        </ol>

        <hr>

        <p>Isikan informasi data pengguna, akan digunakan untuk masuk pada sistem.</p>
        <ul>
            <li>
                Alamat email<br>
                <input name="user_mail" type="email" required>
            </li>
            <li>
                Nama Pengguna<br>
                <input name="user_name" required>
            </li>
            <li>
                Katasandi<br>
                <input name="user_pass" required>
            </li>
            <li>
                Ulangi Katasandi<br>
                <input name="user_pass2" required>
            </li>
        </ul>

        <p>Klik tombol dibawah untuk melanjutkan proses.</p>

        <br>

        <?= form_button([
            'content' => 'Lanjut',
            'class' => 'uibutton special',
            'type' => 'submit',
        ]) ?>

        <?= form_close() ?>

    </div>
<?= $this->endSection() ?>
