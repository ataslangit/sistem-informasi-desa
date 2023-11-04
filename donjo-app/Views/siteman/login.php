<?= $this->extend('siteman/template') ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= asset('resources/css/login.scss')?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div id="loginform">
        <a href="<?php echo site_url('first')?>">
            <div id="facebook">
                <div id="sid">SID</div>
                <div id="connect">ver.</div>
                <div id="logo"><img src="<?php echo base_url('assets/images/SID-e1351656852451.png')?>"></div>
                <div id="desa">Desa <?php echo unpenetration($desa['nama_desa'])?></div>
                <div id="kec">Kecamatan <?php echo unpenetration($desa['nama_kecamatan'])?></div>
                <div id="kab">Kabupaten <?php echo unpenetration($desa['nama_kabupaten'])?></div>
            </div>
        </a>
        <div id="mainlogin">
            <div id="or"><?= VERSI_SID ?></div>
            <h1>Masukkan Username dan Password</h1>
            <?= form_open(route_to('login.submit')) ?>
                <input name="username" type="text" placeholder="username" value="" required>
                <input name="password" type="password" placeholder="password" value="" required>
                <button type="submit" id="but">LOGIN</button>

                <?php if(session()->has('error')) {
                    echo '<div id="note">';
                    echo session()->get('error');
                    echo '</div>';
                } ?>
            <?= form_close() ?>
        </div>
        <div id="facebook2">
            <div id="kab2"><a href="http://combine.or.id" target="_blank"><img align=center src="<?php echo base_url('assets/images/logo-combine.png') ?>"></a></div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<?= $this->endSection() ?>
