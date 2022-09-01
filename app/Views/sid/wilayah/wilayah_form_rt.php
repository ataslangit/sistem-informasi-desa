<script>
    $(function() {
        var nik = {};
        nik.results = [
            <?php foreach ($penduduk as $data) { ?> {
                    id: '<?= $data['id'] ?>',
                    name: "<?= $data['nik'] . ' - ' . ($data['nama']) ?>",
                    info: "<?= $data['alamat'] ?>"
                },
            <?php } ?>
        ];
        nik.total = nik.results.length;
        $('#id_kepala').flexbox(nik, {
            resultTemplate: '<div><label>No nik : </label>{name}</div><div>{info}</div>',
            watermark: 'Ketik no nik di sini..',
            width: 260,
            noResultsText: 'Tidak ada no nik yang sesuai..',
            onSelect: function() {
                $('#' + 'main').submit();
            }
        });
    });
</script>
<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <td style="background:#fff;padding:0px;">
                <div id="contentpane">
                    <?= form_open($form_action, ['id' => 'validasi']) ?>
                        <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                            <h3>Form Data RT</h3>
                            <table class="form">
                                <tr>
                                    <th width="160">Nomor RT</th>
                                    <td><input name="rt" type="text" class="inputbox required number" size="40" value="<?= $rt ?>" /></td>
                                </tr>
                                <?php if ($rt) { ?>
                                    <tr>
                                        <th>Ketua RT Sebelumnya</th>
                                        <td>
                                            <?= $individu['nama'] ?>
                                            <br />NIK - <?= $individu['nik'] ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <th>NIK / Nama Ketua RT</th>
                                    <td>
                                        <div id="id_kepala" name="id_kepala"></div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="ui-layout-south panel bottom">
                            <div class="left">
                                <a href="<?= site_url("sid_core/sub_rt/{$id_dusun}/{$rw}") ?>" class="uibutton icon prev">Kembali</a>
                            </div>
                            <div class="right">
                                <div class="uibutton-group">

                                    <button class="uibutton confirm" type="submit">Simpan</button>
                                </div>
                            </div>
                        </div>
                    <?= form_close() ?>
                </div>
            </td>
        </tr>
    </table>
</div>
