<script>
    $(function() {
        var nik = {};
        nik.results = [
            <?php foreach ($menu_surat2 as $data) { ?> {
                    id: '<?= $data['url_surat'] ?>',
                    name: "<?= strtoupper($data['nama']) ?>",
                    info: "<?= $data['url_surat']; ?>"
                },
            <?php } ?>
        ];
        $('#nik').flexbox(nik, {
            resultTemplate: '<div><label style="font-size:14px;">{name}</label></div><div style="font-size:12px;">{info}</div>',
            watermark: 'TULIS JUDUL SURAT',
            width: 360,
            noResultsText: 'Tidak ada surat yang sesuai..',
            onSelect: function() {
                $('#' + 'main').submit();
            }
        });
    });
</script>
<div id="pageC">
    <div id="contentpane">
        <div class="ui-layout-north panel">
        </div>
        <div class="ui-layout-center" id="maincontent" style="padding: 10px;">
            <div>
                <h3>Menu Cepat Pencarian / Cetak Layanan Surat<h3>
                        <form action="<?= site_url() ?>surat/search" id="main" name="main" method="POST">
                            <div id="nik" name="nik"></div>
                        </form>

                        <hr>
                        <br>
            </div>
            <div>
                <h3>Layanan Surat Administrasi Kependudukan</h3>
                <div>
                    <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                        <div class="teks">
                            <p>Jenis-jenis surat dapat diubah, ditambah, atau dikurangi dengan menggunakan fungsi pengaturan di Menu Master Surat.<br /></p>
                            <?php foreach ($surat_favorit as $data) { ?>
                                <a class="csurat" href="<?= site_url() ?>surat/form/<?= $data['url_surat'] ?>">
                                    <img src="<?= base_url() ?>assets/images/cpanel/edit-select-all-1.png" />
                                    <span><?= strtoupper($data['nama']) ?></span>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <div style="clear: both;">
                        <hr>
                        <br>
                        <div>
                            <?php foreach ($menu_surat2 as $data) {
                                if ($data['favorit'] !== 1) { ?>
                                    <a class="csurat" href="<?= site_url() ?>surat/form/<?= $data['url_surat'] ?>">
                                        <img src="<?= base_url() ?>assets/images/cpanel/edit-select-all-2.png" />
                                        <span><?= strtoupper($data['nama']) ?></span>
                                    </a>
                            <?php }
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
