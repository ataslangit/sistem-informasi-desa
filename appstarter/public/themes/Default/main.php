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
                                        <?= anchor(! isset($pos['slug']) ? '?p=' . $pos['id'] : makeUrl($pos['tgl_upload'], $pos['slug']), esc($pos['judul'])) ?>
                                    </h3>

                                    <div class="teks" style="text-align:justify;">
                                        <div class="kecil"><i class="fa fa-clock-o"></i> <?= esc($pos['tgl_upload']) ?> <i class="fa fa-user"></i> ahmad riyantono</div>
                                        <div class="img">
                                            <img src="<?= assets('assets/files/artikel/' . $pos['gambar'], false) ?>" alt="<?= esc($pos['judul']) ?>" />
                                        </div>
                                        <p><?= character_limiter(strip_tags($pos['isi'], ['strong', 'b', 'i']), 300) ?></p>
                                    </div>
                                    <br class="clearboth gb" />
                                </li>

                            <?php } ?>
                        </ul>
                    </div>

                </div>
                <div class="box-footer">
                    <ul class="pagination pagination-sm no-margin">
                        <li><a href="https://sukoharjosid.slemankab.go.id/first/index/1" title="Halaman Pertama"><i class="fa fa-fast-backward"></i>&nbsp;</a></li>
                        <li class="active"><a href="https://sukoharjosid.slemankab.go.id/first/index/1" title="Halaman 1">1</a></li>
                        <li><a href="https://sukoharjosid.slemankab.go.id/first/index/2" title="Halaman 2">2</a></li>
                        <li><a href="https://sukoharjosid.slemankab.go.id/first/index/3" title="Halaman 3">3</a></li>
                        <li><a href="https://sukoharjosid.slemankab.go.id/first/index/4" title="Halaman 4">4</a></li>
                        <li><a href="https://sukoharjosid.slemankab.go.id/first/index/5" title="Halaman 5">5</a></li>
                        <li><a href="https://sukoharjosid.slemankab.go.id/first/index/6" title="Halaman 6">6</a></li>
                        <li><a href="https://sukoharjosid.slemankab.go.id/first/index/7" title="Halaman 7">7</a></li>
                        <li><a href="https://sukoharjosid.slemankab.go.id/first/index/2" title="Halaman Selanjutnya"><i class="fa fa-forward"></i>&nbsp;</a></li>
                        <li><a href="https://sukoharjosid.slemankab.go.id/first/index/7" title="Halaman Terakhir"><i class="fa fa-fast-forward"></i>&nbsp;</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
