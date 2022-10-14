<?= $this->extend('template/main') ?>

<?= $this->section('content') ?>
<div id="contentwrapper">
    <div id="contentcolumn">
        <div class="innertube">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title"><a href="<?= site_url() ?>first/artikel/34">Presiden RI Kunjungi Desa Bumi Pertiwi</a></h3>
                    <div class="pull-right small">, 01 Februari 2017 08:32:26 WIB</div>
                </div>
                <div class="box-body" style="text-align:justify;">
                    <a class="group2" href="<?= site_url() ?>assets/files/artikel/sedang_14859379462017 02 - Contoh Foto SID 3.10.jpg" title="">
                        <img width="600" src="<?= site_url() ?>assets/files/artikel/sedang_14859379462017 02 - Contoh Foto SID 3.10.jpg" /></a>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris est laborum.</p>
                </div>
            </div>
            <div class="box box-primary" style="margin-left:.2	5em;">
                <div class="box-header with-border">
                    <h3 class="box-title">Artikel Terkini</h3>
                </div>
                <div class="box-body">
                    <div>
                        <ul class="artikel-list artikel-list-in-box">
                            <?php foreach ($artikel as $i => $pos) : ?>
                                <li class="artikel">
                                    <h3 class="judul">
                                        <?= anchor(linkArtikel($pos->id, $pos->judul), esc($pos->judul)) ?>
                                    </h3>

                                    <div class="teks" style="text-align:justify;">
                                        <div class="kecil">
                                            <i class="fa fa-clock-o"></i> <?= tanggal($pos->tgl_upload) ?>
                                        </div>
                                        <div class="img">
                                            <img src="<?= site_url() ?>assets/files/artikel/kecil_14864642872017 02 - Contoh Foto SID 3.10 c.jpg" alt="PKK Desa Bumi Pertiwi Raih Juara 1 Tingkat Kabupaten">
                                        </div>
                                        <?= character_limiter(strip_tags($pos->isi), 300) ?>
                                    </div>
                                    <br class="clearboth gb" />
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>

                </div>
                <?= $pager->links() ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
