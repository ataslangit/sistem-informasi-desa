<script>
    $(function() {
        var keyword = <?= $keyword ?>;
        $("#cari").autocomplete({
            source: keyword
        });
    });
</script>
<div id="pageC">
    <?php echo view('analisis_master/left', $data); ?>
    <div class="content-header">
    </div>
    <div id="contentpane">
        <?= form_open('', ['id' => 'mainform', 'name' => 'mainform']) ?>
            <div class="ui-layout-north panel">
                <h3>Manajemen Indikator Analisis - <a href="<?= site_url() ?>analisis_master/menu/<?= $_SESSION['analisis_master'] ?>"><a href="<?= site_url() ?>analisis_master/menu/<?= $_SESSION['analisis_master'] ?>"><?= $analisis_master['nama'] ?></a></a></h3>
                <div class="left">
                    <div class="uibutton-group">
                        <?php if ($analisis_master['lock'] === 1) { ?><a href="<?= site_url('analisis_indikator/form') ?>" class="uibutton tipsy south" title="Tambah Data"><span class="icon-plus-sign icon-large">&nbsp;</span>Tambah Indikator Baru</a>
                            <button type="button" title="Hapus Data" onclick="deleteAllBox('mainform','<?= site_url("analisis_indikator/delete_all/{$p}/{$o}") ?>')" class="uibutton tipsy south"><span class="icon-trash icon-large">&nbsp;</span>Hapus Data<?php } ?>
                    </div>
                </div>
            </div>
            <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                <div class="table-panel top">
                    <div class="left">
                        <select name="tipe" onchange="formAction('mainform','<?= site_url('analisis_indikator/tipe') ?>')">
                            <option value="">-- Filter by Tipe Pertanyaan --</option>
                            <?php foreach ($list_tipe as $data) { ?>
                                <option value="<?= $data['id'] ?>" <?php if ($tipe === $data['id']) : ?>selected<?php endif ?>><?= $data['tipe'] ?></option>
                            <?php } ?>
                        </select>
                        &nbsp;
                        <select name="kategori" onchange="formAction('mainform','<?= site_url('analisis_indikator/kategori') ?>')">
                            <option value="">-- Filter by Kategori/Variabel --</option>
                            <?php foreach ($list_kategori as $data) { ?>
                                <option value="<?= $data['id'] ?>" <?php if ($kategori === $data['id']) : ?>selected<?php endif ?>><?= $data['kategori'] ?></option>
                            <?php } ?>
                        </select>
                        &nbsp;
                        <select name="filter" onchange="formAction('mainform','<?= site_url('analisis_indikator/filter') ?>')">
                            <option value="">-- Filter by Aksi Analisis</option>
                            <option value="1" <?php if ($filter === 1) : ?>selected<?php endif ?>>Ya</option>
                            <option value="2" <?php if ($filter === 2) : ?>selected<?php endif ?>>Tidak</option>
                        </select>
                    </div>
                    <div class="right">
                        <input name="cari" id="cari" type="text" class="inputbox help tipped" size="20" value="<?= $cari ?>" title="Cari.." onkeypress="if (event.keyCode == 13) {$('#'+'mainform').attr('action','<?= site_url('analisis_indikator/search') ?>');$('#'+'mainform').submit();}" />
                        <button type="button" onclick="$('#'+'mainform').attr('action','<?= site_url('analisis_indikator/search') ?>');$('#'+'mainform').submit();" class="uibutton tipsy south" title="Cari Data"><span class="icon-search icon-large">&nbsp;</span>Cari</button>
                    </div>
                </div>
                <table class="list">
                    <thead>
                        <tr>
                            <th width="10">No</th>
                            <?php if ($analisis_master['lock'] === 1) { ?> <th><input type="checkbox" class="checkall" /></th>
                                <th width="200">Aksi</th><?php } ?>
                            <?php if ($o === 2) : ?>
                                <th align="left" width="10"><a href="<?= site_url("analisis_indikator/index/{$p}/1") ?>">Kode<span class="ui-icon ui-icon-triangle-1-n">&nbsp;</span></a></th>
                            <?php elseif ($o === 1) : ?>
                                <th align="left" width="10"><a href="<?= site_url("analisis_indikator/index/{$p}/2") ?>">Kode<span class="ui-icon ui-icon-triangle-1-s">&nbsp;</span></a></th>
                            <?php else : ?>
                                <th align="left" width="10"><a href="<?= site_url("analisis_indikator/index/{$p}/1") ?>">Kode<span class="ui-icon ui-icon-triangle-2-n-s">&nbsp;</span></a></th>
                            <?php endif; ?>

                            <?php if ($o === 4) : ?>
                                <th align="left"><a href="<?= site_url("analisis_indikator/index/{$p}/3") ?>">Pertanyaan/Indikator<span class="ui-icon ui-icon-triangle-1-n">&nbsp;</span></a></th>
                            <?php elseif ($o === 3) : ?>
                                <th align="left"><a href="<?= site_url("analisis_indikator/index/{$p}/4") ?>">Pertanyaan/Indikator<span class="ui-icon ui-icon-triangle-1-s">&nbsp;</span></a></th>
                            <?php else : ?>
                                <th align="left"><a href="<?= site_url("analisis_indikator/index/{$p}/3") ?>">Pertanyaan/Indikator<span class="ui-icon ui-icon-triangle-2-n-s">&nbsp;</span></a></th>
                            <?php endif; ?>

                            <?php if ($o === 6) : ?>
                                <th align="left" width='100'><a href="<?= site_url("analisis_indikator/index/{$p}/5") ?>">Tipe Pertanyaan<span class="ui-icon ui-icon-triangle-1-n">&nbsp;</span></a></th>
                            <?php elseif ($o === 5) : ?>
                                <th align="left" width='100'><a href="<?= site_url("analisis_indikator/index/{$p}/6") ?>">Tipe Pertanyaan<span class="ui-icon ui-icon-triangle-1-s">&nbsp;</span></a></th>
                            <?php else : ?>
                                <th align="left" width='100'><a href="<?= site_url("analisis_indikator/index/{$p}/5") ?>">Tipe Pertanyaan<span class="ui-icon ui-icon-triangle-2-n-s">&nbsp;</span></a></th>
                            <?php endif; ?>

                            <?php if ($o === 6) : ?>
                                <th align="left" width='100'><a href="<?= site_url("analisis_indikator/index/{$p}/5") ?>">Kategori/Variabel<span class="ui-icon ui-icon-triangle-1-n">&nbsp;</span></a></th>
                            <?php elseif ($o === 5) : ?>
                                <th align="left" width='100'><a href="<?= site_url("analisis_indikator/index/{$p}/6") ?>">Kategori/Variabel<span class="ui-icon ui-icon-triangle-1-s">&nbsp;</span></a></th>
                            <?php else : ?>
                                <th align="left" width='100'><a href="<?= site_url("analisis_indikator/index/{$p}/5") ?>">Kategori/Variabel<span class="ui-icon ui-icon-triangle-2-n-s">&nbsp;</span></a></th>
                            <?php endif; ?>

                            <?php if ($o === 2) : ?>
                                <th align="left" width='50'><a href="<?= site_url("analisis_indikator/index/{$p}/1") ?>">Bobot<span class="ui-icon ui-icon-triangle-1-n">&nbsp;</span></a></th>
                            <?php elseif ($o === 1) : ?>
                                <th align="left" width='50'><a href="<?= site_url("analisis_indikator/index/{$p}/2") ?>">Bobot<span class="ui-icon ui-icon-triangle-1-s">&nbsp;</span></a></th>
                            <?php else : ?>
                                <th align="left" width='50'><a href="<?= site_url("analisis_indikator/index/{$p}/1") ?>">Bobot<span class="ui-icon ui-icon-triangle-2-n-s">&nbsp;</span></a></th>
                            <?php endif; ?>

                            <?php if ($o === 2) : ?>
                                <th align="left" width='100'><a href="<?= site_url("analisis_indikator/index/{$p}/1") ?>">Aksi Analisis<span class="ui-icon ui-icon-triangle-1-n">&nbsp;</span></a></th>
                            <?php elseif ($o === 1) : ?>
                                <th align="left" width='100'><a href="<?= site_url("analisis_indikator/index/{$p}/2") ?>">Aksi Analisis<span class="ui-icon ui-icon-triangle-1-s">&nbsp;</span></a></th>
                            <?php else : ?>
                                <th align="left" width='10'><a href="<?= site_url("analisis_indikator/index/{$p}/1") ?>">Aksi Analisis<span class="ui-icon ui-icon-triangle-2-n-s">&nbsp;</span></a></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($main as $data) : ?>
                            <tr>
                                <td align="center" width="2"><?= $data['no'] ?></td>
                                <?php if ($analisis_master['lock'] === 1) { ?>

                                    <td align="center" width="5">
                                        <input type="checkbox" name="id_cb[]" value="<?= $data['id'] ?>" />
                                    </td>
                                    <td>
                                        <div class="uibutton-group">
                                            <?php if ($data['id_tipe'] === 1 || $data['id_tipe'] === 2) { ?><a href="<?= site_url("analisis_indikator/parameter/{$data['id']}") ?>" class="uibutton"><span class="icon-list icon-large"> Jawaban</span></a><?php } ?><a href="<?= site_url("analisis_indikator/form/{$p}/{$o}/{$data['id']}") ?>" class="uibutton tipsy south" title="Ubah Data"><span class="icon-edit icon-large"> Ubah </span></a><a href="<?= site_url("analisis_indikator/delete/{$p}/{$o}/{$data['id']}") ?>" class="uibutton tipsy south" title="Hapus Data" target="confirm" message="Apakah Anda Yakin?" header="Hapus Data"><span class="icon-trash icon-large"></span></a>
                                        </div>
                                    </td>

                                <?php } ?>
                                <td><label><?= $data['nomor'] ?></label></td>
                                <td><?= $data['pertanyaan'] ?></td>
                                <td><?= $data['tipe_indikator'] ?></td>
                                <td><?= $data['kategori'] ?></td>
                                <td><?= $data['bobot'] ?></td>
                                <td><?= $data['act_analisis'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?= form_close() ?>
        <div class="ui-layout-south panel bottom">
            <div class="left">
                <div class="table-info">
                    <?= form_open('analisis_indikator', ['id' => 'paging']) ?>
                        <a href="<?= site_url() ?>analisis_indikator/leave" class="uibutton icon prev">Kembali</a>
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
                        <a href="<?= site_url("analisis_indikator/index/{$paging->start_link}/{$o}") ?>" class="uibutton">Awal</a>
                    <?php endif; ?>
                    <?php if ($paging->prev) : ?>
                        <a href="<?= site_url("analisis_indikator/index/{$paging->prev}/{$o}") ?>" class="uibutton">Prev</a>
                    <?php endif; ?>
                </div>
                <div class="uibutton-group">
                    <?php for ($i = $paging->start_link; $i <= $paging->end_link; $i++) : ?>
                        <a href="<?= site_url("analisis_indikator/index/{$i}/{$o}") ?>" <?php jecho($p, $i, "class='uibutton special'") ?> class="uibutton"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
                <div class="uibutton-group">
                    <?php if ($paging->next) : ?>
                        <a href="<?= site_url("analisis_indikator/index/{$paging->next}/{$o}") ?>" class="uibutton">Next</a>
                    <?php endif; ?>
                    <?php if ($paging->end_link) : ?>
                        <a href="<?= site_url("analisis_indikator/index/{$paging->end_link}/{$o}") ?>" class="uibutton">Akhir</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
