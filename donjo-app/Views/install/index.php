<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="container-xl">
    <div class="d-flex align-items-center w-100">
    <div class="m-auto">
        <div class="card">
            <h4>Klik “Lanjut” untuks memulai proses instalasi database SID. Proses instalasi memerlukan waktu singkat. Setelah selesai, Anda akan mendapatkan “username” dan “password”. Catat/simpan “username” dan “password” sebelum meneruskan ke langkah selanjutnya.</h4><br>
            <a href="<?php echo site_url('main/install') ?>" class="uibutton special">Lanjut</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
    </div>
    </div>
</div>

<?= $this->endSection() ?>
