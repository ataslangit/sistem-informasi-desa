<script>
    $(function() {
        var keyword = ""
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
                    <legend>Kategori Artikel</legend>
                    <div id="sidecontent3" class="lmenu">
                        <ul>
                            <?php
	foreach($list_kategori AS $data){
	?>
                            <li <?php if($cat == $data['id'])echo "class='selected'";?>>
                                <a href="<?php echo site_url("web/index/$data[id]")?>">
                                    <?php
			if($data['kategori']!="teks_berjalan")
				echo $data['kategori'];
			else
				echo "Teks Berjalan";
			?>
                                </a>
                            </li>
                            <?php }?>
                            <?php
?>
                        </ul>
                </fieldset>

</div>
<legend>Artikel Statis</legend>
<div class="lmenu">
    <ul>
        <li <?php if($cat == 1003)echo "class='selected'";?>>
            <a href="<?php echo site_url("web/index/1003")?>">
                Customizable Widget
            </a>
        </li>
        <li <?php if($cat == 999)echo "class='selected'";?>>
            <a href="<?php echo site_url("web/index/999")?>">
                Halaman Statis
            </a>
        </li>
        <li <?php if($cat == 1000)echo "class='selected'";?>>
            <a href="<?php echo site_url("web/index/1000")?>">
                Agenda
            </a>
        </li>
    </ul>
</div>
</td>
<td style="background:#fff;padding:0px;">
    <div class="content-header">
        <?php
	?>
    </div>
    <div id="contentpane">
        <form id="mainform" name="mainform" action="" method="post">
            <div class="ui-layout-north panel">
                <div class="left">
                    <div class="uibutton-group">
                        <a href="<?php echo site_url("web/form/$cat")?>" class="uibutton tipsy south" title="Tambah Data"><span class="fa fa-plus">&nbsp;</span>Tambah <?php if($kategori){echo $kategori['kategori'];}else{echo "Artikel Statis";}?> Baru</a>
                        <?php if($_SESSION['grup']<4){?>
                        <button type="button" title="Hapus Artikel" onclick="deleteAllBox('mainform','<?php echo site_url("web/delete_all/$p/$o")?>')" class="uibutton tipsy south"><span class="fa fa-trash-o">&nbsp;</span>Hapus
                            <?php }?>
                    </div>
                </div>
                <?php if($cat < 999){?>
                <div class="right">
                    <?php if($_SESSION['grup']<4){?>
                    <button type="button" title="Hapus Kategori <?php echo $kategori['kategori']?>" onclick="deleteAllBox('mainform','<?php echo site_url("web/hapus/$cat/$p/$o")?>')" class="uibutton tipsy south"><span class="fa fa-trash-o">&nbsp;</span>Hapus Kategori <?php echo $kategori['kategori']?>
                        <?php }?>
                </div>
                <?php }?>
            </div>
            <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                <div class="table-panel top">
                    <div class="left">
                        <select name="filter" onchange="formAction('mainform','<?php echo site_url('web/filter')?>')">
                            <option value="">Semua</option>
                            <option value="1" <?php if($filter==1) :?>selected<?php endif?>>Enabled</option>
                            <option value="2" <?php if($filter==2) :?>selected<?php endif?>>Disabled</option>
                        </select>
                    </div>
                    <div class="right">
                        <input name="cari" id="cari" type="text" class="inputbox help tipped" size="20" value="<?php echo $cari?>" title="Cari.." onkeypress="if (event.keyCode == 13) {$('#'+'mainform').attr('action','<?php echo site_url("web/search/$cat")?>');$('#'+'mainform').submit();}">
                        <button type="button" onclick="$('#'+'mainform').attr('action','<?php echo site_url("web/search/$cat")?>');$('#'+'mainform').submit();" class="uibutton tipsy south" title="Cari Data"><span class="fa fa-search">&nbsp;</span>Cari</button>
                    </div>
                </div>
                <table class="list">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th><input type="checkbox" class="checkall"></th>
                            <th width="160">Aksi</th>
                            <?php if($o==2): ?>
                            <th align="left"><a href="<?php echo site_url("web/index/$p/1")?>">Judul<span class="ui-icon ui-icon-triangle-1-n">
                                        <?php elseif($o==1): ?>
                            <th align="left"><a href="<?php echo site_url("web/index/$p/2")?>">Judul<span class="ui-icon ui-icon-triangle-1-s">
                                        <?php else: ?>
                            <th align="left"><a href="<?php echo site_url("web/index/$p/1")?>">Judul<span class="ui-icon ui-icon-triangle-2-n-s">
                                        <?php endif; ?>&nbsp;</span></a></th>
                            <?php if($o==4): ?>
                            <th align="left"><a href="<?php echo site_url("web/index/$p/3")?>">Enabled / Disabled<span class="ui-icon ui-icon-triangle-1-n">
                                        <?php elseif($o==3): ?>
                            <th align="left"><a href="<?php echo site_url("web/index/$p/4")?>">Enabled / Disabled<span class="ui-icon ui-icon-triangle-1-s">
                                        <?php else: ?>
                            <th align="left"><a href="<?php echo site_url("web/index/$p/3")?>">Enabled / Disabled<span class="ui-icon ui-icon-triangle-2-n-s">
                                        <?php endif; ?>&nbsp;</span></a></th>
                            <?php if($o==6): ?>
                            <th align="left" width='250'><a href="<?php echo site_url("web/index/$p/5")?>">Dimuat pada<span class="ui-icon ui-icon-triangle-1-n">
                                        <?php elseif($o==5): ?>
                            <th align="left" width='250'><a href="<?php echo site_url("web/index/$p/6")?>">Dimuat pada<span class="ui-icon ui-icon-triangle-1-s">
                                        <?php else: ?>
                            <th align="left" width='250'><a href="<?php echo site_url("web/index/$p/5")?>">Dimuat pada<span class="ui-icon ui-icon-triangle-2-n-s">
                                        <?php endif; ?>&nbsp;</span></a></th>
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
                                    <a href="<?php echo site_url("web/form/$cat/$p/$o/$data[id]")?>" class="uibutton tipsy south" title="Ubah Data"><span class="fa fa-pencil"> Ubah </span></a>
                                    <?php if($_SESSION['grup']<4){?>
                                    <a href="<?php echo site_url("web/delete/$cat/$p/$o/$data[id]")?>" class="uibutton tipsy south" title="Hapus Data" target="confirm" message="Apakah Anda Yakin?" header="Hapus Data"><span class="fa fa-trash-o"></span></a>
                                    <?php if($data['enabled'] == '2'):?>
                                    <a href="<?php echo site_url("web/artikel_lock/$cat/$data[id]")?>" class="uibutton tipsy south" title="Aktivasi artikel"><span class="fa fa-lock"></span></a>
                                    <?php elseif($data['enabled'] == '1'): ?>
                                    <a href="<?php echo site_url("web/artikel_unlock/$cat/$data[id]")?>" class="uibutton tipsy south" title="Non-aktifkan artikel"><span class="fa fa-unlock"></span></a>
                                    <a href="<?php echo site_url("web/headline/$cat/$p/$o/$data[id]")?>" class="uibutton tipsy south" title="Klik untuk Jadikan Headline"><span class="<?php if($data['headline']==1){?>fa fa-star-o" title="Headline Saat Ini" <?php }else{?>fa fa-star" <?php }?>target="confirm" message="Jadikan Artikel ini sebagai Headline News?" header="Headline"></span></a>
                                    <a href="<?php echo site_url("web/slide/$cat/$p/$o/$data[id]")?>" class="uibutton tipsy south" title="Klik untuk Jadikan Slide" message="Masukkan ke dalam slide?"><span class="<?php if($data['headline']==3){?>icon-pause icon-large" title="Keluarkan dari slide" message="Keluarkan dari slide?" <?php }else{?>fa fa-play" <?php }?>target="confirm" header="Slide"></span></a>
                                    <?php endif?>
                                    <?php } ?>
                                </div>
                            </td>
                            <td><?php echo $data['judul']?></td>
                            <td><?php echo $data['aktif']?></td>
                            <td><?php echo tgl_indo2($data['tgl_upload'])?></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </form>
        <div class="ui-layout-south panel bottom">
            <div class="left">
                <div class="table-info">
                    <form id="paging" action="<?php echo site_url("web/pager/$cat")?>" method="post">
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
                    <a href="<?php echo site_url("web/index/$cat/$paging->start_link/$o")?>" class="uibutton">Awal</a>
                    <?php endif; ?>
                    <?php if($paging->prev): ?>
                    <a href="<?php echo site_url("web/index/$cat/$paging->prev/$o")?>" class="uibutton">Prev</a>
                    <?php endif; ?>
                </div>
                <div class="uibutton-group">
                    <?php for($i=$paging->start_link;$i<=$paging->end_link;$i++): ?>
                    <a href="<?php echo site_url("web/index/$cat/$i/$o")?>" <?php jecho($p,$i,"class='uibutton special'")?> class="uibutton"><?php echo $i?></a>
                    <?php endfor; ?>
                </div>
                <div class="uibutton-group">
                    <?php if($paging->next): ?>
                    <a href="<?php echo site_url("web/index/$cat/$paging->next/$o")?>" class="uibutton">Next</a>
                    <?php endif; ?>
                    <?php if($paging->end_link): ?>
                    <a href="<?php echo site_url("web/index/$cat/$paging->end_link/$o")?>" class="uibutton">Akhir</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</td>
</tr>
</table>
</div>
