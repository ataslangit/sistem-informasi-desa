<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <td style="background:#fff;padding:0px;">
                <div id="contentpane">
                    <form id="mainform" name="mainform" action="" method="post">
                        <div class="ui-layout-north panel top">
                            <div class="left">
                                <div class="uibutton-group">
                                    <a href="<?php echo site_url("laporan_rentan/cetak")?>" class="uibutton tipsy south" title="Cetak" target="_blank"><span class="fa fa-print">&nbsp;</span>Cetak</a>
                                    <a href="<?php echo site_url("laporan_rentan/excel")?>" class="uibutton tipsy south" title="Excel" target="_blank"><span class="fa fa-download">&nbsp;</span>Unduh</a>
                                </div>
                            </div>
                        </div>
                        <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                            <style>
                                table.tftable {
                                    font-size: 12px;
                                    color: #333333;
                                    width: 100%;
                                    border-width: 1px;
                                    border-color: #729ea5;
                                    border-collapse: collapse;
                                }

                                table.tftable th {
                                    font-size: 12px;
                                    background-color: #8DABD4;
                                    border-width: 1px;
                                    padding: 3px;
                                    border-style: solid;
                                    border-color: #7195BA;
                                    text-align: left;
                                }

                                table.tftable tr {
                                    background-color: #ffffff;
                                }

                                table.tftable td {
                                    font-size: 12px;
                                    border-width: 1px;
                                    padding: 8px;
                                    border-style: solid;
                                    border-color: #729ea5;
                                }

                            </style>

                            <table width="100%"><?php foreach($config as $data){?>
                                <tbody>
                                    <tr>
                                        <td width="37%">
                                            <h4>PEMERINTAH KABUPATEN/KOTA <?php echo unpenetration($data['nama_kabupaten'])?></h4>
                                        </td>

                                        <td align="right" width="17%">
                                            <h4>LAMPIRAN A - 9</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td width="100%">
                                            <h3>DATA PILAH KEPENDUDUKAN MENURUT UMUR DAN FAKTOR KERENTANAN</h3>
                                        </td>


                                    </tr>
                                </tbody>
                            </table>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>Desa/Kelurahan</td>
                                        <td width="3%">:</td>
                                        <td width="38.5%"><?php echo unpenetration($data['nama_desa'])?></h4>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Kecamatan</td>
                                        <td width="3%">:</td>
                                        <td width="38.5%"><?php echo unpenetration($data['nama_kecamatan'])?></td>
                                        <td></td>
                                        <?php }?>
                                    </tr>
                                    <tr>
                                        <td>Periode</td>
                                        <td width="3%">:</td>
                                        <?php $bln = date("m");$thn=date("Y");?>
                                        <td><?php echo $bln."/".$thn?> </td>
                                        <td width="40%"></td>
                                    </tr>
                                    <tr>
                                        <td>Dusun</td>
                                        <td width="3%">:</td>
                                        <td>
                                            <select name="dusun" onchange="formAction('mainform','<?php echo site_url('laporan_rentan/dusun')?>')">
                                                <option value="">--- Pilih Dusun ---</option>
                                                <?php foreach($list_dusun as $data){?>
                                                <option value="<?php echo $data['dusun']?>" <?php if($dusun==$data['dusun']){?>selected<?php }?>><?php echo ununderscore(unpenetration($data['dusun']))?></option>
                                                <?php }?>
                                            </select>
                                        </td>
                                        <td width="40%"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table width="100%" id="tfhover" class="tftable" border="1">
                                <thead>
                                    <?php if($dusun!=''){?>
                                    <tr>
                                        <h3>DATA PILAH DUSUN <?php echo $dusun ?></h3>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <th rowspan="2">
                                            <div align="center">DUSUN</div>
                                        </th>
                                        <th rowspan="2">
                                            <div align="center">RW</div>
                                        </th>
                                        <th rowspan="2">
                                            <div align="center">RT</div>
                                        </th>
                                        <th colspan="2">
                                            <div align="center">KK</div>
                                        </th>
                                        <th colspan="7">
                                            <div align="center">Kondisi dan Kelompok Umur</div>
                                        </th>
                                        <th colspan="2">
                                            <div align="center">Hamil</div>
                                        </th>
                                        <th rowspan="2">
                                            <div align="center">Menyusui</div>
                                        </th>
                                        <th colspan="2">
                                            <div align="center">Cacat</div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            <div align="center">L</div>
                                        </th>
                                        <th>
                                            <div align="center">P</div>
                                        </th>
                                        <th>
                                            <div align="center">Dibawah 1 Tahun</div>
                                        </th>
                                        <th>
                                            <div align="center">1-5 Tahun</div>
                                        </th>
                                        <th>
                                            <div align="center">6-12 Tahun</div>
                                        </th>
                                        <th>
                                            <div align="center">13-15 Tahun</div>
                                        </th>
                                        <th>
                                            <div align="center">16-18 Tahun</div>
                                        </th>
                                        <th>
                                            <div align="center">19-59 Tahun</div>
                                        </th>
                                        <th>
                                            <div align="center">Diatas 60 Tahun</div>
                                        </th>
                                        <th>
                                            <div align="center">Tua</div>
                                        </th>
                                        <th>
                                            <div align="center">Muda</div>
                                        </th>
                                        <th>
                                            <div align="center">L</div>
                                        </th>
                                        <th>
                                            <div align="center">P</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
	$bayi=0;
	$balita=0;
	$sd=0;
	$smp=0;
	$sma=0;
	$dewasa=0;
	$lansia=0;
	$cacat=0;
	$cacat2=0;
	$sakit_L=0;
	$sakit_P=0;
	$hamil1=0;
	$hamil2=0;
	$susu=0;
?>
                                    <?php foreach($main as $data){ $id_cluster=$data['id_cluster'];?>
                                    <td align="right"><?php echo $data['dusunnya']?></td>
                                    <td align="right"><?php echo $data['rw']?></td>
                                    <td align="right"><?php echo $data['rt']?></td>
                                    <td align="right"><a href="<?php echo site_url("penduduk/lap_statistik/$id_cluster/1")?>"><?php echo $data['L']?></a></td>
                                    <td align="right"><a href="<?php echo site_url("penduduk/lap_statistik/$id_cluster/2")?>"><?php echo $data['P']?></a></td>
                                    <td width="13%" align="right"><a href="<?php echo site_url("penduduk/lap_statistik/$id_cluster/3")?>"><?php echo $data['bayi']?></a></td>
                                    <td width="14%" align="right"><a href="<?php echo site_url("penduduk/lap_statistik/$id_cluster/4")?>"><?php echo $data['balita']?></a></td>
                                    <td width="13%" align="right"><a href="<?php echo site_url("penduduk/lap_statistik/$id_cluster/5")?>"><?php echo $data['sd']?></a></td>
                                    <td width="15%" align="right"><a href="<?php echo site_url("penduduk/lap_statistik/$id_cluster/6")?>"><?php echo $data['smp']?></a></td>
                                    <td width="15%" align="right"><a href="<?php echo site_url("penduduk/lap_statistik/$id_cluster/7")?>"><?php echo $data['sma']?></a></td>
                                    <td width="15%" align="right"><a href="<?php echo site_url("penduduk/lap_statistik/$id_cluster/7")?>"><?php echo $data['dewasa']?></a></td>
                                    <td width="13%" align="right"><a href="<?php echo site_url("penduduk/lap_statistik/$id_cluster/8")?>"><?php echo $data['lansia']?></a></td>
                                    <td align="right"><a href="<?php echo site_url("penduduk/lap_statistik/$id_cluster/12")?>"><?php echo $data['hamil1']?></a></td>
                                    <td align="right"><a href="<?php echo site_url("penduduk/lap_statistik/$id_cluster/12")?>"><?php echo $data['hamil2']?></a></td>
                                    <td align="right"><a href="<?php echo site_url("penduduk/lap_statistik/$id_cluster/12")?>"><?php echo $data['susu']?></a></td>
                                    <td align="right"><a href="<?php echo site_url("penduduk/lap_statistik/$id_cluster/9")?>"><?php echo $data['cacat']?></a></td>
                                    <td align="right"><a href="<?php echo site_url("penduduk/lap_statistik/$id_cluster/9")?>"><?php echo $data['cacat2']?></a></td>
                                    <?php
	$bayi=$bayi+$data['bayi'];
	$balita=$balita+$data['balita'];
	$sd=$sd+$data['sd'];
	$smp=$smp+$data['smp'];
	$sma=$sma+$data['sma'];
	$dewasa=$dewasa+$data['dewasa'];
	$lansia=$lansia+$data['lansia'];
	$cacat=$cacat+$data['cacat'];
	$cacat2=$cacat2+$data['cacat2'];
	$sakit_L=$sakit_L+$data['sakit_L'];
	$sakit_P=$sakit_P+$data['sakit_P'];
	$hamil1=$hamil1+$data['hamil1'];
	$hamil2=$hamil2+$data['hamil2'];
	$susu=$susu+$data['susu'];
?>
        </tr>
        <?php }?>
        </tbody>

        <thead>
            <tr>
                <th colspan="5" align="center">
                    <div align="center">Total</div>
                </th>
                <th>
                    <div align="right"><?php echo $bayi;?></div>
                </th>
                <th>
                    <div align="right"><?php echo $balita;?></div>
                </th>
                <th>
                    <div align="right"><?php echo $sd;?></div>
                </th>
                <th>
                    <div align="right"><?php echo $smp;?></div>
                </th>
                <th>
                    <div align="right"><?php echo $sma;?></div>
                </th>
                <th>
                    <div align="right"><?php echo $dewasa;?></div>
                </th>
                <th>
                    <div align="right"><?php echo $lansia;?></div>
                </th>
                <th>
                    <div align="right"><?php echo $hamil1;?></div>
                </th>
                <th>
                    <div align="right"><?php echo $hamil2;?></div>
                </th>
                <th>
                    <div align="right"><?php echo $susu;?></div>
                </th>
                <th>
                    <div align="right"><?php echo $cacat;?></div>
                </th>
                <th>
                    <div align="right"><?php echo $cacat2;?></div>
                </th>
            </tr>
        </thead>
    </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
</div>
</div>
<div class="ui-layout-south panel bottom">
    <div class="left">
        <a href="<?php echo site_url()?>sid_wilayah" class="uibutton icon prev">Kembali</a>
    </div>
    <div class="right">
        <div class="uibutton-group">

            <button class="uibutton confirm" type="submit">Cetak</button>
        </div>
    </div>
    </form>
</div>
</td>
</tr>
</table>
</div>
