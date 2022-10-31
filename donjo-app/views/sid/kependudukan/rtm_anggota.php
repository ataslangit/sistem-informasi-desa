<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <td style="background:#fff;padding:0px;">
                <div id="contentpane">
                    <div class="content-header">
                    </div>
                    <form id="mainform" name="mainform" action="" method="post">
                        <div class="ui-layout-north panel">
                            <h3>Daftar Anggota Rumah Tangga : <?php echo $kepala_kk['nama']?> - <?php echo $kepala_kk['no_kk']?></h3>
                            <div class="left">
                                <div class="uibutton-group">
                                    <a href="<?php echo site_url("rtm/ajax_add_anggota/$p/$o/$kk")?>" class="uibutton tipsy south" title="Tambah Data" target="ajax-modalx" rel="window"><span class="fa fa-plus">&nbsp;</span>Tambah Anggota</a>
                                    <button type="button" title="Hapus Data" onclick="deleteAllBox('mainform','<?php echo site_url("rtm/delete_all_anggota/$p/$o/$kk")?>')" class="uibutton tipsy south"><span class="fa fa-trash-o">&nbsp;</span>Hapus Data</button>
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
                                        <th width='100'>Nomor KK</th>
                                        <th>Nama</th>
                                        <th width='50'>Jenis Kelamin</th>
                                        <th width="120">Hubungan</th>
                                        <th>Nama Ayah</th>
                                        <th>Nama Ibu</th>
                                        <th>Alamat</th>

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
                                                <a href="<?php echo site_url("rtm/delete_anggota/$p/$o/$kk/$data[id]")?>" class="uibutton tipsy south" title="Hapus dari Rumah Tangga" target="confirm" message="Apakah Anda Yakin?" header="Hapus"><span class="fa fa-minus"></span> Hapus</a>
                                                <a href="<?php echo site_url("rtm/edit_anggota/$p/$o/$kk/$data[id]")?>" class="uibutton tipsy south" title="Ubah Hubungan Rumah Tangga" target="ajax-modal" rel="window" header="Ubah Data"><span class="fa fa-link"></span></a>
                                            </div>
                                        </td>
                                        <td><label><?php echo $data['nik']?></label></td>
                                        <td><label><?php echo $data['no_kk']?></label></td>
                                        <td><label><?php echo strtoupper(unpenetration($data['nama']))?></label></td>

                                        <td><?php echo $data['sex']?></td>
                                        <td><?php echo $data['hubungan']?></td>
                                        <td><?php echo $data['nama_ayah']?></td>
                                        <td><?php echo $data['nama_ibu']?></td>
                                        <td><?php echo unpenetration($data['alamat'])?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <div class="ui-layout-south panel bottom">
                        <div class="left">
                            <a href="<?php echo site_url("rtm/index/$p/$o")?>" class="uibutton icon prev">Kembali</a>
                        </div>
                        <div class="right">
                            <a href="<?php echo site_url("rtm/kartu_rtm/$p/$o/$kk")?>" class="uibutton confirm icon next">Kartu Rumah Tangga</a>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
