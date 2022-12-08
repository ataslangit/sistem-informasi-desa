        <?php view('layouts/header') ?>
        <div id="contentwrapper">
                <div class="innertube">
                    <div class="artikel">
                        <div class="box box-danger box-solid">
                            <div class="box-header">
                                <h3 class="box-title">Maaf, data tidak ditemukan</h3>
                            </div>
                            <div class="box-body">
                                Anda telah terdampar di halaman yang datanya tidak ada lagi di web ini.
                                Mohon periksa kembali atau laporkan kepada kami.<br>
                                Silakan kunjungi halaman depan <a href="<?= site_url('first') ?>"><?= base_url() ?></a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div id="footer">
            <?php view('partials/copywright.tpl.php') ?>
        </div>
    </div>
</body>

</html>
