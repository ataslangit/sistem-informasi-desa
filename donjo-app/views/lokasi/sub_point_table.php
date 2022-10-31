<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <?php 
?>
            <td style="background:#fff;padding:0px;">
                <div class="content-header">
                    <h3>Manajemen Sub lokasi</h3>
                    <div style="padding:1em;margin:1em 0;border:solid 1px #c00;background:#fee;color:#c00;">Modul ini masih dalam tahap pengembangan. Ide-ide dan usulan mari kita kumpulkan untuk memperkaya khazanah SID</div>
                </div>
                <div id="contentpane">
                    <form id="mainform" name="mainform" action="" method="post">
                        <div class="ui-layout-north panel">
                            <div class="left">
                                <div class="uibutton-group">
                                    <a href="<?php echo site_url("plan/ajax_add_sub_lokasi/$lokasi")?>" target="ajax-modal" rel="window" header="Tambah Sub lokasi" class="uibutton tipsy south" title="Tambah Sub lokasi"><span class="ui-icon ui-icon-plus">&nbsp;</span>Tambah lokasi Baru</a>
                                    <button type="button" title="Delete Data" onclick="deleteAllBox('mainform','<?php echo site_url("plan/delete_all/")?>')" class="uibutton tipsy south"><span class="ui-icon ui-icon-trash">&nbsp;</span>Delete Data
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
                                        <th width="50">Aksi</th>
                                        <th align="center">Nama</th>
                                        <th align="center">Enabled</th>
                                        <th>Simbol</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($sublokasi as $data){?>
                                    <tr>
                                        <td align="center" width="2"><?php echo $data['no']?></td>
                                        <td align="center" width="5">
                                            <input type="checkbox" name="id_cb[]" value="<?php echo $data['id']?>">
                                        </td>
                                        <td>
                                            <a href="<?php echo site_url("plan/ajax_add_sub_lokasi/$lokasi/$data[id]")?>" class="ui-icons icon-edit tipsy south" target="ajax-modal" rel="window" header="Edit lokasi" title="Edit Data"></a><a href="<?php echo site_url("plan/delete_sub_lokasi/$lokasi/$data[id]")?>" class="ui-icons icon-remove tipsy south" title="Delete Data" target="confirm" message="Apakah Anda Yakin?" header="Hapus Data"></a><?php if($data['enabled'] == '2'):?><a href="<?php echo site_url("lokasi_lock_sub_lokasi/$lokasi/$data[id]")?>" class="ui-icons icon-lock tipsy south" title="Enable lokasi"></a><?php elseif($data['enabled'] == '1'): ?><a href="<?php echo site_url("lokasi_unlock_sub_lokasi/$lokasi/$data[id]")?>" class="ui-icons icon-unlock tipsy south" title="Disable lokasi"></a><?php endif;?>
                                        </td>
                                        <td width="150"><?php echo $data['nama']?></td>
                                        <td width="50"><?php echo $data['aktif']?></td>
                                        <td align="center" width="50"><img src="<?php echo base_url("assets/files/gis/lokasi")?>/<?php echo $data['simbol']?>"></td>
                                        <td></td>
                                        <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <div class="ui-layout-south panel bottom">
                        <div class="left">
                            <a href="<?php echo site_url()?>plan/index/1" class="uibutton icon prev">Kembali</a>
                        </div>
                        <div class="right">
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
