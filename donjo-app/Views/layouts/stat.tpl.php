<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

    <?php
    if($tipe == 2){
        if($tipex==1){
            echo $this->include('partials/statistik_sos');
        }elseif($tipex==3){
            echo $this->include('partials/statistik_ras');
        }else{
            echo $this->include('partials/statistik_jam');
        }
    }elseif($tipe == 3){
        echo $this->include('partials/wilayah');
    }else{
        echo $this->include('partials/statistik');
    }
    ?>

<?= $this->endSection() ?>
