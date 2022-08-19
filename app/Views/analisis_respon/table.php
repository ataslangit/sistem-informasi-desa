<?php
$subjek = $_SESSION['subjek_tipe'];

switch ($subjek) {
    case 1:
        $sql     = $nama     = 'Nama';
        $nomor   = 'NIK';
        $asubjek = 'Penduduk';
        break;

    case 2:
        $sql     = $nama     = 'Kepala Keluarga';
        $nomor   = 'Nomor KK';
        $asubjek = 'Keluarga';
        break;

    case 3:
        $sql     = $nama     = 'Kepala Rumah Tangga';
        $nomor   = 'Nomor Rumah Tangga';
        $asubjek = 'Rumah Tangga';
        break;

    case 4:
        $sql     = $nama     = 'Nama Kelompok';
        $nomor   = 'ID Kelompok';
        $asubjek = 'Kelompok';
        break;

    default:
        return null;
}
?>
<script>
    $(function() {
        var keyword = <?= $keyword ?>;
        $("#cari").autocomplete({
            source: keyword
        });
    });
</script>
<style>
    table.head {
        font-size: 16px;
        font-weight: normal;
    }
</style>
<div id="pageC">
    <?php echo view('analisis_master/left', $data); ?>
    <div class="content-header">
    </div>
    <div id="contentpane">
        <?= form_open('', ['id' => 'mainform', 'name' => 'mainform']) ?>
            <div class="ui-layout-north panel">
            </div>
            <div class="ui-layout-center" id="maincontent">
                <table class="head">
                    <tr>
                        <td width="150">Nama Analisis</td>
                        <td> : </td>
                        <td><a href="<?= site_url() ?>analisis_master/menu/<?= $_SESSION['analisis_master'] ?>"><?= $analisis_master['nama'] ?></a></td>
                    </tr>
                    <tr>
                        <td>Subjek Analisis</td>
                        <td> : </td>
                        <td><?= $asubjek ?></td>
                    </tr>
                    <tr>
                        <td>Periode</td>
                        <td> : </td>
                        <td><?= $analisis_periode ?></td>
                    </tr>
                </table>
                <div class="table-panel top">
                    <div class="left">
                        <select name="dusun" onchange="formAction('mainform','<?= site_url('analisis_respon/dusun') ?>')">
                            <option value="">Dusun</option>
                            <?php foreach ($list_dusun as $data) { ?>
                                <option value="<?= $data['dusun'] ?>" <?php if ($dusun === $data['dusun']) : ?>selected<?php endif ?>><?= $data['dusun'] ?></option>
                            <?php } ?>
                        </select>

                        <?php if ($dusun) { ?>
                            <select name="rw" onchange="formAction('mainform','<?= site_url('analisis_respon/rw') ?>')">
                                <option value="">RW</option>
                                <?php foreach ($list_rw as $data) { ?>
                                    <option value="<?= $data['rw'] ?>" <?php if ($rw === $data['rw']) : ?>selected<?php endif ?>><?= $data['rw'] ?></option>
                                <?php } ?>
                            </select>
                        <?php } ?>

                        <?php if ($rw) { ?>
                            <select name="rt" onchange="formAction('mainform','<?= site_url('analisis_respon/rt') ?>')">
                                <option value="">RT</option>
                                <?php foreach ($list_rt as $data) { ?>
                                    <option value="<?= $data['rt'] ?>" <?php if ($rt === $data['rt']) : ?>selected<?php endif ?>><?= $data['rt'] ?></option>
                                <?php } ?>
                            </select>
                        <?php } ?>

                        <select name="isi" onchange="formAction('mainform','<?= site_url('analisis_respon/isi') ?>')">
                            <option value=""> --- Semua --- </option>
                            <option value="1" <?php if ($isi === 1) : ?>selected<?php endif ?>>Sudah Terinput</option>
                            <option value="2" <?php if ($isi === 2) : ?>selected<?php endif ?>>Belum Terinput</option>
                        </select>
                        <a href="<?= site_url('analisis_respon/data_ajax') ?>" class="uibutton special tipsy south" title="Fungsi Import harap digunakan secara seksama" target="ajax-modal" rel="window" header="Unduh Form Rujukan Import"><span class="icon-file-text icon-large">&nbsp;</span>Import</a>
                    </div>
                    <div class="right">
                        <input name="cari" id="cari" type="text" class="inputbox help tipped" size="40" value="<?= $cari ?>" title="Cari.." onkeypress="if(event.keyCode == 13) $('#'+'mainform').attr('action','<?= site_url('analisis_respon/search') ?>');$('#'+'mainform').submit();}" />
                        <button type="button" onclick="$('#'+'mainform').attr('action','<?= site_url('analisis_respon/search') ?>');$('#'+'mainform').submit();" class="uibutton tipsy south" title="Cari Data"><span class="icon-search icon-large">&nbsp;</span>Cari</button>
                    </div>
                </div>
                <table class="list">
                    <thead>
                        <tr>
                            <th width="10">No</th>
                            <th width='50'>Aksi</th>
                            <?php if ($o === 2) : ?>
                                <th align="left" width='120'><a href="<?= site_url("analisis_respon/index/{$p}/1") ?>"><?= $nomor ?><span class="ui-icon ui-icon-triangle-1-n">&nbsp;</span></a></th>
                            <?php elseif ($o === 1) : ?>
                                <th align="left" width='120'><a href="<?= site_url("analisis_respon/index/{$p}/2") ?>"><?= $nomor ?><span class="ui-icon ui-icon-triangle-1-s">&nbsp;</span></a></th>
                            <?php else : ?>
                                <th align="left" width='120'><a href="<?= site_url("analisis_respon/index/{$p}/1") ?>"><?= $nomor ?><span class="ui-icon ui-icon-triangle-2-n-s">&nbsp;</span></a></th>
                            <?php endif; ?>

                            <?php if ($o === 4) : ?>
                                <th align="left" width='250'><a href="<?= site_url("analisis_respon/index/{$p}/3") ?>"><?= $nama ?><span class="ui-icon ui-icon-triangle-1-n">&nbsp;</span></a></th>
                            <?php elseif ($o === 3) : ?>
                                <th align="left" width='250'><a href="<?= site_url("analisis_respon/index/{$p}/4") ?>"><?= $nama ?><span class="ui-icon ui-icon-triangle-1-s">&nbsp;</span></a></th>
                            <?php else : ?>
                                <th align="left" width='250'><a href="<?= site_url("analisis_respon/index/{$p}/3") ?>"><?= $nama ?><span class="ui-icon ui-icon-triangle-2-n-s">&nbsp;</span></a></th>
                            <?php endif; ?>

                            <th width='50'>L/P</th>
                            <th width='100'>Dusun</th>
                            <th width='30'>RW</th>
                            <th width='30'>RT</th>
                            <th width='50'>Status</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($main as $data) : ?>
                            <tr>
                                <td align="center" width="2"><?= $data['no'] ?></td>
                                <td>
                                    <div class="uibutton-group">
                                        <a href="<?= site_url("analisis_respon/kuisioner/{$p}/{$o}/{$data['id']}") ?>" class="uibutton south"><span class="icon-list icon-large"> Input Data</span></a>
                                    </div>
                                </td>
                                <td><?= $data['nid'] ?></td>
                                <td><?= $data['nama'] ?></td>
                                <td align="center"><?= $data['jk'] ?></td>
                                <td><?= $data['dusun'] ?></td>
                                <td><?= $data['rw'] ?></td>
                                <td><?= $data['rt'] ?></td>
                                <td align="center"><?= $data['set'] ?></td>
                                <td></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?= form_close() ?>
        <div class="ui-layout-south panel bottom">
            <div class="left">
                <div class="table-info">
                    <?= form_open('analisis_respon', ['id' => 'paging']) ?>
                        <a href="<?= site_url() ?>analisis_respon/leave" class="uibutton icon prev">Kembali</a>
                        <label></label>
                        <select name="per_page" onchange="$('#paging').submit()">
                            <option value="20" <?php selected($per_page, 20); ?>>20</option>
                            <option value="50" <?php selected($per_page, 50); ?>>50</option>
                            <option value="100" <?php selected($per_page, 100); ?>>100</option>
                        </select>
                        <label>Dari</label>
                        <label><?= $paging->num_rows ?></label>
                        <label>Total Data</label>
                    <?= form_close() ?>
                </div>
            </div>
            <div class="right">
                <div class="uibutton-group">
                    <?php if ($paging->start_link) : ?>
                        <a href="<?= site_url("analisis_respon/index/{$paging->start_link}/{$o}") ?>" class="uibutton">Awal</a>
                    <?php endif; ?>
                    <?php if ($paging->prev) : ?>
                        <a href="<?= site_url("analisis_respon/index/{$paging->prev}/{$o}") ?>" class="uibutton">Prev</a>
                    <?php endif; ?>
                </div>
                <div class="uibutton-group">
                    <?php for ($i = $paging->start_link; $i <= $paging->end_link; $i++) : ?>
                        <a href="<?= site_url("analisis_respon/index/{$i}/{$o}") ?>" <?php jecho($p, $i, "class='uibutton special'") ?> class="uibutton"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
                <div class="uibutton-group">
                    <?php if ($paging->next) : ?>
                        <a href="<?= site_url("analisis_respon/index/{$paging->next}/{$o}") ?>" class="uibutton">Next</a>
                    <?php endif; ?>
                    <?php if ($paging->end_link) : ?>
                        <a href="<?= site_url("analisis_respon/index/{$paging->end_link}/{$o}") ?>" class="uibutton">Akhir</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
