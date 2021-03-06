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
                    <h3>Data Keluarga</h3>
                </div>
                <div id="contentpane">
                    <?= form_open('', ['id' => 'mainform', 'name' => 'mainform']) ?>
                        <div class="ui-layout-north panel">
                            <div class="left">
                                <div class="uibutton-group">
                                    <a href="<?= site_url('keluarga/form') ?>" class="uibutton tipsy south" title="Tambah Data KK Baru"><span class="icon-plus-sign icon-large">&nbsp;</span>Tambah KK Baru</a>

                                    <a href="<?= site_url('keluarga/form_old') ?>" target="ajax-modal" rel="window" header="Tambah Data Keluarga" class="uibutton tipsy south" title="Tambah Data KK dari data penduduk yang sudah ter-input"><span class="icon-plus icon-large">&nbsp;</span>Tambah KK</a>

                                    <?php if ($grup === 1) { ?><button type="button" title="Hapus Data" onclick="deleteAllBox('mainform','<?= site_url("keluarga/delete_all/{$p}/{$o}") ?>')" class="uibutton tipsy south"><span class="icon-trash icon-large">&nbsp;</span>Hapus Data</button><?php } ?>

                                    <a href="<?= site_url("keluarga/cetak/{$o}") ?>" target="_blank" class="uibutton tipsy south" title="Cetak"><span class="icon-print icon-large">&nbsp;</span>Cetak</a>

                                    <a href="<?= site_url("keluarga/excel/{$o}") ?>" target="_blank" class="uibutton tipsy south" title="Unduh"><span class="icon-file-text icon-large">&nbsp;</span>Unduh</a>
                                    &nbsp;
                                    <select name="dusun" onchange="formAction('mainform','<?= site_url('keluarga/dusun') ?>')">
                                        <option value="">Dusun</option>
                                        <?php foreach ($list_dusun as $data) { ?>
                                            <option value="<?= $data['dusun'] ?>" <?php if ($dusun === $data['dusun']) : ?>selected<?php endif ?>><?= strtoupper(unpenetration(ununderscore($data['dusun']))) ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php if ($dusun) { ?>
                                        <select name="rw" onchange="formAction('mainform','<?= site_url('keluarga/rw') ?>')">
                                            <option value="">RW</option>
                                            <?php foreach ($list_rw as $data) { ?>
                                                <option value="<?= $data['rw'] ?>" <?php if ($rw === $data['rw']) : ?>selected<?php endif ?>><?= $data['rw'] ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>

                                    <?php if ($rw) { ?>
                                        <select name="rt" onchange="formAction('mainform','<?= site_url('keluarga/rt') ?>')">
                                            <option value="">RT</option>
                                            <?php foreach ($list_rt as $data) { ?>
                                                <option value="<?= $data['rt'] ?>" <?php if ($rt === $data['rt']) : ?>selected<?php endif ?>><?= $data['rt'] ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>

                                    <select name="sex" onchange="formAction('mainform','<?= site_url('keluarga/sex') ?>')">
                                        <option value="">Jenis Kelamin</option>
                                        <option value="1" <?php if ($sex === 1) : ?>selected<?php endif ?>>Laki-Laki</option>
                                        <option value="2" <?php if ($sex === 2) : ?>selected<?php endif ?>>Perempuan</option>
                                    </select>

                                </div>
                            </div>
                            <div class="right">
                                <input name="cari" id="cari" type="text" class="inputbox help tipped" size="20" value="<?= $cari ?>" title="Cari.." onkeypress="if (event.keyCode == 13) {$('#'+'mainform').attr('action','<?= site_url('keluarga/search') ?>');$('#'+'mainform').submit();}" />
                                <button type="button" onclick="$('#'+'mainform').attr('action','<?= site_url('keluarga/search') ?>');$('#'+'mainform').submit();" class="uibutton tipsy south" title="Cari Data"><span class="icon-search icon-large">&nbsp;</span>Cari</button>
                            </div>

                        </div>
                        <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                            <table class="list">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th><input type="checkbox" class="checkall" /></th>
                                        <th width="160">Aksi</th>

                                        <th width="150" align="left">
                                            <?php if ($o === 2) : ?>
                                                <a href="<?= site_url("keluarga/index/{$p}/1") ?>">Nomor KK<span class="ui-icon ui-icon-triangle-1-n">
                                                    <?php elseif ($o === 1) : ?>
                                                        <a href="<?= site_url("keluarga/index/{$p}/2") ?>">Nomor KK<span class="ui-icon ui-icon-triangle-1-s">
                                                            <?php else : ?>
                                                                <a href="<?= site_url("keluarga/index/{$p}/1") ?>">Nomor KK<span class="ui-icon ui-icon-triangle-2-n-s">
                                                                    <?php endif; ?>
                                                                    &nbsp;</span></a>
                                        </th>
                                        <th width="100">NIK</th>
                                        <th align="left">
                                            <?php if ($o === 4) : ?>
                                                <a href="<?= site_url("keluarga/index/{$p}/3") ?>">Kepala Keluarga<span class="ui-icon ui-icon-triangle-1-n">
                                                    <?php elseif ($o === 3) : ?>
                                                        <a href="<?= site_url("keluarga/index/{$p}/4") ?>">Kepala Keluarga<span class="ui-icon ui-icon-triangle-1-s">
                                                            <?php else : ?>
                                                                <a href="<?= site_url("keluarga/index/{$p}/3") ?>">Kepala Keluarga<span class="ui-icon ui-icon-triangle-2-n-s">
                                                                    <?php endif; ?>
                                                                    &nbsp;</span></a>
                                        </th>

                                        <th width="100">Jumlah Anggota</th>
                                        <th width="120">Jenis Kelamin</th>
                                        <th width="120">Dusun</th>
                                        <th width="30">RW</th>
                                        <th width="30">RT</th>
                                        <th width="100">Tanggal Terdaftar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($main as $data) : ?>
                                        <tr>
                                            <td align="center" width="2"><?= $data['no'] ?></td>
                                            <td align="center" width="5">
                                                <input type="checkbox" name="id_cb[]" value="<?= $data['id'] ?>" />
                                            </td>
                                            <td width="5">
                                                <div class="uibutton-group">
                                                    <a href="<?= site_url("keluarga/anggota/{$p}/{$o}/{$data['id']}") ?>" class="uibutton tipsy south" title="Rincian Anggota Keluarga"><span class="icon-list icon-large"> Rincian </span></a>
                                                    <a href="<?= site_url("keluarga/edit_nokk/{$p}/{$o}/{$data['id']}") ?>" class="uibutton tipsy south" title="Ubah Data" target="ajax-modal" rel="window" header="Ubah Data KK"><span class="icon-edit icon-large"></span></a>
                                                    <a href="<?= site_url("keluarga/ajax_penduduk_pindah/{$data['id']}") ?>" class="uibutton tipsy south" title="Pindah Keluarga dalam Desa" target="ajax-modal" rel="window" header="Pindah Keluarga"><span class="icon-share icon-large"></span></a>
                                                    <?php if ($grup === 1) { ?><a href="<?= site_url("keluarga/delete/{$p}/{$o}/{$data['id']}") ?>" class="uibutton tipsy south" title="Hapus Data" target="confirm" message="Apakah Anda Yakin?" header="Hapus Data"><span class="icon-trash icon-large"></span> </a><?php } ?>
                                                </div>
                                            </td>
                                            <td><a href="<?= site_url("keluarga/kartu_keluarga/{$p}/{$o}/{$data['id']}") ?>"> <?= $data['no_kk'] ?> </a></td>
                                            <td><?= strtoupper($data['nik']) ?></td>
                                            <td><?= strtoupper(unpenetration($data['kepala_kk'])) ?></td>
                                            <td><a href="<?= site_url("keluarga/anggota/{$p}/{$o}/{$data['id']}") ?>"><?= $data['jumlah_anggota'] ?></a></td>
                                            <td><?= strtoupper($data['sex']) ?></td>
                                            <td><?= strtoupper(unpenetration(ununderscore($data['dusun']))) ?></td>
                                            <td><?= strtoupper($data['rw']) ?></td>
                                            <td><?= strtoupper($data['rt']) ?></td>
                                            <td><?= tgl_indo($data['tgl_daftar']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    <?= form_close() ?>
                    <div class="ui-layout-south panel bottom">
                        <div class="left">
                            <div class="table-info">
                                <?= form_open('keluarga', ['id' => 'paging']) ?>
                                    <label>Tampilkan</label>
                                    <select name="per_page" onchange="$('#paging').submit()">
                                        <option value="50" <?php selected($per_page, 50); ?>>50</option>
                                        <option value="100" <?php selected($per_page, 100); ?>>100</option>
                                        <option value="200" <?php selected($per_page, 200); ?>>200</option>
                                    </select>
                                    <label>Dari</label>
                                    <label><strong><?= $paging->num_rows ?></strong></label>
                                    <label>Total Data</label>
                                <?= form_close() ?>
                            </div>
                        </div>
                        <div class="right">
                            <div class="uibutton-group">
                                <?php if ($paging->start_link) : ?>
                                    <a href="<?= site_url("keluarga/index/{$paging->start_link}/{$o}") ?>" class="uibutton">Awal</a>
                                <?php endif; ?>
                                <?php if ($paging->prev) : ?>
                                    <a href="<?= site_url("keluarga/index/{$paging->prev}/{$o}") ?>" class="uibutton">Prev</a>
                                <?php endif; ?>
                            </div>
                            <div class="uibutton-group">

                                <?php for ($i = $paging->start_link; $i <= $paging->end_link; $i++) : ?>
                                    <a href="<?= site_url("keluarga/index/{$i}/{$o}") ?>" <?php jecho($p, $i, "class='uibutton special'") ?> class="uibutton"><?= $i ?></a>
                                <?php endfor; ?>
                            </div>
                            <div class="uibutton-group">
                                <?php if ($paging->next) : ?>
                                    <a href="<?= site_url("keluarga/index/{$paging->next}/{$o}") ?>" class="uibutton">Next</a>
                                <?php endif; ?>
                                <?php if ($paging->end_link) : ?>
                                    <a href="<?= site_url("keluarga/index/{$paging->end_link}/{$o}") ?>" class="uibutton">Akhir</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
