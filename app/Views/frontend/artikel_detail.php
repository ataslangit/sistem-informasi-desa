<?= $this->extend('template/main') ?>

<?= $this->section('content') ?>
<div id="contentwrapper">
    <div id="contentcolumn">
        <div class="innertube">
            <div class="artikel" id="artikel-<?= esc($artikel->id) ?>">
                <h2 class="judul"><?= esc($artikel->judul) ?></h2>
                <h3 class="kecil">
                    <i class="fa fa-user"></i> <?= esc($artikel->nama ?? $artikel->username) ?>
                    <i class="fa fa-clock-o"></i> <?= tanggal($artikel->tgl_upload) ?>
                </h3>
                <?php
                if ($artikel->gambar !== '') {
                    if (is_file('assets/files/artikel/kecil_' . $artikel->gambar)) {
                        echo '<div class="sampul"><a class="group2" href="' . base_url() . '/assets/files/artikel/sedang_' . $artikel->gambar . '" title="">
                                <img src="' . base_url() . '/assets/files/artikel/kecil_' . $artikel->gambar . '" /></a></div>';
                    }
                }
                ?>
                <div class="teks" style="text-align:justify;">
                    <?= $artikel->isi ?>
                </div>

                <?php
                if ($artikel->dokumen !== '') {
                    if (is_file('assets/files/dokumen/' . $artikel->dokumen)) {
                        echo '<p>Dokumen Lampiran : <a target="_blank" href="' . base_url() . '/assets/files/dokumen/' . $artikel->dokumen . '" title="">' . $artikel->link_dokumen . '</a></p><br/>';
                    }
                }
                if ($artikel->gambar1 !== '') {
                    if (is_file('assets/files/artikel/kecil_' . $artikel->gambar1)) {
                        echo '<div class="sampul2"><a class="group2" href="' . base_url() . '/assets/files/artikel/sedang_' . $artikel->gambar1 . '" title="">
                                <img src="' . base_url() . '/assets/files/artikel/kecil_' . $artikel->gambar1 . '" /></a></div>';
                    }
                }
                if ($artikel->gambar2 !== '') {
                    if (is_file('assets/files/artikel/kecil_' . $artikel->gambar2)) {
                        echo '<div class="sampul2"><a class="group2" href="' . base_url() . '/assets/files/artikel/sedang_' . $artikel->gambar2 . '" title="">
                                <img src="' . base_url() . '/assets/files/artikel/kecil_' . $artikel->gambar2 . '" /></a></div>';
                    }
                }
                if ($artikel->gambar3 !== '') {
                    if (is_file('assets/files/artikel/kecil_' . $artikel->gambar3)) {
                        echo '<div class="sampul2"><a class="group2" href="' . base_url() . '/assets/files/artikel/sedang_' . $artikel->gambar3 . '" title="">
                                <img src="' . base_url() . '/assets/files/artikel/kecil_' . $artikel->gambar3 . '" /></a></div>';
                    }
                }
                ?>

                <?= $this->include('frontend/komponen_bagikan_artikel') ?>

                <?= $this->include('frontend/komponen_komentar_artikel'); ?>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
