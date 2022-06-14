<script>
    $(function() {
        $('#' + 'manual').show();
        var link = {};
        link.results = [
            <?php foreach ($link as $data) { ?> {
                    id: 'artikel/<?= $data['id'] ?>',
                    name: '<?= $data['judul'] ?>',
                    info: 'Halaman Berisi <?= $data['judul'] ?>'
                },
            <?php } ?> {
                id: 'gallery',
                name: 'Gallery',
                info: 'Halaman Gallery'
            },
        ];
        link.total = link.results.length;
        $('#link').flexbox(link, {
            resultTemplate: '<div><label>No link : </label>{name}</div><div>{info}</div>',
            watermark: 'Pilih kategori Link',
            width: 260,
            noResultsText: 'Tidak ada no link yang sesuai..',
            onSelect: function() {
                $('#' + 'manual').hide();
            }
        });
    });
</script>
<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <td class="side-menu">
                <fieldset>
                    <legend>Kategori kategori</legend>
                    <div class="lmenu">
                        <ul>
                            <li <?php if ($tip === 1) {
    echo "class='selected'";
} ?>><a href="<?= site_url('menu/index/1') ?>">Menu Statis</a></li>
                            <li <?php if ($tip === 2) {
    echo "class='selected'";
} ?>><a href="<?= site_url('kategori/index/2') ?>">Kategori / Dinamis</a></li>
                        </ul>
                    </div>
                </fieldset>
            </td>
            <td style="background:#fff;padding:0px;">
                <div id="contentpane">
                    <?= form_open($form_action, ['id' => 'validasi']) ?>
                        <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                            <table class="form">
                                <tr>
                                    <th>Nama Kategori</th>
                                    <td><input class="inputbox" type="text" name="kategori" value="<?= $kategori['kategori'] ?>" size="40" /></td>
                                </tr>
                            </table>
                        </div>

                        <div class="ui-layout-south panel bottom">
                            <div class="left">
                                <a href="<?= site_url() ?>kategori/index/<?= $tip ?>" class="uibutton icon prev">Kembali</a>
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
