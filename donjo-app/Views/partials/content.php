<?php if ($headline) : ?>
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">
                <a href="<?= site_url("first/artikel/{$headline['id']}") ?>"><?= esc($headline['judul']) ?></a>
            </h3>
            <div class="pull-right small"><?= esc($headline['owner'] ?? '') ?>, <?= tgl_indo2($headline['tgl_upload']) ?></div>
        </div>
        <div class="box-body" style="text-align:justify;">
            <?php if ($headline["gambar"] != "") : ?>
                <?php if (is_file("assets/files/artikel/sedang_" . $headline['gambar'])) : ?>
                    <a class="group2" href="<?= base_url('assets/files/artikel/sedang_' . $headline['gambar']) ?>" title="">
                        <img width="600" src="<?= base_url("assets/files/artikel/sedang_" . $headline['gambar']) ?>"></a>
                <?php else : ?>
                    <img style="margin-right: 10px; margin-bottom: 5px; float: left;" src="<?= base_url('assets/images/404-image-not-found.jpg') ?>" width="300" height="180">

                <?php endif ?>
            <?php endif ?>
            <?php $head = explode("</p>", $headline['isi']); ?>
            <?= $head[0] . "</p>" ?>
        </div>
    </div>
<?php endif ?>

<?php
$title = (!empty($judul_kategori)) ? $judul_kategori : "Artikel Terkini";
if (is_array($title)) {
    foreach ($title as $item) {
        $title = $item;
    }
}
?>
<div class="box box-primary" style="margin-left:.2	5em;">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $title ?></h3>
    </div>
    <div class="box-body">
        <?php if ($artikel) : ?>
            <div>
                <ul class="artikel-list artikel-list-in-box">
                    <?php foreach ($artikel as $data) : ?>
                        <?php
                        $teks = fixTag($data['isi']);
                        if (strlen($teks) > 310) {
                            $abstrak = substr($teks, 0, strpos($teks, " ", 300));
                        } else {
                            $abstrak = $teks;
                        }
                        ?>
                        <li class="artikel">
                            <h3 class="judul">
                                <a href="<?= site_url("first/artikel/{$data['id']}") ?>"><?= esc($data["judul"]) ?></a>
                            </h3>

                            <div class="teks" style="text-align:justify;">
                                <div class="kecil"><i class="fa fa-clock-o"></i> <?= tgl_indo2($data['tgl_upload']) ?> <i class="fa fa-user"></i> <?= $data['owner'] ?? '' ?></div>
                                <div class="img">
                                    <?php if ($data['gambar'] != '') : ?>
                                        <?php if (is_file("assets/files/artikel/kecil_" . $data['gambar'])) : ?>
                                            <img src="<?= base_url("assets/files/artikel/kecil_" . $data['gambar']) ?>" alt="<?= esc($data["judul"]) ?>">
                                        <?php else : ?>
                                            <img src="<?= base_url('assets/images/404-image-not-found.jpg') ?>" alt="<?= esc($data["judul"]) ?>">
                                        <?php endif ?>
                                    <?php endif ?>
                                </div>
                                <?= $abstrak ?> <a href="<?= site_url("first/artikel/" . $data["id"]) ?>">..selengkapnya</a>
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
                        <p>Belum ada artikel yang dituliskan dalam " . $title . ".</p>
                        <p>Silakan kunjungi situs web kami dalam waktu dekat.</p>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
    <?= $paging->links() ?>

</div>
