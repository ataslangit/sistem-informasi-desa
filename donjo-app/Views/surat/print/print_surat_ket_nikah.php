<?php view('print/headjs.php');?>

<body>
    <div id="content" class="container_12 clearfix">
        <div id="content-main" class="grid_7">
            <link href="<?php echo base_url()?>assets/css/surat.css" rel="stylesheet">
            <div>
                <table width="100%">
                    <tr> <img src="<?php echo base_url()?>assets/files/logo/<?php echo $desa['logo']?>" alt="" class="logo"></tr>
                    <div class="header">
                        <h4 class="kop">PEMERINTAH KABUPATEN <?php echo strtoupper(unpenetration($desa['nama_kabupaten']))?> </h4>
                        <h4 class="kop">KECAMATAN <?php echo strtoupper(unpenetration($desa['nama_kecamatan']))?> </h4>
                        <h4 class="kop">DESA <?php echo strtoupper(unpenetration($desa['nama_desa']))?></h4>
                        <h5 class="kop2"><?php echo (unpenetration($desa['alamat_kantor']))?> </h5>
                        <div style="text-align: center;">
                            <hr>
                        </div>
                    </div>
                    <div align="center"><u>
                            <h4 class="kop">SURAT KETERANGAN UNTUK NIKAH</h4>
                        </u></div>
                    <div align="center">
                        <h4 class="kop-nomor">No: <?php echo $input['nomor']?></h4>
                    </div>
                </table>
                <div class="clear"></div>
                <table width="100%">
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <td class="indentasi">Yang bertanda tangan dibawah ini menerangkan dengan sesungguhnya bahwa: </td>
                    </tr>
                </table>
                <div id="isi3">
                    <table width="100%">
                        <tr>
                            <td width="30%">Nama Lengkap</td>
                            <td width="3%">:</td>
                            <td width="64%"><?php echo unpenetration($data['nama'])?></td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td><?php echo $data['sex']?></td>
                        </tr>
                        <tr>
                            <td>Tempat dan Tgl. Lahir </td>
                            <td>:</td>
                            <td><?php echo $data['tempatlahir'] ?>, <?php echo tgl_indo($data['tanggallahir'])?> </td>
                        </tr>
                        <tr>
                            <td>Warga negara</td>
                            <td>:</td>
                            <td><?php echo $data['warganegara']?></td>
                        </tr>
                        <tr>
                            <td>Agama</td>
                            <td>:</td>
                            <td><?php echo $data['agama']; ?></td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td>:</td>
                            <td><?php echo $data['pekerjaan']?></td>
                        </tr>
                        <tr>
                            <td>Tempat Tinggal</td>
                            <td>:</td>
                            <td>RT. <?php echo $data['rt']?>, RW. <?php echo $data['rw']?>, Dusun <?php echo unpenetration(ununderscore($data['dusun']))?>, Kel. <?php echo unpenetration($desa['nama_desa'])?>, Kec. <?php echo unpenetration($desa['nama_kecamatan'])?>, Kab. <?php echo unpenetration($desa['nama_kabupaten'])?></td>
                        </tr>
                        <tr>
                            <td>Bin/Binti</td>
                            <td>:</td>
                            <td><?php echo $input['bin'] ?></td>
                        </tr>
                        <tr>
                            <td>Status Perkawinan</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>a. Jika pria, terangkan jejaka, duda atau beristri dan berapa istrinya</td>
                            <td>:</td>
                            <td><?php echo ($input['jaka']) ;
 ?></td>
                        </tr>
                        <tr>
                            <td>b. Jika wanita, terangkan gadis atau janda</td>
                            <td>:</td>
                            <td><?php echo ($input['perawan']) ;?></td>
                        </tr>
                        <tr>
                            <td>Nama Istri/Suami terdahulu</td>
                            <td>:</td>
                            <td><?php echo $input['pasangan_dulu'];?></td>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr></tr>
                        <tr></tr>
                        <tr>
                            <td class="indentasi">Demikianlah, surat keterangan ini dibuat dengan mengingat sumpah jabatan dan untuk dipergunakan seperlunya.</td>
                        </tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                    </table>
                </div>
                <table width="100%">
                    <tr></tr>
                    <tr>
                        <td width="10%"></td>
                        <td width="30%"></td>
                        <td align="center"><?php echo unpenetration($desa['nama_desa'])?>, <?php echo $tanggal_sekarang?></td>
                    </tr>
                    <tr>
                        <td width="10%"></td>
                        <td width="30%"></td>
                        <td align="center"><?php echo unpenetration($input['jabatan'])?> <?php echo unpenetration($desa['nama_desa'])?></td>
                    </tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr>
                        <td>
                        <td></td>
                        <td td align="center">( <?php echo unpenetration($input['pamong'])?> )</td>
                    </tr>
                    <tr>
                        <td colspan="3">*)nama lengkap
                        <td>
                </table>
            </div>
        </div>
        <div id="aside">
        </div>
    </div>
</body>

</html>
