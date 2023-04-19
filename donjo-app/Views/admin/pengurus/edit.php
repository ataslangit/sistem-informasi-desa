<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>

<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <td style="background:#fff;padding:0px;">
                <div class="content-header">
                </div>
                <div id="contentpane">
                    <div class="ui-layout-north panel">
                        <h3>Form Perangkat Desa</h3>
                    </div>
                    <?= form_open(route_to('admin.pengurus.update'), ['id' => 'validasi'], ['pamong_id' => $pamong['pamong_id']]) ?>
                        <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                            <table class="form">
                                <tr>
                                    <th>Nama</th>
                                    <td>
                                        <?= form_input([
                                            'name' => 'pamong_nama',
                                            'class' => 'inputbox required',
                                            'required' => true,
                                        ], set_value('pamong_nama', $pamong['pamong_nama'], false)) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>NIP</th>
                                    <td>
                                        <?= form_input([
                                            'name' => 'pamong_nip',
                                            'class' => 'inputbox required',
                                            'required' => true,
                                        ], set_value('pamong_nip', $pamong['pamong_nip'])) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>NIK</th>
                                    <td>
                                        <?= form_input([
                                            'name' => 'pamong_nik',
                                            'class' => 'inputbox required',
                                            'required' => true,
                                        ], set_value('pamong_nik', $pamong['pamong_nik'])) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jabatan</th>
                                    <td>
                                        <?= form_input([
                                            'name' => 'jabatan',
                                            'class' => 'inputbox required',
                                            'required' => true,
                                        ], set_value('jabatan', $pamong['jabatan'])) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="100">Status</th>
                                    <td>
                                        <div class="uiradio">
                                            <?= form_radio([
                                                'name' => 'pamong_status',
                                                'id' => 'group1'
                                            ], '1', set_radio('pamong_status', '1', ($pamong['pamong_status'] === '1'))) ?>
                                            <label for="group1">Aktif</label>
                                            <?= form_radio([
                                                'name' => 'pamong_status',
                                                'id' => 'group2'
                                            ], '2', set_radio('pamong_status', '2', ($pamong['pamong_status'] === '2'))) ?>
                                            <label for="group2">Tidak Aktif</label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="ui-layout-south panel bottom">
                            <div class="left">
                                <a href="<?= site_url(route_to('admin.pengurus.index')) ?>" class="uibutton icon prev">Kembali</a>
                            </div>
                            <div class="right">
                                <div class="uibutton-group">
                                    <button class="uibutton confirm" type="submit">Simpan</button>
                                </div>
                            </div>
                        </div>
                    <?= form_close() ?>
                </div>
            </td>
        </tr>
    </table>
</div>

<?= $this->endSection() ?>
