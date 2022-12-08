<?php if ($headline) : ?>
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title"><a href="<?= site_url("first/artikel/" . $headline['id'] . '/' . url_title($headline['judul'], '-', true)) ?>"><?= esc($headline['judul']) ?></a></h3>
            <div class="pull-right small"><?= esc($headline['owner'] . ', ' . tgl_indo2($headline['tgl_upload'])) ?></div>
        </div>
        <div class="box-body" style="text-align:justify;">
            <?php if ($headline['gambar'] !== '') :  ?>
                <?php if (is_file('assets/files/artikel/sedang_' . $headline['gambar'])) : ?>
                    <a class="group2" href="<?= base_url('assets/files/artikel/sedang_' . $headline['gambar']) ?>" title="">
                        <img width="600" src="<?= base_url('assets/files/artikel/sedang_' . $headline['gambar']) ?>"></a>
                <?php else : ?>
                    <img style="margin-right: 10px; margin-bottom: 5px; float: left;" src="<?= base_url('assets/images/404-image-not-found.jpg') ?>" width="300" height="180">
                <?php endif ?>
            <?php endif ?>

            <?php
            $head = explode('</p>', $headline['isi']);
            echo esc($head[0]) . '</p>';
            ?>

        </div>
    </div>
<?php endif ?>

<?php
$title = (! empty($judul_kategori)) ? $judul_kategori : 'Artikel Terkini';
if (is_array($title)) {
    foreach ($title as $item) {
        $title = $item;
    }
}
?>
<div class="box box-primary" style="margin-left:.2	5em;">
    <div class="box-header with-border">
        <h3 class="box-title"><?= esc($title) ?></h3>
    </div>
    <div class="box-body">
        <?php if ($artikel) : ?>
            <div>
                <ul class="artikel-list artikel-list-in-box">
                    <?php foreach ($artikel as $data) : ?>
                        <?php
                        $teks  = fixTag($data['isi']);
                        $title_link = url_title($data['judul'], '-', true);
                        ?>

                        <li class="artikel">
                            <h3 class="judul"><a href="<?= site_url("first/artikel/" . $data['id'] . '/' . $title_link) ?>"><?= esc($data['judul']) ?></a></h3>

                            <div class="teks" style="text-align:justify;">
                                <div class="kecil"><i class="fa fa-clock-o"></i> <?= tgl_indo2($data['tgl_upload']) ?> <i class="fa fa-user"></i> <?= $data['owner'] ?></div>
                                <div class="img">
                                    <?php if ($data['gambar'] !== '') : ?>
                                        <?php if (is_file('assets/files/artikel/kecil_' . $data['gambar'])) : ?>
                                            <img src="<?= base_url('assets/files/artikel/kecil_' . $data['gambar']) ?>" alt="<?= esc($data['judul']) ?>">
                                        <?php else : ?>
                                            <img src="<?= base_url('assets/images/404-image-not-found.jpg') ?>" alt="<?= esc($data['judul']) ?>">
                                        <?php endif ?>
                                    <?php endif ?>
                                </div>

                                <?= esc(character_limiter($teks, 300)) ?>
                                <a href="<?= site_url('first/artikel/' . $data['id'] . '/' . $title_link) ?>">..selengkapnya</a>
                            </div>
                            <br class="clearboth gb">
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php else : ?>
            <div class="artikel" id="artikel-blank">
                <div class="box box-warning box-solid">
                    <div class="box-header">
                        <h3 class="box-title">Maaf, belum ada data</h3>
                    </div>
                    <div class="box-body">
                        <p>Belum ada artikel yang dituliskan dalam <?= esc($title) ?>.</p>
                        <p>Silakan kunjungi situs web kami dalam waktu dekat.</p>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
    <?php if ($artikel) : ?>
        <div class="box-footer">
            <ul class="pagination pagination-sm no-margin">
                <?php if ($paging->start_link) : ?>
                    <li><a href="<?= site_url("first/index/{$paging->start_link}") ?>" title="Halaman Pertama"><i class="fa fa-fast-backward"></i>&nbsp;</a></li>
                <?php endif ?>
                <?php if ($paging->prev) : ?>
                    <li><a href="<?= site_url("first/index/{$paging->prev}") ?>" title="Halaman Sebelumnya"><i class="fa fa-backward"></i>&nbsp;</a></li>
                <?php endif ?>

                <?php for ($i = $paging->start_link; $i <= $paging->end_link; $i++) : ?>
                    <?php
                    $strC = ($p === $i) ? 'class="active"' : '';
                    ?>
                    <li <?= $strC ?>><a href="<?= site_url("first/index/{$i}") ?>" title="Halaman <?= $i ?>"><?= esc($i) ?></a></li>
                <?php endfor ?>

                <?php if ($paging->next) : ?>
                    <li><a href="<?= site_url("first/index/{$paging->next}") ?>" title="Halaman Selanjutnya"><i class="fa fa-forward"></i>&nbsp;</a></li>
                <?php endif ?>

                <?php if ($paging->end_link) : ?>
                    <li><a href="<?= site_url("first/index/{$paging->end_link}") ?>" title="Halaman Terakhir"><i class="fa fa-fast-forward"></i>&nbsp;</a></li>
                <?php endif ?>

            </ul>
        </div>
    <?php endif ?>
</div>
