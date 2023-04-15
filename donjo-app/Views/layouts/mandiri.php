<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

    <?php
        if($m==1){
            echo $this->include('partials/mandiri');
       } elseif($m==2){
            echo $this->include('partials/layanan');
        }else{
            echo $this->include('partials/lapor');
        }
    ?>

<?= $this->endSection() ?>
