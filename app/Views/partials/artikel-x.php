<?php if ($single_artikel['id']) { ?>
    <div class="themes bigfull">
        <div class='title'>
            <h2><a href="#"><?= $single_artikel['judul'] ?></a></h2>
        </div>
        <div class='entry'>
            <p>
                <?php if ($single_artikel['gambar'] !== '') { ?>
                    <?php if (is_file('assets/files/artikel/kecil_' . $single_artikel['gambar'])) { ?>
                        <a class="group2" href="<?= base_url(); ?>assets/files/artikel/sedang_<?= $single_artikel['gambar'] ?>" title="<?= $single_artikel['judul'] ?>"><img style="margin-right: 10px; margin-bottom: 5px; float: left;" src="<?= base_url(); ?>assets/files/artikel/kecil_<?= $single_artikel['gambar'] ?>" /></a>
                    <?php } else { ?>
                        <img style="margin-right: 10px; margin-bottom: 5px; float: left;" src="<?= base_url(); ?>assets/images/404-image-not-found.jpg" />
                    <?php } ?>
                <?php } ?>
                <?= $single_artikel['isi'] ?>
            </p>
        </div>
        <div class="entry" style="display:block;">
            <?php if ($single_artikel['gambar1'] !== '') { ?>
                <?php if (is_file('assets/files/artikel/kecil_' . $single_artikel['gambar1'])) { ?>
                    <a class="group2" href="<?= base_url(); ?>assets/files/artikel/sedang_<?= $single_artikel['gambar1'] ?>" title="<?= $single_artikel['judul'] ?>"><img style="margin-right: 10px; margin-bottom: 5px; float: left;" src="<?= base_url(); ?>assets/files/artikel/kecil_<?= $single_artikel['gambar1'] ?>" /></a>
                <?php } else { ?>
                    <img style="margin-right: 10px; margin-bottom: 5px; float: left;" src="<?= base_url(); ?>assets/images/404-image-not-found.jpg" />
                <?php } ?>
            <?php } ?>
            <?php if ($single_artikel['gambar2'] !== '') { ?>
                <?php if (is_file('assets/files/artikel/kecil_' . $single_artikel['gambar2'])) { ?>
                    <a class="group2" href="<?= base_url(); ?>assets/files/artikel/sedang_<?= $single_artikel['gambar2'] ?>" title="<?= $single_artikel['judul'] ?>"><img style="margin-right: 10px; margin-bottom: 5px; float: left;" src="<?= base_url(); ?>assets/files/artikel/kecil_<?= $single_artikel['gambar2'] ?>" /></a>
                <?php } else { ?>
                    <img style="margin-right: 10px; margin-bottom: 5px; float: left;" src="<?= base_url(); ?>assets/images/404-image-not-found.jpg" />
                <?php } ?>
            <?php } ?>
            <?php if ($single_artikel['gambar3'] !== '') { ?>
                <?php if (is_file('assets/files/artikel/kecil_' . $single_artikel['gambar3'])) { ?>
                    <a class="group2" href="<?= base_url(); ?>assets/files/artikel/sedang_<?= $single_artikel['gambar3'] ?>" title="<?= $single_artikel['judul'] ?>"><img style="margin-right: 10px; margin-bottom: 5px; float: left;" src="<?= base_url(); ?>assets/files/artikel/kecil_<?= $single_artikel['gambar3'] ?>" /></a>
                <?php } else { ?>
                    <img style="margin-right: 10px; margin-bottom: 5px; float: left;" src="<?= base_url(); ?>assets/images/404-image-not-found.jpg" />
                <?php } ?>
            <?php } ?>
            <?php if (isset($single_artikel['dokumen'])) {
                if ($single_artikel['dokumen'] !== '') { ?>
                    <?php if (is_file('assets/files/dokumen/' . $single_artikel['dokumen'])) { ?>
                        <a href="<?= base_url(); ?>assets/files/dokumen/<?= $single_artikel['dokumen'] ?>"><?= $single_artikel['link_dokumen'] ?></a>
                    <?php } ?>
            <?php }
                } ?>
        </div>
        <div class="art-spacer" style="display:block;clear:both;">
            Ditulis oleh: <b><?= $single_artikel['owner'] ?><br></b>
            <small>Pada: <?= tanggal($single_artikel['tgl_upload']) ?></small>
        </div>
        <style>
            #pageshare {
                float: left;
                padding: 0 0 0px 0;
                z-index: 10;
            }

            #pageshare .sbutton {
                float: left;
                margin: 0px 4px;
            }
        </style>
        <div id='pageshare' title="bagikan ke teman anda">
            <div class='sbutton' id='fb'><a name="fb_share" href="http://www.facebook.com/sharer.php?u='<?= site_url(); ?>first/artikel/<?= $single_artikel['id'] ?>'">Share</a>
                <script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
            </div>
            <div class='sbutton' id='rt'><a href="http://twitter.com/share" class="twitter-share-button">Tweet</a>
                <script src='http://platform.twitter.com/widgets.js' type="text/javascript"></script>
            </div>
        </div>
        </br>&nbsp;
        </br>
        <div style="clear:both;">
            <h3>Komentar Artikel Terkait</h3>
            <?php foreach ($komentar as $data) { ?>
                <?php if ($data['enabled'] === 1) { ?>
                    <div class="kom-box">
                        <span class="post-title">
                            <b><?= $data['owner'] ?><br></b>
                            <small><?= tanggal($data['tgl_upload']) ?></small>
                            <p><b>Berkata: </b><?= $data['komentar'] ?>
                            </p>
                        </span>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="themes comments">
            <h3>Post Komentar :</h3>
            <br />
            <table width=100%>
                <?= form_open_multipart('first/add_comment/' . $single_artikel['id'], ['name' => 'form', 'onSubmit' => 'return validasi(this)']) ?>
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
                        <td> <textarea name="komentar" style='width: 300px; height: 100px;'></textarea></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" value="Kirim"></td>
                    </tr>
                <?= form_close() ?>
            </table><br />
        </div>
        <input type="button" value="Kembali" onclick="self.history.back()">
    </div>
<?php } ?>
