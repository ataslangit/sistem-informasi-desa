<script>
    $(function() {
        var keyword = <?php echo $keyword?>;
        $("#cari").autocomplete({
            source: keyword
        });
    });

</script>
<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <td style="background:#fff;padding:0px;">
                <div class="content">
                    <h3>Pengelolaan Kategori</h3>
                    <?php
	?>
                </div>
                <div id="contentpane">
                    <form id="mainform" name="mainform" action="" method="post">
                        <div class="ui-layout-north panel">
                            <div class="left">
                                <div class="uibutton-group">
                                    <a href="<?php echo site_url("kategori/form")?>" class="uibutton tipsy south" title="Tambah Data"><span class="fa fa-plus">&nbsp;</span>Tambah kategori Baru</a>
                                    <button type="button" title="Hapus Data" onclick="deleteAllBox('mainform','<?php echo site_url("kategori/delete_all/$p/$o")?>')" class="uibutton tipsy south"><span class="fa fa-trash-o">&nbsp;</span>Hapus Data
                                </div>
                            </div>
                        </div>
                        <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                            <div class="table-panel top">
                                <div class="left">
                                    <select name="filter" onchange="formAction('mainform','<?php echo site_url('kategori/filter')?>')">
                                        <option value="">Semua</option>
                                        <option value="1" <?php if($filter==1) :?>selected<?php endif?>>Enabled</option>
                                        <option value="2" <?php if($filter==2) :?>selected<?php endif?>>Disabled</option>
                                    </select>
                                </div>
                                <div class="right">
                                    <input name="cari" id="cari" type="text" class="inputbox help tipped" size="20" value="<?php echo $cari?>" title="Cari.." onkeypress="if (event.keyCode == 13) {$('#'+'mainform').attr('action','<?php echo site_url("kategori/search")?>');$('#'+'mainform').submit();}">
                                    <button type="button" onclick="$('#'+'mainform').attr('action','<?php echo site_url("kategori/search")?>');$('#'+'mainform').submit();" class="uibutton tipsy south" title="Cari Data"><span class="fa fa-search">&nbsp;</span>Cari</button>
                                </div>
                            </div>
                            <table class="list">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th><input type="checkbox" class="checkall"></th>
                                        <th width="160">Aksi</th>
                                        <?php if($o==2): ?>
                                        <th align="left"><a href="<?php echo site_url("kategori/index/$p/1")?>">kategori<span class="ui-icon ui-icon-triangle-1-n">
                                                    <?php elseif($o==1): ?>
                                        <th align="left"><a href="<?php echo site_url("kategori/index/$p/2")?>">kategori<span class="ui-icon ui-icon-triangle-1-s">
                                                    <?php else: ?>
                                        <th align="left"><a href="<?php echo site_url("kategori/index/$p/1")?>">kategori<span class="ui-icon ui-icon-triangle-2-n-s">
                                                    <?php endif; ?>&nbsp;</span></a></th>
                                        <?php if($o==4): ?>
                                        <th align="left"><a href="<?php echo site_url("kategori/index/$p/3")?>">Enabled / Disabled<span class="ui-icon ui-icon-triangle-1-n">
                                                    <?php elseif($o==3): ?>
                                        <th align="left"><a href="<?php echo site_url("kategori/index/$p/4")?>">Enabled / Disabled<span class="ui-icon ui-icon-triangle-1-s">
                                                    <?php else: ?>
                                        <th align="left"><a href="<?php echo site_url("kategori/index/$p/3")?>">Enabled / Disabled<span class="ui-icon ui-icon-triangle-2-n-s">
                                                    <?php endif; ?>&nbsp;</span></a></th>
                                        <th>Link</th>
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
                                            <div class="uibutton-group">
                                                <a href="<?php echo site_url("kategori/sub_kategori/$data[id]")?>" class="uibutton tipsy south" title="Rincian Sub kategori"><span class="fa fa-list"> Rincian</span></a>
                                                <a href="<?php echo site_url("kategori/form/$data[id]")?>" class="uibutton tipsy south" title="Ubah Data"><span class="fa fa-pencil"></span></a>
                                                <a href="<?php echo site_url("kategori/delete/$data[id]")?>" class="uibutton tipsy south" title="Hapus Data" target="confirm" message="Apakah Anda Yakin?" header="Hapus Data"><span class="fa fa-trash-o"></span></a><?php if($data['enabled'] == '2'):?>
                                                <a href="<?php echo site_url("kategori/kategori_lock/".$data['id'])?>" title="Aktivasi kategori"><span class="fa fa-lock"></span></a><?php elseif($data['enabled'] == '1'): ?><a href="<?php echo site_url("kategori/kategori_unlock/".$data['id'])?>" class="uibutton tipsy south" title="Non-aktifkan kategori"><span class="fa fa-unlock"></span></a>
                                                <a href="<?php echo site_url("kategori/ajax_add_sub_kategori/$data[id]")?>" class="uibutton tipsy south" target="ajax-modal" rel="window" header="Tambah Sub kategori <?php echo $data['kategori']?>" class="uibutton tipsy south" title="Tambah Sub kategori"><span class="fa fa-plus"></span></a>
                                                <?php endif?>
                                            </div>
                                        </td>
                                        <td><?php echo $data['kategori']?></td>
                                        <td><?php echo $data['aktif']?></td>
                                        <td>-</td>
                                        <!--
<td><?php echo $data['link']?></td>
-->
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <div class="ui-layout-south panel bottom">
                        <div class="left">
                            <div class="table-info">
                                <form id="paging" action="<?php echo site_url('kategori')?>" method="post">
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
                                <a href="<?php echo site_url("kategori/index/$paging->start_link/$o")?>" class="uibutton">Awal</a>
                                <?php endif; ?>
                                <?php if($paging->prev): ?>
                                <a href="<?php echo site_url("kategori/index/$paging->prev/$o")?>" class="uibutton">Prev</a>
                                <?php endif; ?>
                            </div>
                            <div class="uibutton-group">
                                <?php for($i=$paging->start_link;$i<=$paging->end_link;$i++): ?>
                                <a href="<?php echo site_url("kategori/index/$i/$o")?>" <?php jecho($p,$i,"class='uibutton special'")?> class="uibutton"><?php echo $i?></a>
                                <?php endfor; ?>
                            </div>
                            <div class="uibutton-group">
                                <?php if($paging->next): ?>
                                <a href="<?php echo site_url("kategori/index/$paging->next/$o")?>" class="uibutton">Next</a>
                                <?php endif; ?>
                                <?php if($paging->end_link): ?>
                                <a href="<?php echo site_url("kategori/index/$paging->end_link/$o")?>" class="uibutton">Akhir</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
