<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>SID <?= VERSI_SID ?> Login</title>

    <link rel="stylesheet" href="<?php echo base_url('assets/css/login-new.css') ?>" media="screen">
</head>

<body>
    <div id="loginform">
        <a href="<?php echo site_url('first') ?>">
            <div id="facebook">
                <div id="sid">SID</div>
                <div id="connect">ver.</div>
                <div id="logo"><img src="<?php echo base_url('assets/images/SID-e1351656852451.png') ?>"></div>
                <div id="desa">Desa <?php echo unpenetration($desa['nama_desa']) ?></div>
                <div id="kec">Kecamatan <?php echo unpenetration($desa['nama_kecamatan']) ?></div>
                <div id="kab">Kabupaten <?php echo unpenetration($desa['nama_kabupaten']) ?></div>
            </div>
        </a>
        <div id="mainlogin">
            <div id="or"><?= VERSI_SID ?></div>
            <h1>Masukkan Username dan Password</h1>
            <?= form_open(route_to('login.auth')) ?>
            <?= form_input([
                'name'        => 'username',
                'required'    => true,
                'placeholder' => 'username',
            ]) ?>
            <?= form_password([
                'name'        => 'password',
                'required'    => true,
                'placeholder' => 'password',
            ]) ?>
            <?= form_button([
                'content' => 'Login',
                'type'    => 'submit',
            ]) ?>

            <?php if(session()->has('alert')) : ?>
                <div id="note">
                    <?= esc(session()->get('alert')) ?>
                </div>
            <?php endif ?>

            <?= form_close() ?>
        </div>
        <div id="facebook2">
            <div id="kab2">
                <a href="http://combine.or.id" target="_blank" rel="nofollow">
                    <img align=center src="<?php echo base_url('assets/images/logo-combine.png') ?>" alt="">
                </a>
            </div>
        </div>
    </div>
</body>

</html>
