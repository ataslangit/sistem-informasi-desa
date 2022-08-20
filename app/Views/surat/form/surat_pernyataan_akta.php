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
            <td class="side-menu">
                <fieldset>
                    <legend>Surat Administrasi</legend>
                    <div id="sidecontent2" class="lmenu">
                        <ul>
                            <?php foreach ($menu_surat as $data) { ?>
                                <li <?php if ($data['url_surat'] === $lap) { ?>class="selected" <?php } ?>><a href="<?= site_url() ?>/surat/<?= $data['url_surat'] ?>"><?= unpenetration($data['nama']) ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </fieldset>
            </td>
            <td style="background:#fff;padding:5px;">
                <div class="content-header">
                </div>
                <div id="contentpane">
                    <div class="ui-layout-north panel">
                        <h3>Surat Pernyataan Belum Memiliki Akte Lahir</h3>
                    </div>
                    <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                        <table class="form">
                            <tr>
                                <th>NIK / Nama Ayah</th>
                                <td>
                                    <?= form_open('', ['id' => 'main', 'name' => 'main']) ?>
                                        <div id="nik" name="nik"></div>
                                    <?= form_close() ?>
                            </tr>
                            <?= form_open($form_action, ['id' => 'validasi', 'target' => '_blank']) ?>
                                <input type="hidden" name="nik" value="<?= $individu['id'] ?>" class="inputbox required">
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
                                    <td><input name="nomor" type="text" class="inputbox required" size="12" /></td>
                                </tr>
                                <tr>
                                    <th>DATA KELAHIRAN</th>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <td><input name="nama" type="text" class="inputbox required" size="30" /></td>
                                </tr>
                                <tr>
                                    <th>Tempat Tanggal Lahir</th>
                                    <td><input name="tempatlahir" type="text" class="inputbox required" size="10" />
                                        <input name="tanggllahir" type="text" class="inputbox required datepicker" size="10" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td><input name="sex" type="text" class="inputbox required" size="10" /> </td>
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
                            <a href="<?= site_url() ?>/surat" class="uibutton icon prev">Kembali</a>
                        </div>
                        <div class="right">
                            <div class="uibutton-group">

                                <button type="button" onclick="$('#'+'validasi').attr('action','<?= $form_action ?>');$('#'+'validasi').submit();" class="uibutton special"><span class="ui-icon ui-icon-print">&nbsp;</span>Cetak</button>
                                <?php if (file_exists("surat/{$url}/{$url}.rtf")) { ?><button type="button" onclick="$('#'+'validasi').attr('action','<?= $form_action2 ?>');$('#'+'validasi').submit();" class="uibutton confirm"><span class="ui-icon ui-icon-document">&nbsp;</span>Unduh</button><?php } ?>
                            </div>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </td>
        </tr>
    </table>
</div>
