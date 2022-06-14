<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <td style="background:#fff;padding:0px;">
                <div class="content-header">
                </div>
                <div id="contentpane">
                    <?= form_open('', ['id' => 'mainform', 'name' => 'mainform']) ?>
                        <div class="ui-layout-north panel">
                            <h3>Data Anggota - Kelompok <?= $kelompok['nama']; ?></h3>
                            <div class="left">
                                <div class="uibutton-group">
                                    <a href="<?= site_url('kelompok/clear') ?>" class="uibutton tipsy south" title="Kelompok"><span class="icon-list icon-large">&nbsp;</span>Kelompok</a>
                                    <a href="<?= site_url("kelompok/form_anggota/{$kel}") ?>" class="uibutton tipsy south" title="Tambah Data"><span class="icon-plus-sign icon-large">&nbsp;</span>Tambah Anggota Baru</a>
                                    <a href="<?= site_url("kelompok/cetak_a/{$kel}") ?>" class="uibutton" title="Cetak Data" target="_blank"><span class="icon-print icon-large">&nbsp;</span>Cetak</a>
                                    <a href="<?= site_url("kelompok/excel_a/{$kel}") ?>" class="uibutton tipsy south" title="Unduh" target="_blank"><span class="icon-file-text icon-large">&nbsp;</span>Unduh</a>
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
                                        <th width="10">No</th>
                                        <th width="120">Aksi</th>
                                        <th width="100">NIK</th>
                                        <th width="100">Nomor Anggota</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Umur (Tahun)</th>
                                        <th>Jenis Kelamin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($main as $data) : ?>
                                        <tr>
                                            <td align="center" width="2"><?= $data['no'] ?></td>
                                            <td>
                                                <div class="uibutton-group">
                                                    <a href="<?= site_url("kelompok/delete_a/{$kel}/{$data['id']}") ?>" class="uibutton tipsy south" title="Hapus Data" target="confirm" message="Apakah Anda Yakin?" header="Hapus Data"><span class="icon-trash icon-large"></span> Hapus</a>

                                                    <a href="<?= site_url("kelompok/form_anggota/{$kel}/{$data['id_penduduk']}") ?>" class="uibutton tipsy south" title="Ubah Data"><span class="icon-edit icon-large"></span> Ubah </a>
                                                </div>
                                            </td>
                                            <td><?= $data['nik'] ?></td>
                                            <td><?= $data['no_anggota'] ?></td>
                                            <td><?= $data['nama'] ?></td>
                                            <td><?= $data['alamat'] ?></td>
                                            <td><?= $data['umur'] ?></td>
                                            <td><?php if ($data['sex'] === 1) {
    echo 'Laki-laki';
} else {
    echo 'Perempuan';
} ?></td>
                                        </tr>
                                    <?php endforeach; ?>
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
            </td>
        </tr>
    </table>
</div>
