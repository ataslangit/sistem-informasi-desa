<div class="artikel" id="artikel-<?= esc($single_artikel['id']) ?>">
    <h2 class="judul"><?= esc($single_artikel['judul']) ?></h2>
    <h3 class="kecil">
        <i class="fa fa-user"></i> <?= $single_artikel['owner'] ?> &nbsp;
        <i class="fa fa-clock-o"></i> <?= tgl_indo2($single_artikel['tgl_upload']) ?>
    </h3>

    <?php if ($single_artikel['gambar'] !== '') : ?>
        <?php if (is_file('assets/files/artikel/kecil_' . $single_artikel['gambar'])) : ?>
            <div class="sampul">
                <a class="group2" href="<?= base_url('assets/files/artikel/sedang_' . $single_artikel['gambar']) ?>" title="">
                    <img src="<?= base_url('assets/files/artikel/kecil_' . $single_artikel['gambar']) ?>">
                </a>
            </div>
        <?php endif ?>
    <?php endif ?>

    <div class="teks" style="text-align:justify;"><?= $single_artikel['isi'] ?></div>

    <?php if ($single_artikel['dokumen'] !== '') : ?>
        <?php if (is_file('assets/files/dokumen/' . $single_artikel['dokumen'])) : ?>
            <p>
                Dokumen Lampiran :
                <a target="_blank" href="<?= base_url('assets/files/dokumen/' . $single_artikel['dokumen']) ?>" title="">
                    <?= $single_artikel['link_dokumen'] ?>
                </a>
            </p>
            <br>
        <?php endif ?>
    <?php endif ?>

    <?php if ($single_artikel['gambar1'] !== '') : ?>
        <?php if (is_file('assets/files/artikel/kecil_' . $single_artikel['gambar1'])) : ?>
            <div class="sampul2">
                <a class="group2" href="<?= base_url('assets/files/artikel/sedang_' . $single_artikel['gambar1']) ?>" title="">
                    <img src="<?= base_url('assets/files/artikel/kecil_' . $single_artikel['gambar1']) ?>">
                </a>
            </div>
        <?php endif ?>
    <?php endif ?>

    <?php if ($single_artikel['gambar2'] !== '') : ?>
        <?php if (is_file('assets/files/artikel/kecil_' . $single_artikel['gambar2'])) : ?>
            <div class="sampul2">
                <a class="group2" href="<?= base_url('assets/files/artikel/sedang_' . $single_artikel['gambar2']) ?>" title="">
                    <img src="<?= base_url('assets/files/artikel/kecil_' . $single_artikel['gambar2']) ?>">
                </a>
            </div>";
        <?php endif ?>
    <?php endif ?>

    <?php if ($single_artikel['gambar3'] !== '') : ?>
        <?php if (is_file('assets/files/artikel/kecil_' . $single_artikel['gambar3'])) : ?>
            <div class="sampul2">
                <a class="group2" href="<?= base_url('assets/files/artikel/sedang_' . $single_artikel['gambar3']) ?>" title="">
                    <img src="<?= base_url('assets/files/artikel/kecil_' . $single_artikel['gambar3']) ?>">
                </a>
            </div>";
        <?php endif ?>
    <?php endif ?>

    <div class="form-group" style="clear:both;">
        <ul id="pageshare" title="bagikan ke teman anda" class="pagination">

            <?php
            if (isset($single_artikel['gambar'])) {
                $gambar = $single_artikel['gambar'];
            } elseif (isset($single_artikel['gambar1'])) {
                $gambar = $single_artikel['gambar1'];
            } elseif (isset($single_artikel['gambar2'])) {
                $gambar = $single_artikel['gambar2'];
            } elseif (isset($single_artikel['gambar3'])) {
                $gambar = $single_artikel['gambar4'];
            }
            ?>
            <li class="sbutton" id="FB.Share" name="FB.Share">
                <a target="_blank" href="https://www.facebook.com/sharer.php?s=100&amp;p[title]=<?= urlencode($single_artikel['judul']); ?>&amp;p[summary]=<?= urlencode($single_artikel['judul']) ?>&amp;p[url]=<?= urlencode(current_url()); ?>&amp;p[images][0]=<?= urlencode(base_url('assets/files/artikel/kecil_' . $gambar)); ?>">
                    share on FB
                </a>
            </li>
            <li class="sbutton" id="rt">
                <a target="_blank" href="http://twitter.com/share" class="twitter-share-button">
                    Tweet
                </a>
            </li>
        </ul>

    </div>
    <div class="form-group">
        <?php if (is_array($komentar)) : ?>
            <div class="box box-default box-solid">
                <div class="box-header">
                    <h3 class="box-title">Komentar atas <?= esc($single_artikel['judul']) ?></h3>
                </div>
                <div class="box-body">

                    <?php foreach ($komentar as $data) : ?>
                        <?php if ($data['enabled'] === '1') : ?>

                            <div class="kom-box">
                                <div style="font-size:.8em;font-color:#aaa;">
                                    <i class="fa fa-user"></i> <?= esc($data['owner']) ?> &nbsp;
                                    <i class="fa fa-clock-o"></i> <?= esc(tgl_indo2($data['tgl_upload'])) ?>
                                </div>
                                <div>
                                    <blockquote><?= esc($data['komentar']) ?></blockquote>
                                </div>
                            </div>";
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
            </div>
        <?php else : ?>
            <div>Belum ada komentar atas artikel ini, silakan tuliskan dalam formulir berikut ini</div>
        <?php endif ?>

    </div>
    <div class="form-group">
        <div class="box box-default">
            <div class="box-header">
                <h3 class="box-title">Formulir Penulisan Komentar</h3>
            </div>
            <div class="box-body">
                <form name="form" action="<?= site_url('first/add_comment/' . $single_artikel['id']) ?>" method=POST onSubmit="return validasi(this)">
                    <table width=100%>
                        <tr class="komentar">
                            <td>Nama</td>
                            <td> <input type=text name="owner" size=20 maxlength=30></td>
                        </tr>
                        <tr class="komentar">
                            <td>Alamat e-mail</td>
                            <td> <input type=text name="email" size=20 maxlength=30></td>
                        </tr>
                        <tr class="komentar">
                            <td valign=top>Komentar</td>
                            <td> <textarea name="komentar" style="width: 300px; height: 100px;"></textarea></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><input type="submit" value="Kirim"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
