<script>
    $(function() {
        var nik = {};
        nik.results = [
            <?php foreach($penduduk as $data){?> {
                id: '<?php echo $data['id']?>',
                name: "<?php echo $data['nik']." - ".($data['nama'])?>",
                info: "<?php echo ($data['alamat'])?>"
            },
            <?php }?>
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
        $("#nik_detail").show();
    });

</script>
<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <td style="background:#fff;padding:0px;">
                <div id="contentpane">
                    <form id="validasi" action="<?php echo $form_action?>" method="POST" enctype="multipart/form-data">
                        <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                            <h3>Form Data Dusun</h3>
                            <table class="form">
                                <tr>
                                    <th width="160">Nama Dusun</th>
                                    <td><input name="dusun" type="text" class="inputbox required" size="60" value="<?php echo $dusun?>"></td>
                                </tr>
                                <?php if($dusun){?>
                                <tr>
                                    <th>Kepala Dusun Sebelumnya</th>
                                    <td>
                                        <?php echo $individu['nama']?>
                                        <br>NIK - <?php echo $individu['nik']?>
                                    </td>
                                </tr>
                                <?php }?>
                                <tr>
                                    <th>NIK / Nama Kepala Dusun</th>
                                    <td>
                                        <div id="id_kepala" name="id_kepala"></div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="ui-layout-south panel bottom">
                            <div class="left">
                                <a href="<?php echo site_url('sid_core') ?>" class="uibutton icon prev">Kembali</a>
                            </div>
                            <div class="right">
                                <div class="uibutton-group">

                                    <button class="uibutton confirm" type="submit">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </td>
        </tr>
    </table>
</div>
