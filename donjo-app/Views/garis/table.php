<script>
    $(function() {
        var keyword = <?php echo $keyword?>;
        $("#cari").autocomplete({
            source: keyword
        });
    });

</script>
<script src="<?php echo base_url('assets/js/chosen/chosen.jquery.js') ?>"></script>
<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <?php
?>
            <td style="background:#fff;padding:0px;">
                <div class="content">
                    <h3>Manajemen Properti / garis</h3>
                    <div style="padding:1em;margin:1em 0;border:solid 1px #c00;background:#fee;color:#c00;">Modul ini masih dalam tahap pengembangan. Ide-ide dan usulan mari kita kumpulkan untuk memperkaya khazanah SID</div>
                </div>
                <div id="contentpane">
                    <form id="mainform" name="mainform" action="" method="post">
                        <div class="ui-layout-north panel">
                            <div class="left">
                                <div class="uibutton-group">
                                    <a href="<?php echo site_url("garis/form")?>" class="uibutton tipsy south" title="Tambah Data"><span class="ui-icon ui-icon-plus">&nbsp;</span>Tambah Data Baru</a>
                                    <button type="button" title="Delete Data" onclick="deleteAllBox('mainform','<?php echo site_url("garis/delete_all/$p/$o")?>')" class="uibutton tipsy south"><span class="ui-icon ui-icon-trash">&nbsp;</span>Delete Data
                                </div>
                            </div>
                        </div>
                        <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                            <div class="table-panel top">
                                <div class="left">

                                    <select name="filter" onchange="formAction('mainform','<?php echo site_url('plan/garis/filter')?>')">
                                        <option value="">Semua</option>
                                        <option value="1" <?php if($filter==1) :?>selected<?php endif?>>Enabled</option>
                                        <option value="2" <?php if($filter==2) :?>selected<?php endif?>>Disabled</option>
                                    </select>
                                    <select name="line" onchange="formAction('mainform','<?php echo site_url('plan/garis/line')?>')">
                                        <option value="">Kategori</option>
                                        <?php foreach($list_line AS $data){?>
                                        <option value="<?php echo $data['id']?>" <?php if($line == $data['id']) :?>selected<?php endif?>><?php echo $data['nama']?></option>
                                        <?php }?>
                                    </select>

                                    <select name="subline" onchange="formAction('mainform','<?php echo site_url('plan/garis/subline')?>')">
                                        <option value="">Jenis</option>
                                        <?php foreach($list_subline AS $data){?>
                                        <option value="<?php echo $data['id']?>" <?php if($subline == $data['id']) :?>selected<?php endif?>><?php echo $data['nama']?></option>
                                        <?php }?>
                                    </select>

                                </div>
                                <div class="right">
                                    <input name="cari" id="cari" type="text" class="inputbox help tipped" size="20" value="<?php echo $cari?>" title="Search..">
                                    <button type="button" onclick="$('#'+'mainform').attr('action','<?php echo site_url('plan/garis/search')?>');$('#'+'mainform').submit();" class="uibutton tipsy south" title="Cari Data"><span class="ui-icon ui-icon-search">&nbsp;</span>Search</button>
                                </div>
                            </div>
                            <table class="list">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th><input type="checkbox" class="checkall"></th>
                                        <th width="50">Aksi</th>
                                        <?php if($o==2): ?>
                                        <th align="left"><a href="<?php echo site_url("garis/index/$p/1")?>">Kategori<span class="ui-icon ui-icon-triangle-1-n">
                                                    <?php elseif($o==1): ?>
                                        <th align="left"><a href="<?php echo site_url("garis/index/$p/2")?>">Kategori<span class="ui-icon ui-icon-triangle-1-s">
                                                    <?php else: ?>
                                        <th align="left"><a href="<?php echo site_url("garis/index/$p/1")?>">Kategori<span class="ui-icon ui-icon-triangle-2-n-s">
                                                    <?php endif; ?>&nbsp;</span></a></th>
                                        <?php if($o==4): ?>
                                        <th align="left"><a href="<?php echo site_url("garis/index/$p/3")?>">Aktif<span class="ui-icon ui-icon-triangle-1-n">
                                                    <?php elseif($o==3): ?>
                                        <th align="left"><a href="<?php echo site_url("garis/index/$p/4")?>">Aktif<span class="ui-icon ui-icon-triangle-1-s">
                                                    <?php else: ?>
                                        <th align="left"><a href="<?php echo site_url("garis/index/$p/3")?>">Aktif<span class="ui-icon ui-icon-triangle-2-n-s">
                                                    <?php endif; ?>&nbsp;</span></a></th>
                                        <th>Kategori</th>
                                        <th>Jenis</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($main as $data){?>
                                    <tr>
                                        <td align="center" width="2"><?php echo $data['no']?></td>
                                        <td align="center" width="5">
                                            <input type="checkbox" name="id_cb[]" value="<?php echo $data['id']?>">
                                        </td>
                                        <td>
                                            <a href="<?php echo site_url("garis/form/$p/$o/$data[id]")?>" class="ui-icons icon-edit tipsy south" title="Edit Data"></a><a href="<?php echo site_url("garis/delete/$p/$o/$data[id]")?>" class="ui-icons icon-remove tipsy south" title="Delete Data" target="confirm" message="Apakah Anda Yakin?" header="Hapus Data"></a><?php
?><a href="<?php echo site_url("garis/ajax_garis_maps/$p/$o/$data[id]")?>" target="ajax-modalz" rel="window" header="garis <?php echo $data['nama']?>" class="ui-icons icon-maps tipsy south" title="garis <?php echo $data['nama']?>"></a>
                                        </td>
                                        <td width="150"><?php echo $data['nama']?></td>
                                        <td width="50"><?php echo $data['aktif']?></td>
                                        <td width="220"><?php echo $data['kategori']?></td>
                                        <td width="150"><?php echo $data['jenis']?></td>
                                        <td></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <div class="ui-layout-south panel bottom">
                        <div class="left">
                            <div class="table-info">
                                <form id="paging" action="<?php echo site_url('plan/garis')?>" method="post">
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
                                <a href="<?php echo site_url("garis/index/$paging->start_link/$o")?>" class="uibutton">First</a>
                                <?php endif; ?>
                                <?php if($paging->prev): ?>
                                <a href="<?php echo site_url("garis/index/$paging->prev/$o")?>" class="uibutton">Prev</a>
                                <?php endif; ?>
                            </div>
                            <div class="uibutton-group">
                                <?php for($i=$paging->start_link;$i<=$paging->end_link;$i++): ?>
                                <a href="<?php echo site_url("garis/index/$i/$o")?>" <?php jecho($p,$i,"class='uibutton special'")?> class="uibutton"><?php echo $i?></a>
                                <?php endfor; ?>
                            </div>
                            <div class="uibutton-group">
                                <?php if($paging->next): ?>
                                <a href="<?php echo site_url("garis/index/$paging->next/$o")?>" class="uibutton">Next</a>
                                <?php endif; ?>
                                <?php if($paging->end_link): ?>
                                <a href="<?php echo site_url("garis/index/$paging->end_link/$o")?>" class="uibutton">Last</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
