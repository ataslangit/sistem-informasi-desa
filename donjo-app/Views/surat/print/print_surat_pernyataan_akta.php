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
                            <h4 class="kop">SURAT PERNYATAAN BELUM MEMILIKI AKTA KELAHIRAN</h4>
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
                    <td class="indentasi">Yang bertanda tangan dibawah ini <?php echo unpenetration($input['jabatan'])?> <?php echo unpenetration($desa['nama_desa'])?>, Kecamatan <?php echo unpenetration($desa['nama_kecamatan'])?>,
                        Kabupaten <?php echo unpenetration($desa['nama_kabupaten'])?>, Provinsi <?php echo unpenetration($desa['nama_propinsi'])?> menerangkan dengan sebenarnya bahwa: </td>
                    </tr>
                </table>
                <div id="isi3">
                    <table width="100%">
                        <tr>
                            <td width="23%">Nama Lengkap</td>
                            <td width="3%">:</td>
                            <td width="64%"><?php echo unpenetration($data['nama'])?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td>RT. <?php echo $data['rt']?>, RW. <?php echo $data['rw']?>, Dusun <?php echo unpenetration(ununderscore($data['dusun']))?>, Desa <?php echo unpenetration($desa['nama_desa'])?>, Kec. <?php echo unpenetration($desa['nama_kecamatan'])?>, Kab. <?php echo unpenetration($desa['nama_kabupaten'])?></td>
                        </tr>
                        <tr>
                            <td>Tempat dan Tgl. Lahir </td>
                            <td>:</td>
                            <td><?php echo $data['tempatlahir']?>, <?php echo tgl_indo($data['tanggallahir'])?> </td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td><?php echo $data['sex']?></td>
                        </tr>
                        <tr>
                            <td>Nama Ayah</td>
                            <td>:</td>
                            <td><?php echo unpenetration($data['nama_ayah'])?></td>
                        </tr>
                        <tr>
                            <td>Nama Ibu</td>
                            <td>:</td>
                            <td><?php echo unpenetration($data['nama_ibu'])?></td>
                        </tr>
                        <tr></tr>
                        <tr>
                            <td colspan="3">Betul-betul belum pernah memiliki AKTA KELAHIRAN.</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="indentasi">Demikian Surat Keterangan ini kami buat dengan sesungguhnya agar dapat dipergunakan sebagaimanan mestinya.</td>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
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
                            <td align="center">( <?php echo unpenetration($input['pamong'])?> )</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div id="aside">
            </div>
        </div>
</body>

</html>
