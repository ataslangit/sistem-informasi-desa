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
        $('#nik').flexbox(nik, {
            resultTemplate: '<div><label>No nik : </label>{name}</div><div>{info}</div>',
            watermark: <?php if ($individu) { ?> '<?= $individu['nik'] ?> - <?= spaceunpenetration($individu['nama']) ?>'
        <?php } else { ?> 'Ketik no nik di sini..'
        <?php } ?>,
        width: 260,
        noResultsText: 'Tidak ada no nik yang sesuai..',
        onSelect: function() {
            $('#' + 'main').submit();
        }
        });
    });
</script>
<style>
    table.form.detail th {
        padding: 5px;
        background: #fafafa;
        border-right: 1px solid #eee;
    }

    table.form.detail td {
        padding: 5px;
    }
</style>
<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <td style="background:#fff;padding:5px;">
                <div class="content-header">
                </div>
                <div id="contentpane">
                    <div class="ui-layout-north panel">
                        <h3>Surat Keterangan Tentang Orang Tua</h3>
                    </div>
                    <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                        <table class="form">
                            <tr>
                                <th>NIK / Nama</th>
                                <td>
                                    <form action="" id="main" name="main" method="POST">
                                        <div id="nik" name="nik"></div>
                                    </form>
                            </tr>
                            <form id="validasi" action="<?= $form_action ?>" method="POST" target="_blank">
                                <input type="hidden" name="nik" value="<?= $individu['id'] ?>">
                                <?php if ($individu) { ?>
                                    <tr>
                                        <th>Tempat Tanggal Lahir (Umur)</th>
                                        <td>
                                            <?= $individu['tempatlahir'] ?> <?= tgl_indo($individu['tanggallahir']) ?> (<?= $individu['umur'] ?> Tahun)
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>
                                            <?= unpenetration($individu['alamat']); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Pendidikan</th>
                                        <td>
                                            <?= $individu['pendidikan'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Warganegara / Agama</th>
                                        <td>
                                            <?= $individu['warganegara'] ?> / <?= $individu['agama'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Dokumen Kelengkapan / Syarat</th>
                                        <td>
                                            <a header="Dokumen" target="ajax-modal" rel="dokumen" href="<?= site_url("penduduk/dokumen_list/{$individu['id']}") ?>" class="uibutton special">Daftar Dokumen</a><a target="_blank" href="<?= site_url("penduduk/dokumen/{$individu['id']}") ?>" class="uibutton confirm">Manajemen Dokumen</a> )* Atas Nama <?= $individu['nama'] ?> [<?= $individu['nik'] ?>]
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <th>Nomor Surat</th>
                                    <td>
                                        <input name="nomor" type="text" class="inputbox required" size="12" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>DATA AYAH : </td>
                                </tr>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td>
                                        <input name="nama_ayah" type="text" class="inputbox required" size="40" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tempat Tanggal Lahir</th>
                                    <td>
                                        <input name="tempat_lahir_ayah" type="text" class="inputbox required" size="30" />
                                        <input name="tgl_lahir_ayah" type="text" class="inputbox required datepicker" size="30" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>Warganegara</th>
                                    <td>
                                        <input name="wn_ayah" type="text" class="inputbox required" size="40" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>Agama</th>
                                    <td>
                                        <input name="agama_ayah" type="text" class="inputbox required" size="40" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan</th>
                                    <td>
                                        <input name="pekerjaan_ayah" type="text" class="inputbox required" size="40" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tempat Tinggal</th>
                                    <td>
                                        <input name="tempat_tinggal_ayah" type="text" class="inputbox required" size="40" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>DATA IBU : </td>
                                </tr>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td>
                                        <input name="nama_ibu" type="text" class="inputbox required" size="40" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tempat Tanggal Lahir</th>
                                    <td>
                                        <input name="tempat_lahir_ibu" type="text" class="inputbox required" size="30" />
                                        <input name="tgl_lahir_ibu" type="text" class="inputbox required datepicker" size="20" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>Warganegara</th>
                                    <td>
                                        <input name="wn_ibu" type="text" class="inputbox required" size="40" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>Agama</th>
                                    <td>
                                        <input name="agama_ibu" type="text" class="inputbox required" size="40" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan</th>
                                    <td>
                                        <input name="pekerjaan_ibu" type="text" class="inputbox required" size="40" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tempat Tinggal</th>
                                    <td>
                                        <input name="tempat_tinggal_ibu" type="text" class="inputbox required" size="40" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>Staf Pemerintah Desa</th>
                                    <td>
                                        <select name="pamong" class="inputbox required">
                                            <option value="">Pilih Staf Pemerintah Desa</option>
                                            <?php foreach ($pamong as $data) { ?>
                                                <option value="<?= $data['pamong_nama'] ?>">
                                                    <font style="bold"><?= unpenetration($data['pamong_nama']) ?></font> (<?= unpenetration($data['jabatan']) ?>)
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Sebagai</th>
                                    <td>
                                        <select name="jabatan" class="inputbox required">
                                            <option value="">Pilih Jabatan</option>
                                            <?php foreach ($pamong as $data) { ?>
                                                <option><?= $data['jabatan'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                        </table>
                    </div>

                    <div class="ui-layout-south panel bottom">
                        <div class="left">
                            <a href="<?= site_url() ?>surat" class="uibutton icon prev">Kembali</a>
                        </div>
                        <div class="right">
                            <div class="uibutton-group">

                                <button type="button" onclick="$('#'+'validasi').attr('action','<?= $form_action ?>');$('#'+'validasi').submit();" class="uibutton special"><span class="ui-icon ui-icon-print">&nbsp;</span>Cetak</button>
                                <?php if (file_exists("surat/{$url}/{$url}.rtf")) { ?><button type="button" onclick="$('#'+'validasi').attr('action','<?= $form_action2 ?>');$('#'+'validasi').submit();" class="uibutton confirm"><span class="ui-icon ui-icon-document">&nbsp;</span>Unduh</button><?php } ?>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </td>
        </tr>
    </table>
</div>
