<script>
    $(function() {
        var keyword = <?= $keyword ?>;
        $("#cari").autocomplete({
            source: keyword
        });
    });
</script>
<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <td class="side-menu">
                <fieldset>
                    <div class="lmenu">
                        <ul>
                            <li><a href="<?= site_url('sms/kontak') ?>">Daftar Kontak</a></li>
                            <li class="selected"><a href="<?= site_url('sms/group') ?>">Group Kontak</a></li>
                        </ul>
                    </div>
                </fieldset>

            </td>
            </td>
            <td style="background:#fff;padding:5px;">
                <div class="content-header">
                    <h3>Manajemen Group Kontak</h3>
                </div>
                <div id="contentpane">
                    <form id="mainform" name="mainform" action="" method="post">
                        <div class="ui-layout-north panel">
                            <div class="left">
                                <div class="uibutton-group">
                                    <a href="<?= site_url('sms/form_grup/0') ?>" class="uibutton tipsy south" title="Tambah Data" target="ajax-modal" rel="window" header="Tambah Grup"><span class="icon-plus-sign icon-large">&nbsp;</span>Tambah Group</a>
                                    <button type="button" title="Hapus Data" onclick="deleteAllBox('mainform','<?= site_url('sms/delete_all_grup') ?>')" class="uibutton tipsy south"><span class="icon-trash icon-large">&nbsp;</span>Hapus Data
                                </div>
                            </div>
                        </div>
                        <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                            <div class="table-panel top">
                                <div class="right">
                                    <input name="cari_grup" id="cari" type="text" class="inputbox help tipped" size="20" value="<?= $cari_grup ?>" title="Cari.." onkeypress="if (event.keyCode == 13) {$('#'+'mainform').attr('action','<?= site_url('sms/search_grup') ?>');$('#'+'mainform').submit();}" />
                                    <button type="button" onclick="$('#'+'mainform').attr('action','<?= site_url('sms/search_grup') ?>');$('#'+'mainform').submit();" class="uibutton tipsy south" title="Cari Data"><span class="icon-search icon-large">&nbsp;</span>Cari</button>
                                </div>
                            </div>
                            <table class="list">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="5%"><input type="checkbox" class="checkall" /></th>
                                        <th width="10%">Aksi</th>
                                        <th>Nama Group</th>
                                        <th width="10%">Jumlah Anggota</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;

                                    foreach ($main as $data) : ?>
                                        <tr>
                                            <td align="center" width="2"><?= $no ?></td>
                                            <td align="center" width="5">
                                                <input type="checkbox" name="id_cb[]" value="<?= $data['nama_grup'] ?>" />
                                            </td>
                                            <td align="center">
                                                <div class="uibutton-group">
                                                    <a href="<?= site_url("sms/form_grup/{$data['nama_grup']}") ?>" class="uibutton tipsy south" title="Ubah Data" target="ajax-modal" rel="window" header="Ubah Data"><span class="icon-edit icon-large"> Ubah</span></a>
                                                    <a href="<?= site_url("sms/grup_delete/{$data['nama_grup']}") ?>" class="uibutton tipsy south" title="Hapus Data" target="confirm" message="Apakah Anda Yakin?" header="Hapus Data"><span class="icon-trash icon-large"></span></a>
                                                    <a href="<?= site_url("sms/anggota/{$data['nama_grup']}") ?>" class="uibutton tipsy south" title="Rincian Anggota"><span class="icon-list icon-large"></span></a>
                                                </div>
                                            </td>
                                            <td><?= $data['nama_grup'] ?></td>
                                            <td align="center"><?= $data['jumlah_kontak'] ?></td>
                                        </tr>
                                    <?php $no++;
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <div class="ui-layout-south panel bottom">
                        <div class="left">
                            <div class="table-info">
                                <form id="paging" action="<?= site_url('sms/group') ?>" method="post">
                                    <label>Tampilkan</label>
                                    <select name="per_page" onchange="$('#paging').submit()">
                                        <option value="20" <?php selected($per_page, 20); ?>>20</option>
                                        <option value="50" <?php selected($per_page, 50); ?>>50</option>
                                        <option value="100" <?php selected($per_page, 100); ?>>100</option>
                                    </select>
                                    <label>Dari</label>
                                    <label><strong><?= $paging->num_rows ?></strong></label>
                                    <label>Total Data</label>
                                </form>
                            </div>
                        </div>
                        <div class="right">
                            <div class="uibutton-group">
                                <?php if ($paging->start_link) : ?>
                                    <a href="<?= site_url("sms/group/{$paging->start_link}/{$o}") ?>" class="uibutton">Awal</a>
                                <?php endif; ?>
                                <?php if ($paging->prev) : ?>
                                    <a href="<?= site_url("sms/group/{$paging->prev}/{$o}") ?>" class="uibutton">Prev</a>
                                <?php endif; ?>
                            </div>
                            <div class="uibutton-group">

                                <?php for ($i = $paging->start_link; $i <= $paging->end_link; $i++) : ?>
                                    <a href="<?= site_url("sms/group/{$i}/{$o}") ?>" <?php jecho($p, $i, "class='uibutton special'") ?> class="uibutton"><?= $i ?></a>
                                <?php endfor; ?>
                            </div>
                            <div class="uibutton-group">
                                <?php if ($paging->next) : ?>
                                    <a href="<?= site_url("sms/group/{$paging->next}/{$o}") ?>" class="uibutton">Next</a>
                                <?php endif; ?>
                                <?php if ($paging->end_link) : ?>
                                    <a href="<?= site_url("sms/group/{$paging->end_link}/{$o}") ?>" class="uibutton">Akhir</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
