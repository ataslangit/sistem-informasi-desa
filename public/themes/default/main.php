<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div id="contentwrapper">
    <div id="contentcolumn">
        <div class="innertube">

            <div class="box box-primary" style="margin-left:.2	5em;">
                <div class="box-header with-border">
                    <h3 class="box-title">Artikel Terkini</h3>
                </div>
                <div class="box-body">

                    <div>
                        <ul class="artikel-list artikel-list-in-box">
                            <?php foreach ($artikel as $pos) { ?>
                                <li class="artikel">
                                    <h3 class="judul">
                                        <?= permalink($pos, '', true) ?>
                                    </h3>

                                    <div class="teks" style="text-align:justify;">
                                        <div class="kecil"><i class="fa fa-clock-o"></i> <?= esc($pos['tgl_upload']) ?> <i class="fa fa-user"></i> ahmad riyantono</div>
                                        <div class="img">
                                            <img src="<?= assets('assets/files/artikel/' . $pos['gambar'], false) ?>" alt="<?= esc($pos['judul']) ?>" />
                                        </div>
                                        <p><?= snippet($pos) ?> <?= permalink($pos, 'selengkapnya...', true) ?></p>
                                    </div>
                                    <br class="clearboth gb" />
                                </li>

                            <?php } ?>
                        </ul>
                    </div>

                </div>
                <div class="box-footer">
                    <?= $pagination ?>
                </div>

            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
