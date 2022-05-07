<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div id="contentwrapper">
    <div id="contentcolumn">
        <div class="innertube">

            <div class="artikel" id="pos-<?= esc($artikel['id']) ?>">
                <h2 class="judul"><?= esc($artikel['judul']) ?></h2>
                <h3 class="kecil"><i class="fa fa-user"></i> ahmad riyantono <i class="fa fa-clock-o"></i> 28 April 2022 12:26:05 WIB</h3>
                <div class="sampul">
                    <a class="group2 cboxElement" href="https://sukoharjosid.slemankab.go.id/assets/files/artikel/sedang_1651124142IMG20220426110019.jpg" title="">
                        <img src="https://sukoharjosid.slemankab.go.id/assets/files/artikel/kecil_1651124142IMG20220426110019.jpg">
                    </a>
                </div>
                <div class="teks" style="text-align:justify;">

                    <?= $artikel['isi'] ?>
                </div>
                <div class="sampul2"><a class="group2 cboxElement" href="https://sukoharjosid.slemankab.go.id/assets/files/artikel/sedang_1651124142WhatsApp Image 2022-04-28 at 12.00.47.jpeg" title="">
                        <img src="https://sukoharjosid.slemankab.go.id/assets/files/artikel/kecil_1651124142WhatsApp Image 2022-04-28 at 12.00.47.jpeg"></a></div>
                <div class="form-group" style="clear:both;">
                    <ul id="pageshare" title="bagikan ke teman anda" class="pagination">

                        <li class="sbutton" id="FB.Share" name="FB.Share"><a target="_blank" href="http://www.facebook.com/sharer.php?s=100&amp;p[title]=KALURAHAN+SUKOHARJO+GELAR+PEMBINAAN+KELEMBAGAAN&amp;p[summary]=KALURAHAN+SUKOHARJO+GELAR+PEMBINAAN+KELEMBAGAAN&amp;p[url]=https%3A%2F%2Fsukoharjosid.slemankab.go.id%2Ffirst%2Fartikel%2F84-KALURAHAN-SUKOHARJO-GELAR-PEMBINAAN-KELEMBAGAAN&amp;p[images][0]=https://sukoharjosid.slemankab.go.id/assets/files/artikel/sedang_1651124142IMG20220426110019.jpg">share on FB</a></li>

                        <li class="sbutton" id="rt"><a target="_blank" href="http://twitter.com/share" class="twitter-share-button">Tweet</a></li>
                    </ul>


                </div>
                <div class="form-group">
                    <div>Belum ada komentar atas artikel ini, silakan tuliskan dalam formulir berikut ini</div>
                </div>
                <div class="form-group">
                    <div class="box box-default">
                        <div class="box-header">
                            <h3 class="box-title">Formulir Penulisan Komentar</h3>
                        </div>
                        <div class="box-body">
                            <form name="form" action="https://sukoharjosid.slemankab.go.id/first/add_comment/84" method="POST" onsubmit="return validasi(this)">
                                <table width="100%">
                                    <tbody>
                                        <tr class="komentar">
                                            <td>Nama</td>
                                            <td> <input type="text" name="owner" size="20" maxlength="30"></td>
                                        </tr>
                                        <tr class="komentar">
                                            <td>Alamat e-mail</td>
                                            <td> <input type="text" name="email" size="20" maxlength="30"></td>
                                        </tr>
                                        <tr class="komentar">
                                            <td valign="top">Komentar</td>
                                            <td> <textarea name="komentar" style="width: 300px; height: 100px;"></textarea></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td><input class="btn" type="submit" value="Kirim"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection() ?>
