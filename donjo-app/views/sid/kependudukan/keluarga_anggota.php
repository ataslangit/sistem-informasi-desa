<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <td style="background:#fff;padding:0px;">
                <div id="contentpane">
                    <div class="content-header">
                    </div>
                    <form id="mainform" name="mainform" action="" method="post">
                        <div class="ui-layout-north panel">
                            <h3>Daftar Anggota KK No.<?php echo $kepala_kk['no_kk']?> - Kepala Keluarga : <?php echo unpenetration($kepala_kk['nama'])?></h3>
                            <div class="left">
                                <div class="uibutton-group">
                                    <a href="<?php echo site_url("keluarga/form_a/$p/$o/$kk")?>" class="uibutton tipsy south" header="Tambah Anggota Keluarga" title="Tambah Data"><span class="fa fa-plus">&nbsp;</span>Tambah Anggota Baru</a>

                                    <a href="<?php echo site_url("keluarga/ajax_add_anggota/$p/$o/$kk")?>" class="uibutton tipsy south" header="Tambah Anggota Keluarga" title="Tambah Data" target="ajax-modalx" rel="window"><span class="fa fa-plus">&nbsp;</span>Tambah Anggota</a>
                                    <button type="button" title="Hapus Data" onclick="deleteAllBox('mainform','<?php echo site_url("keluarga/delete_all_anggota/$p/$o/$kk")?>')" class="uibutton tipsy south"><span class="fa fa-trash-o">&nbsp;</span>Hapus Data</button>
                                    <?php
?>
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
                                        <th><input type="checkbox" class="checkall"></th>
                                        <th width="80">Aksi</th>
                                        <th width='100'>NIK</th>
                                        <th width='150'>Nama</th>
                                        <th width='150'>Alamat</th>
                                        <th width="150">Hubungan</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($main as $data): ?>
                                    <tr>
                                        <td align="center" width="2"><?php echo $data['no']?></td>
                                        <td align="center" width="5">
                                            <input type="checkbox" name="id_cb[]" value="<?php echo $data['id']?>">
                                        </td>
                                        <td>
                                            <div class="uibutton-group">
                                                <a href="<?php echo site_url("penduduk/form/$p/$o/$data[id]")?>" class="uibutton tipsy south" title="Ubah Data"><span class="fa fa-pencil"> Ubah </span></a>
                                                <a href="<?php echo site_url("keluarga/delete_anggota/$p/$o/$kk/$data[id]")?>" class="uibutton tipsy south" title="Pecah KK" target="confirm" message="Apakah Anda Yakin?" header="Pecah KK"><span class="fa fa-minus"></span></a>
                                                <?php if($data['kk_level']!=0){?>
                                                <a href="<?php echo site_url("keluarga/edit_anggota/$p/$o/$kk/$data[id]")?>" class="uibutton tipsy south" title="Ubah Hubungan Keluarga" target="ajax-modal" rel="window" header="Ubah Data"><span class="fa fa-link"></span></a>
                                                <?php }?>
                                            </div>
                                        </td>
                                        <td><a href="<?php echo site_url("penduduk/detail/$p/$o/$data[id]")?>"><?php echo $data['nik']?></td>
                                        <td><a href="<?php echo site_url("penduduk/detail/$p/$o/$data[id]")?>"><?php echo strtoupper(unpenetration($data['nama']))?></a></td>

                                        <td><?php echo unpenetration($data['alamat'])?></td>
                                        <td><?php echo $data['hubungan']?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <div class="ui-layout-south panel bottom">
                        <div class="left">
                            <a href="<?php echo site_url("keluarga/index/$p/$o")?>" class="uibutton icon prev">Kembali</a>
                        </div>
                        <div class="right">
                            <a href="<?php echo site_url("keluarga/kartu_keluarga/$p/$o/$kk")?>" class="uibutton confirm icon next">Kartu Keluarga</a>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
