<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/validasi.js"></script>
<script>
    $(function() {
        var nik = {};
        nik.results = [
            <?php foreach ($penduduk as $data) { ?> {
                    id: '<?= $data['id'] ?>',
                    name: "<?= $data['nik'] . ' - ' . $data['nama'] ?>",
                    info: ""
                },
            <?php } ?>
        ];
        nik.total = nik.results.length;
        $('#nik_kepala').flexbox(nik, {
            resultTemplate: '<div><label>No nik : </label>{name}</div><div>{info}</div>',
            watermark: 'Ketik nama / nik di sini..',
            width: 300,
            noResultsText: 'Tidak ada nama / nik yang sesuai..',
        });
    });
</script>
<?= form_open($form_action, ['id' => 'validasi']) ?>
    <table class="list">
        <tr>
            <th align="left">Nomor KK RTM</th>
            <td>
                <div id="nik_kepala" name="nik_kepala" style="float:right;"></div class="required">
            </td>
        </tr>
        <tr>
            <th align="left">Nomor RTM</th>
            <td>
                <input type="text" name="no_kk" class="inputbox required">
            </td>
        </tr>
    </table>
    <div class="buttonpane" style="text-align: right; width:400px;position:absolute;bottom:0px;">
        <div class="uibutton-group">
            <button class="uibutton" type="button" onclick="$('#window').dialog('close');">Tutup</button>
            <button class="uibutton confirm" type="submit">Simpan</button>
        </div>
    </div>
<?= form_close() ?>
