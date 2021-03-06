<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <td style="background:#fff;padding:0px;">
                <div id="contentpane">
                    <?= form_open_multipart($form_action, ['id' => 'validasi']) ?>
                        <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                            <table class="form">
                                <tr>
                                    <th width="100">Nama Kategori</th>
                                    <td><input class="inputbox" type="text" name="nama" value="<?= $point['nama'] ?>" size="40" /></td>
                                </tr>
                                <tr>
                                    <th>Simbol</th>
                                    <td>
                                        <div id="simbol" style="float:left;padding-top:6px;"></div>
                                        <div style="float:left;margin-left:10px;">
                                            <?php if ($point['simbol'] !== '') { ?>
                                                <img src="<?= base_url(); ?>assets/images/gis/point/<?= $point['simbol'] ?>">
                                            <?php } else { ?>
                                                <img src="<?= base_url(); ?>assets/images/gis/point/default.png">
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php ?>
                            </table>
                        </div>

                        <div class="ui-layout-south panel bottom">
                            <div class="left">
                                <a href="<?= site_url() ?>point" class="uibutton icon prev">Kembali</a>
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
<script>
    $(function() {
        var nik = {};
        nik.results = [
            <?php foreach ($simbol as $data) { ?> {
                    id: '<?= $data['simbol'] ?>',
                    name: "<?= $data['simbol'] ?>",
                    info: '<img src="<?= base_url(); ?>assets/images/gis/point/<?= $data['simbol'] ?>">'
                },
            <?php } ?>
        ];

        nik.total = nik.results.length;
        $('#simbol').flexbox(nik, {
            resultTemplate: '<div style=height:33px;margin-top:-4px;>{info}</div><div style="display:none;">{name}</div>',
            watermark: <?php if ($point) { ?> '<?= $point['simbol'] ?>'
        <?php } else { ?> 'Ketik nama simbol di sini..'
        <?php } ?>,
        width: 100,
        noResultsText: '...'

        //	$('#'+'main').submit();

        });
    });
</script>
