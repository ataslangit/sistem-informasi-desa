<div class="content-header">
    <h3>Wilayah administratif</h3>
</div>
<div id="contentpane" id="mainform">
    <form id="mainform" name="mainform" action="" method="post">
        <div class="ui-layout-north panel">
            <div class="left">
                <div class="uibutton-group">
                    <a href="<?php echo site_url('admin_home/form')?>" class="uibutton tipsy south" title="Tambah Data"><span class="ui-icon ui-icon-plus">&nbsp;</span>Tambah Pengurus Desa</a>
                    <button type="button" title="Delete Data" onclick="deleteAllBox('mainform','<?php echo site_url("admin_home/delete_all/$p/$o")?>')" class="uibutton tipsy south"><span class="ui-icon ui-icon-trash">&nbsp;</span>Delete Data
                </div>
            </div>
        </div>
        <div class="ui-layout-center" id="mainform" style="padding: 5px;">
            <div class="table-panel top">
                <div class="left">
                </div>
                <div class="right">
                    <input name="cari" id="cari" type="text" class="inputbox help tipped" size="20" value="<?php echo $cari?>" title="Search..">
                    <button type="button" onclick="$('#'+'mainform').attr('action','<?php echo site_url('admin_home/search')?>');$('#'+'mainform').submit();" class="uibutton tipsy south" title="Cari Data"><span class="ui-icon ui-icon-search">&nbsp;</span>Search</button>
                </div>
            </div>
            <table class="list">
                <thead>
                    <tr>
                        <th>No</th>
                        <th><input type="checkbox" class="checkall"></th>
                        <th width="35">Aksi</th>
                        <th>Nama</th>
                        <th>Jabatab</th>
                        <th>N.I.P</th>
                        <th>No. Telepon</th>
                        <th>Alamat</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach($main as $data): ?>
                    <tr>
                        <td align="center" width="2"><?php echo $data['no']?></td>
                        <td align="center" width="5">
                            <?php if($data['username']!='admin') :?>
                            <input type="checkbox" name="id_cb[]" value="<?php echo $data['id']?>">
                            <?php endif; ?>
                        </td>
                        <td width="5">
                            <a href="<?php echo site_url("admin_home/form/$p/$o/$data[id]")?>" class="ui-icons icon-edit tipsy south" title="Edit Data"></a><?php if($data['username']!='admin'){?><a href="<?php echo site_url("admin_home/delete/$p/$o/$data[id]")?>" class="ui-icons icon-remove tipsy south" title="Delete Data" target="confirm" message="Apakah Anda Yakin?" header="Hapus Data"></a>
                            <?php }?>
                        </td>
                        <td><?php echo $data['nama']?></td>
                        <td><?php echo $data['grup']?></td>
                        <td><?php echo $data['phone']?></td>
                        <td><?php echo tgl_indo($data['last_login'])?></td>
                        <td><?php echo $data['nama']?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </form>
    <div class="ui-layout-south panel bottom">
        <div class="left">
            <div class="table-info">
                <form id="paging" action="<?php echo site_url('admin_home')?>" method="post">
                    <label>Tampilkan</label>
                    <select name="per_page" onchange="$('#paging').submit()">
                        <option value="20" <?php selected($per_page,20); ?>>20</option>
                        <option value="50" <?php selected($per_page,50); ?>>50</option>
                        <option value="100" <?php selected($per_page,100); ?>>100</option>
                    </select>
                    <label>Dari</label>
                    <label><strong><?php echo $paging->num_rows?></strong></label>
                    <label>Total Data</label>
                </form>
            </div>
        </div>
        <div class="right">
            <div class="uibutton-group">
                <?php if($paging->start_link): ?>
                <a href="<?php echo site_url("admin_home/index/$paging->start_link/$o")?>" class="uibutton">First</a>
                <?php endif; ?>
                <?php if($paging->prev): ?>
                <a href="<?php echo site_url("admin_home/index/$paging->prev/$o")?>" class="uibutton">Prev</a>
                <?php endif; ?>
            </div>
            <div class="uibutton-group">

                <?php for($i=$paging->start_link;$i<=$paging->end_link;$i++): ?>
                <a href="<?php echo site_url("admin_home/index/$i/$o")?>" <?php jecho($p,$i,"class='uibutton special'")?> class="uibutton"><?php echo $i?></a>
                <?php endfor; ?>
            </div>
            <div class="uibutton-group">
                <?php if($paging->next): ?>
                <a href="<?php echo site_url("admin_home/index/$paging->next/$o")?>" class="uibutton">Next</a>
                <?php endif; ?>
                <?php if($paging->end_link): ?>
                <a href="<?php echo site_url("admin_home/index/$paging->end_link/$o")?>" class="uibutton">Last</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
