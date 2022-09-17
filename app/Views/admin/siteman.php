<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>SID <?= APP_VERSION ?> Login</title>
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/login-new.css" media="screen" type="text/css" />
</head>

<body>
    <div id="loginform">
        <a href="<?= site_url('first') ?>">
            <div id="facebook">
                <div id="sid">SID</div>
                <div id="connect">ver.</div>
                <div id="logo"><img src="<?= base_url() ?>/assets/images/SID-e1351656852451.png"></div>
                <div id="desa">Desa <?= unpenetration($desa['nama_desa']) ?></div>
                <div id="kec">Kecamatan <?= unpenetration($desa['nama_kecamatan']) ?></div>
                <div id="kab">Kabupaten <?= unpenetration($desa['nama_kabupaten']) ?></div>
            </div>
        </a>
        <div id="mainlogin">
            <div id="or"><?= APP_VERSION ?></div>
            <h1>Masukkan Username dan Password</h1>
            <?= form_open('siteman/auth') ?>
                <input name="username" type="text" placeholder="username" value="" required>
                <?= form_password([
                    'name'        => 'password',
                    'placeholder' => 'password',
                    'required'    => true,
                ]) ?>
                <button type="submit" id="but">LOGIN</button>
            <?= form_close() ?>
        </div>
        <div id="facebook2">
            <div id="kab2"><a href="http://combine.or.id" target="_blank"><img align=center src="<?= base_url() ?>/assets/images/logo-combine.png"></a></div>
        </div>
    </div>
</body>

</html>
