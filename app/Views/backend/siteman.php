<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>" media="screen" type="text/css" />
</head>

<body>
    <div id="loginform">
        <a href="<?= site_url('/') ?>">
            <div id="facebook">
                <div id="sid">SID</div>
                <div id="logo"><img src="<?= base_url('assets/images/SID-e1351656852451.png') ?>"></div>
                <div id="desa">Desa <?= esc($desa['nama_desa'] ?? 'nama desa') ?></div>
                <div id="kec">Kecamatan <?= esc($desa['nama_kecamatan'] ?? 'nama kecamatan') ?></div>
                <div id="kab">Kabupaten <?= esc($desa['nama_kabupaten'] ?? 'nama kabupaten') ?></div>
            </div>
        </a>
        <div id="mainlogin">
            <h1>Masukkan Username dan Password</h1>
            <?= form_open('siteman/check') ?>

            <?= form_input('username', set_value('username'), ['placeholder' => 'Username', 'required' => '']) ?>
            <?= form_password('password', '', ['placeholder' => 'Password', 'required' => '']) ?>

            <?= form_button([
                'type'    => 'submit',
                'id'      => 'but',
                'content' => 'Masuk',
            ]) ?>

            <?php
            if ($validation->hasError('username') || $validation->hasError('password')) {
                echo '<div id="note">';
                echo 'Login Gagal. Username atau Password yang Anda masukkan salah!';
                echo '</div>';
            }
            ?>

            <?php if (session('siteman') === -2) { ?>
                <div id="note">
                    Tidak ada aktivitas dalam jangka waktu yang cukup lama. Demi keamanan silakan Login kembali.
                </div>
            <?php }
            // unset(session('siteman'));
            ?>

            <?= form_close() ?>
        </div>
    </div>
</body>

</html>
