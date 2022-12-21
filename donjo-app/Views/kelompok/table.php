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
            <td class="side-menu">
                <fieldset>
                    <legend>Kategori Kelompok</legend>
                    <div id="sidecontent3" class="lmenu">
                        <ul>
                            <?php
	foreach($list_master AS $data){
	?>
                            <li <?php if($filter == $data['id'])echo "class='selected'";?>>
                                <a href="<?php echo site_url("kelompok/to_master/$data[id]")?>">
                                    <?php echo $data['kelompok']; ?>
                                </a>
                            </li>
                            <?php }?>
                            <li>

                                <a href="<?php echo site_url('kelompok_master/clear')?>" class="uibutton tipsy south" title="Kategori Kelompok">
                                    <span class="fa fa-cogs">&nbsp;</span>Kelola Kategori Kelompok</a>
                            </li>
                        </ul>
                </fieldset>
            </td>

            <td style="background:#fff;padding:0px;">
                <div class="content-header">
                </div>
                <div id="contentpane">
                    <form id="mainform" name="mainform" action="" method="post">
                        <div class="ui-layout-north panel">
                            <h3>Modul kelompok</h3>
                            <div class="left">
                                <div class="uibutton-group">
                                    <a href="<?php echo site_url('kelompok/form')?>" class="uibutton tipsy south" title="Tambah Data"><span class="fa fa-plus">&nbsp;</span>Tambah Kelompok Baru</a>
                                    <button type="button" title="Hapus Data" onclick="deleteAllBox('mainform','<?php echo site_url("kelompok/delete_all/$p/$o")?>')" class="uibutton tipsy south"><span class="fa fa-trash-o">&nbsp;</span>Hapus Data</button>
                                    <a href="<?php echo site_url("kelompok/cetak")?>" class="uibutton" title="Cetak Data" target="_blank"><span class="fa fa-print">&nbsp;</span>Cetak</a>
                                    <a href="<?php echo site_url("kelompok/excel")?>" class="uibutton tipsy south" title="Unduh" target="_blank"><span class="fa fa-download">&nbsp;</span>Unduh</a>
                                </div>
                            </div>
                        </div>
                        <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                            <div class="table-panel top">
                                <div class="left">
                                    <select name="filter" onchange="formAction('mainform','<?php echo site_url('kelompok/filter')?>')">
                                        <option value="">-- Filter by master --</option>
                                        <?php foreach($list_master AS $data){?>
                                        <option value="<?php echo $data['id']?>" <?php if($filter == $data['id']) :?>selected<?php endif?>><?php echo $data['kelompok']?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="right">
                                    <input name="cari" id="cari" type="text" class="inputbox help tipped" size="20" value="<?php echo $cari?>" title="Cari.." onkeypress="if (event.keyCode == 13) {$('#'+'mainform').attr('action','<?php echo site_url('kelompok/search')?>');$('#'+'mainform').submit();}">
                                    <button type="button" onclick="$('#'+'mainform').attr('action','<?php echo site_url('kelompok/search')?>');$('#'+'mainform').submit();" class="uibutton tipsy south" title="Cari Data"><span class="fa fa-search">&nbsp;</span>Cari</button>
                                </div>
                            </div>
                            <table class="list">
                                <thead>
                                    <tr>
                                        <th width="10">No</th>
                                        <th><input type="checkbox" class="checkall"></th>
                                        <th width="150">Aksi</th>

                                        <?php if($o==4): ?>
                                        <th align="left"><a href="<?php echo site_url("kelompok/index/$p/3")?>">Nama Kelompok<span class="ui-icon ui-icon-triangle-1-n">&nbsp;</span></a></th>
                                        <?php elseif($o==3): ?>
                                        <th align="left"><a href="<?php echo site_url("kelompok/index/$p/4")?>">Nama Kelompok<span class="ui-icon ui-icon-triangle-1-s">&nbsp;</span></a></th>
                                        <?php else: ?>
                                        <th align="left"><a href="<?php echo site_url("kelompok/index/$p/3")?>">Nama Kelompok<span class="ui-icon ui-icon-triangle-2-n-s">&nbsp;</span></a></th>
                                        <?php endif; ?>

                                        <th width="100">Ketua Kelompok</th>
                                        <?php if($o==6): ?>
                                        <th align="left" width='170'><a href="<?php echo site_url("kelompok/index/$p/5")?>">Kategori Kelompok<span class="ui-icon ui-icon-triangle-1-n">&nbsp;</span></a></th>
                                        <?php elseif($o==5): ?>
                                        <th align="left" width='170'><a href="<?php echo site_url("kelompok/index/$p/6")?>">Kategori Kelompok<span class="ui-icon ui-icon-triangle-1-s">&nbsp;</span></a></th>
                                        <?php else: ?>
                                        <th align="left" width='170'><a href="<?php echo site_url("kelompok/index/$p/5")?>">Kategori Kelompok<span class="ui-icon ui-icon-triangle-2-n-s">&nbsp;</span></a></th>
                                        <?php endif; ?>

                                        <th width="100">Jumlah Anggota</th>
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
                                                <a href="<?php echo site_url("kelompok/anggota/$data[id]")?>" class="uibutton"><span class="fa fa-list"> Rincian </span></a><a href="<?php echo site_url("kelompok/form/$p/$o/$data[id]")?>" class="uibutton tipsy south" title="Ubah Data"><span class="fa fa-pencil"> Ubah </span></a><a href="<?php echo site_url("kelompok/delete/$p/$o/$data[id]")?>" class="uibutton tipsy south" title="Hapus Data" target="confirm" message="Apakah Anda Yakin?" header="Hapus Data"><span class="fa fa-trash-o"></span></a>
                                            </div>
                                        </td>
                                        <td><?php echo $data['nama']?></td>
                                        <td><?php echo $data['ketua']?></td>
                                        <td><?php echo $data['master']?></td>
                                        <td><?php echo $data['jml_anggota']?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <div class="ui-layout-south panel bottom">
                        <div class="left">
                            <div class="table-info">
                                <form id="paging" action="<?php echo site_url('kelompok')?>" method="post">
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
                                <a href="<?php echo site_url("kelompok/index/$paging->start_link/$o")?>" class="uibutton">Awal</a>
                                <?php endif; ?>
                                <?php if($paging->prev): ?>
                                <a href="<?php echo site_url("kelompok/index/$paging->prev/$o")?>" class="uibutton">Prev</a>
                                <?php endif; ?>
                            </div>
                            <div class="uibutton-group">

                                <?php for($i=$paging->start_link;$i<=$paging->end_link;$i++): ?>
                                <a href="<?php echo site_url("kelompok/index/$i/$o")?>" <?php jecho($p,$i,"class='uibutton special'")?> class="uibutton"><?php echo $i?></a>
                                <?php endfor; ?>
                            </div>
                            <div class="uibutton-group">
                                <?php if($paging->next): ?>
                                <a href="<?php echo site_url("kelompok/index/$paging->next/$o")?>" class="uibutton">Next</a>
                                <?php endif; ?>
                                <?php if($paging->end_link): ?>
                                <a href="<?php echo site_url("kelompok/index/$paging->end_link/$o")?>" class="uibutton">Akhir</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
