<script>
    $(function() {
        var keyword = <?php echo $keyword?>;
        $("#cari").autocomplete({
            source: keyword
        });
    });

</script>
<div id="pageC">
    <!-- Start of Space Admin -->
    <table class="inner">
        <tr style="vertical-align:top">
            <td style="background:#fff;padding:0px;">
                <div id="contentpane">
                    <form id="mainform" name="mainform" action="" method="post">
                        <div class="ui-layout-north panel">
                            <h3>Pengaturan / Pengelompokan Rumah Tangga</h3>
                            <div class="left">
                                <div class="uibutton-group">
                                    <a href="<?php echo site_url('rtm/form_old')?>" target="ajax-modalx" rel="window" header="Tambah Data Rumah Tangga Per Penduduk" class="uibutton tipsy south" title="Tambah data dari penduduk"><span class="fa fa-plus">&nbsp;</span>Tambah Rumah Tangga</a>

                                    <?php
?>

                                    <?php if($grup==1){?><button type="button" title="Hapus Data" onclick="deleteAllBox('mainform','<?php echo site_url("rtm/delete_all/$p/$o")?>')" class="uibutton tipsy south"><span class="fa fa-trash-o">&nbsp;</span>Hapus Data</button><?php }?>

                                    <a href="<?php echo site_url("rtm/cetak/$o")?>" target="_blank" class="uibutton tipsy south" title="Cetak"><span class="fa fa-print">&nbsp;</span>Cetak</a>

                                    <a href="<?php echo site_url("rtm/excel/$o")?>" target="_blank" class="uibutton tipsy south" title="Unduh"><span class="fa fa-download">&nbsp;</span>Unduh</a>
                                    <?php /*
			<a href="<?php echo site_url("rtm/excel_pbdt/$o")?>" target="_blank" class="uibutton special tipsy south" title="Unduh" ><span class="fa fa-download">&nbsp;</span>Excel PBDT</a>
                                    */ ?>
                                    &nbsp;
                                    <select name="dusun" onchange="formAction('mainform','<?php echo site_url('rtm/dusun')?>')">
                                        <option value="">Dusun</option>
                                        <?php foreach($list_dusun AS $data){?>
                                        <option value="<?php echo $data['dusun']?>" <?php if($dusun == $data['dusun']) :?>selected<?php endif?>><?php echo strtoupper(unpenetration(ununderscore($data['dusun'])))?></option>
                                        <?php }?>
                                    </select>

                                    <?php if($dusun){?>
                                    <select name="rw" onchange="formAction('mainform','<?php echo site_url('rtm/rw')?>')">
                                        <option value="">RW</option>
                                        <?php foreach($list_rw AS $data){?>
                                        <option value="<?php echo $data['rw']?>" <?php if($rw == $data['rw']) :?>selected<?php endif?>><?php echo $data['rw']?></option>
                                        <?php }?>
                                    </select>
                                    <?php }?>

                                    <?php if($rw){?>
                                    <select name="rt" onchange="formAction('mainform','<?php echo site_url('rtm/rt')?>')">
                                        <option value="">RT</option>
                                        <?php foreach($list_rt AS $data){?>
                                        <option value="<?php echo $data['rt']?>" <?php if($rt == $data['rt']) :?>selected<?php endif?>><?php echo $data['rt']?></option>
                                        <?php }?>
                                    </select>
                                    <?php }?>

                                </div>
                            </div>
                            <div class="right">
                                <div class="uibutton-group">

                                    <input name="cari" id="cari" type="text" class="inputbox help tipped" size="20" value="<?php echo $cari?>" title="Cari.." onkeypress="if (event.keyCode == 13) {$('#'+'mainform').attr('action','<?php echo site_url('rtm/search')?>');$('#'+'mainform').submit();}">
                                    <button type="button" onclick="$('#'+'mainform').attr('action','<?php echo site_url('rtm/search')?>');$('#'+'mainform').submit();" class="uibutton tipsy south" title="Cari Data"><span class="fa fa-search">&nbsp;</span>Cari</button>
                                </div>
                            </div>
                        </div>
                        <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                            <table class="list">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th><input type="checkbox" class="checkall"></th>
                                        <th width="160">Aksi</th>

                                        <th width="150" align="left">
                                            <?php if($o==2): ?>
                                            <a href="<?php echo site_url("rtm/index/$p/1")?>">Nomor Rumah Tangga<span class="ui-icon ui-icon-triangle-1-n">
                                                    <?php elseif($o==1): ?>
                                                    <a href="<?php echo site_url("rtm/index/$p/2")?>">Nomor Rumah Tangga<span class="ui-icon ui-icon-triangle-1-s">
                                                            <?php else: ?>
                                                            <a href="<?php echo site_url("rtm/index/$p/1")?>">Nomor Rumah Tangga<span class="ui-icon ui-icon-triangle-2-n-s">
                                                                    <?php endif; ?>
                                                                    &nbsp;</span></a>
                                        </th>
                                        <th align="left">
                                            <?php if($o==4): ?>
                                            <a href="<?php echo site_url("rtm/index/$p/3")?>">Kepala Rumah Tangga<span class="ui-icon ui-icon-triangle-1-n">
                                                    <?php elseif($o==3): ?>
                                                    <a href="<?php echo site_url("rtm/index/$p/4")?>">Kepala Rumah Tangga<span class="ui-icon ui-icon-triangle-1-s">
                                                            <?php else: ?>
                                                            <a href="<?php echo site_url("rtm/index/$p/3")?>">Kepala Rumah Tangga<span class="ui-icon ui-icon-triangle-2-n-s">
                                                                    <?php endif; ?>
                                                                    &nbsp;</span></a>
                                        </th>

                                        <th width="100">Jumlah Anggota</th>
                                        <th width="120">Dusun</th>
                                        <th width="30">RW</th>
                                        <th width="30">RT</th>
                                        <th width="100">Tanggal Terdaftar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($main as $data): ?>
                                    <tr>
                                        <td align="center" width="2"><?php echo $data['no']?></td>
                                        <td align="center" width="5">
                                            <input type="checkbox" name="id_cb[]" value="<?php echo $data['id']?>">
                                        </td>
                                        <td width="5">
                                            <div class="uibutton-group">
                                                <a href="<?php echo site_url("rtm/anggota/$p/$o/$data[id]")?>" class="uibutton tipsy south" title="Rincian Anggota Rumah Tangga"><span class="fa fa-list"> Rincian </span></a>
                                                <?php if($grup==1){?><a href="<?php echo site_url("rtm/edit_nokk/$p/$o/$data[id]")?>" target="ajax-modal" rel="window" header="Edit Rumah Tangga" class="uibutton tipsy south" title="Edit Data"><span class="fa fa-pencil"></span></a><a href="<?php echo site_url("rtm/delete/$p/$o/$data[id]")?>" class="uibutton tipsy south" title="Hapus Data" target="confirm" message="Apakah Anda yakin?" header="Hapus Data"><span class="fa fa-trash-o"></span> </a><?php } ?>
                                            </div>
                                        </td>
                                        <td><label> <?php echo $data['no_kk']?> </label></td>
                                        <td><?php echo strtoupper(unpenetration($data['kepala_kk']))?></td>
                                        <td><a href="<?php echo site_url("rtm/anggota/$p/$o/$data[id]")?>"><?php echo $data['jumlah_anggota']?></a></td>
                                        <td><?php echo strtoupper(unpenetration(ununderscore($data['dusun'])))?></td>
                                        <td><?php echo strtoupper($data['rw'])?></td>
                                        <td><?php echo strtoupper($data['rt'])?></td>
                                        <td><?php echo tgl_indo($data['tgl_daftar'])?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    </form>
                    <div class="ui-layout-south panel bottom">
                        <div class="left">
                            <div class="table-info">
                                <form id="paging" action="<?php echo site_url('rtm')?>" method="post">
                                    <label>Tampilkan</label>
                                    <select name="per_page" onchange="$('#paging').submit()">
                                        <option value="50" <?php selected($per_page,50); ?>>50</option>
                                        <option value="100" <?php selected($per_page,100); ?>>100</option>
                                        <option value="200" <?php selected($per_page,200); ?>>200</option>
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
                                <a href="<?php echo site_url("rtm/index/$paging->start_link/$o")?>" class="uibutton">Awal</a>
                                <?php endif; ?>
                                <?php if($paging->prev): ?>
                                <a href="<?php echo site_url("rtm/index/$paging->prev/$o")?>" class="uibutton">Prev</a>
                                <?php endif; ?>
                            </div>
                            <div class="uibutton-group">

                                <?php for($i=$paging->start_link;$i<=$paging->end_link;$i++): ?>
                                <a href="<?php echo site_url("rtm/index/$i/$o")?>" <?php jecho($p,$i,"class='uibutton special'")?> class="uibutton"><?php echo $i?></a>
                                <?php endfor; ?>
                            </div>
                            <div class="uibutton-group">
                                <?php if($paging->next): ?>
                                <a href="<?php echo site_url("rtm/index/$paging->next/$o")?>" class="uibutton">Next</a>
                                <?php endif; ?>
                                <?php if($paging->end_link): ?>
                                <a href="<?php echo site_url("rtm/index/$paging->end_link/$o")?>" class="uibutton">Akhir</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
