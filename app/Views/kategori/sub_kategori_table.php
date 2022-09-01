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
                            } ?>><a href="<?= site_url('kategori/index') ?>">Kategori/ Menu Dinamis</a></li>
                        </ul>
                    </div>
                </fieldset>
            </td>
            <td style="background:#fff;padding:0px;">
                <div class="content-header">
                    <h3>Manajemen Sub kategori</h3>
                </div>
                <div id="contentpane">
                    <?= form_open('', ['id' => 'mainform', 'name' => 'mainform']) ?>
                        <div class="ui-layout-north panel">
                            <div class="left">
                                <div class="uibutton-group">
                                    <a href="<?= site_url("kategori/ajax_add_sub_kategori/{$kategori}") ?>" target="ajax-modal" rel="window" header="Tambah Sub kategori" class="uibutton tipsy south" title="Tambah Sub kategori"><span class="icon-plus icon-large">&nbsp;</span>Tambah Sub Kategori Baru</a>
                                    <button type="button" title="Delete Data" onclick="deleteAllBox('mainform','<?= site_url("kategori/delete_all_sub_kategori/{$kategori}") ?>')" class="uibutton tipsy south"><span class="icon-trash icon-large">&nbsp;</span>Hapus Data
                                </div>
                            </div>
                        </div>
                        <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                            <div class="table-panel top">
                                <div class="left">
                                </div>
                                <div class="right">
                                </div>
                            </div>
                            <table class="list">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th><input type="checkbox" class="checkall" /></th>
                                        <th width="120">Aksi</th>
                                        <th align="center">Kategori</th>
                                        <th align="center">Enabled</th>
                                        <th>Link</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($subkategori as $data) { ?>
                                        <tr>
                                            <td align="center" width="2"><?= $data['no'] ?></td>
                                            <td align="center" width="5">
                                                <input type="checkbox" name="id_cb[]" value="<?= $data['id'] ?>" />
                                            </td>
                                            <td>
                                                <div class="uibutton-group">
                                                    <a href="<?= site_url("kategori/ajax_add_sub_kategori/{$kategori}/{$data['id']}") ?>" class="uibutton tipsy south" target="ajax-modal" rel="window" header="Edit kategori" title="Edit Data"><span class="icon-edit icon-large"> Edit </span></a><a href="<?= site_url("kategori/delete_sub_kategori/{$kategori}/{$data['id']}") ?>" class="uibutton tipsy south" title="Delete Data" target="confirm" message="Apakah Anda Yakin?" header="Hapus Data"><span class="icon-trash icon-large"></span></a><?php if ($data['enabled'] === '2') : ?><a href="<?= site_url("kategori/kategori_lock_sub_kategori/{$kategori}/{$data['id']}") ?>" class="uibutton tipsy south" title="Enable kategori"><span class="icon-lock icon-large"></span></a><?php elseif ($data['enabled'] === '1') : ?><a href="<?= site_url("kategori/kategori_unlock_sub_kategori/{$kategori}/{$data['id']}") ?>" class="uibutton tipsy south" title="Disable kategori"><span class="icon-unlock icon-large"></span></a><?php endif; ?>
                                                </div>
                                            </td>
                                            <td><?= $data['kategori'] ?></td>
                                            <td><?= $data['aktif'] ?></td>
                                            <td><?= '-' ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?= form_close() ?>
                    <div class="ui-layout-south panel bottom">
                        <div class="left">
                            <a href="<?= site_url() ?>/kategori/index/" class="uibutton icon prev">Kembali</a>
                        </div>
                        <div class="right">
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
