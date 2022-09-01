<script>
    $(function() {
        var keyword = <?= $keyword ?>;
        $("#cari").autocomplete({
            source: keyword
        });
    });
</script>
<div id="pageC">
    <!-- Start of Space Admin -->
    <table class="inner">
        <tr style="vertical-align:top">
            <td style="background:#fff;padding:0px;">
                <div class="content-header">

                </div>
                <div id="contentpane">
                    <?= form_open('', ['id' => 'mainform', 'name' => 'mainform']) ?>
                        <div class="ui-layout-north panel">
                            <div class="left">
                                <h3>Pemerintah Desa</h3>
                                <div class="uibutton-group">
                                    <a href="<?= site_url('pengurus/form') ?>" class="uibutton tipsy south" title="Tambah Data"><span class="icon-plus-sign icon-large">&nbsp;</span>Tambah Perangkat Desa</a>
                                    <button type="button" title="Hapus Data" onclick="deleteAllBox('mainform','<?= site_url('pengurus/delete_all') ?>')" class="uibutton tipsy south"><span class="icon-trash icon-large">&nbsp;</span>Hapus Data
                                </div>
                            </div>
                        </div>
                        <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                            <div class="table-panel top">
                                <div class="left">
                                    <select name="filter" onchange="formAction('mainform','<?= site_url('pengurus/filter') ?>')">
                                        <option value="">Semua</option>
                                        <option value="1" <?php if ($filter === 1) : ?>selected<?php endif ?>>Aktif</option>
                                        <option value="2" <?php if ($filter === 2) : ?>selected<?php endif ?>>Tidak Aktif</option>
                                    </select>
                                </div>
                                <div class="right">
                                    <input name="cari" id="cari" type="text" class="inputbox help tipped" size="20" value="<?= $cari ?>" title="Cari.." onkeypress="if (event.keyCode == 13) {$('#'+'mainform').attr('action','<?= site_url('pengurus/search') ?>');$('#'+'mainform').submit();}" />
                                    <button type="button" onclick="$('#'+'mainform').attr('action','<?= site_url('pengurus/search') ?>');$('#'+'mainform').submit();" class="uibutton tipsy south" title="Cari Data"><span class="icon-search icon-large">&nbsp;</span>Cari</button>
                                </div>
                            </div>
                            <table class="list">
                                <thead>
                                    <tr>
                                        <th width="5">No</th>
                                        <th width="10"><input type="checkbox" class="checkall" /></th>
                                        <th width="100">Aksi</th>
                                        <th align="left" width="350">Nama</th>
                                        <th align="left" width="150">N.I.P</th>
                                        <th align="left" width="120">Jabatan</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($main as $data) { ?>
                                        <tr>
                                            <td align="center" width="2"><?= $data['no'] ?></td>
                                            <td align="center" width="5">
                                                <input type="checkbox" name="id_cb[]" value="<?= $data['pamong_id'] ?>" />
                                            </td>
                                            <td width="5">
                                                <div class="uibutton-group">
                                                    <?php if ($data['pamong_id'] !== '707') { ?><a href="<?= site_url("pengurus/form/{$data['pamong_id']}") ?>" class="uibutton tipsy south" title="Ubah Data"><span class="icon-edit icon-large"> Ubah </span></a><a href="<?= site_url("pengurus/delete/{$data['pamong_id']}") ?>" class="uibutton tipsy south" title="Hapus Data" target="confirm" message="Apakah Anda Yakin?" header="Hapus Data"><span class="icon-trash icon-large"></span></a><?php } ?></div>
                                            </td>
                                            <td><?= unpenetration($data['pamong_nama']) ?></td>
                                            <td><?= $data['pamong_nip'] ?></td>
                                            <td><?= unpenetration($data['jabatan']) ?></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?= form_close() ?>
                    <div class="ui-layout-south panel bottom">
                        <div class="left">
                        </div>
                        <div class="right">
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
