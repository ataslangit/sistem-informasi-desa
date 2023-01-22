<?= view('print/headjs.php'); ?>

<body>
    <div id="content" class="container_12 clearfix">
        <div id="content-main" class="grid_7">
            <link href="<?= base_url('assets/css/surat.css') ?>" rel="stylesheet">
            <div>
                <table width="100%">
                    <tr> <img src="<?= base_url('assets/files/logo/' . $desa['logo']) ?>" alt="" class="logo"></tr>
                    <div class="header">
                        <h4 class="kop">PEMERINTAH KABUPATEN <?= strtoupper(unpenetration($desa['nama_kabupaten']))?> </h4>
                        <h4 class="kop">KECAMATAN <?= strtoupper(unpenetration($desa['nama_kecamatan']))?> </h4>
                        <h4 class="kop">DESA <?= strtoupper(unpenetration($desa['nama_desa']))?></h4>
                        <h5 class="kop2"><?= unpenetration($desa['alamat_kantor'])?> </h5>
                        <div style="text-align: center;">
                            <hr>
                        </div>
                    </div>
                    <div align="center"><u>
                            <h4 class="kop">SURAT KETERANGAN ASAL - USUL</h4>
                        </u></div>
                    <div align="center">
                        <h4 class="kop-nomor">No: <?= $input['nomor']?></h4>
                    </div>
                </table>
                <div class="clear"></div>
                <table width="100%">
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <td class="indentasi">Yang bertanda tangan dibawah ini menerangkan dengan sesungguhnya bahwa:</td>
                    </tr>
                </table>
                <div id="isi1">
                    <table width="100%">
                        <tr>
                            <td width="23%">Nama Lengkap</td>
                            <td width="3%">:</td>
                            <td width="64%"><?= unpenetration($data['nama'])?></td>
                        </tr>
                        <tr>
                            <td>Tempat dan Tgl. Lahir</td>
                            <td>:</td>
                            <td><?= $data['tempatlahir']?>, <?= tgl_indo($data['tanggallahir'])?></td>
                        </tr>
                        <tr>
                            <td>Warganegara</td>
                            <td>:</td>
                            <td><?= $data['warganegara']?></td>
                        </tr>
                        <tr>
                            <td>Agama</td>
                            <td>:</td>
                            <td><?= $data['agama']?></td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td>:</td>
                            <td><?= $data['pekerjaan']?></td>
                        </tr>
                        <tr>
                            <td>Tempat Tinggal</td>
                            <td>:</td>
                            <td>RT. <?= $data['rt']?>, RW. <?= $data['rw']?>, Dusun <?= unpenetration(ununderscore($data['dusun']))?>, Kel. <?= unpenetration($desa['nama_desa'])?>, Kec. <?= unpenetration($desa['nama_kecamatan'])?>, Kab. <?= unpenetration($desa['nama_kabupaten'])?></td>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr></tr>
                        <tr>
                            <td>adalah benar anak kandung dari pernikahan seorang pria:</td>
                        </tr>
                        <tr></tr>
                    </table>
                    <?php if ($ayah) {?>
                    <table width="100%">
                        <tr>
                            <td width="23%">Nama Lengkap</td>
                            <td width="3%">:</td>
                            <td width="64%"><?= unpenetration($ayah['nama'])?></td>
                        </tr>
                        <tr>
                            <td>Tempat/Tgl. Lahir</td>
                            <td>:</td>
                            <td><?= $ayah['tempatlahir']; ?> , <?= tgl_indo($ayah['tanggallahir']); ?></td>
                        </tr>
                        <tr>
                            <td>Warganegara</td>
                            <td>:</td>
                            <td><?= $ayah['wn']; ?></td>
                        </tr>
                        <tr>
                            <td>Agama</td>
                            <td>:</td>
                            <td><?= $ayah['agama']; ?></td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td>:</td>
                            <td><?= $ayah['pek']; ?></td>
                        </tr>
                        <tr>
                            <td>Tempat Tinggal</td>
                            <td>:</td>
                            <td>RT. <?= $ayah['rt']; ?>, RW. <?= $ayah['rw']; ?>, Dusun <?= unpenetration(ununderscore($ayah['dusun'])); ?>, Kel. <?= unpenetration($desa['nama_desa']); ?>, Kec. <?= unpenetration($desa['nama_kecamatan']); ?>, Kab. <?= unpenetration($desa['nama_kabupaten']); ?></td>
                        </tr>
                    </table>
                    <?php } else {?>
                    <table width="100%">
                        <tr>
                            <td width="23%">Nama Lengkap</td>
                            <td width="3%">:</td>
                            <td width="64%"><?= unpenetration($input['nama_ayah'])?></td>
                        </tr>
                        <tr>
                            <td>Tempat/Tgl. Lahir</td>
                            <td>:</td>
                            <td><?= $input['tempatlahir_ayah']; ?> , <?= tgl_indo(tgl_indo_in($input['tanggallahir_ayah'])); ?></td>
                        </tr>
                        <tr>
                            <td>Warganegara</td>
                            <td>:</td>
                            <td><?= $input['wn_ayah']; ?></td>
                        </tr>
                        <tr>
                            <td>Agama</td>
                            <td>:</td>
                            <td><?= $input['agama_ayah']; ?></td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td>:</td>
                            <td><?= $input['pek_ayah']; ?></td>
                        </tr>
                        <tr>
                            <td>Tempat Tinggal</td>
                            <td>:</td>
                            <td><?= $input['alamat_ayah']; ?></td>
                        </tr>
                    </table>
                    <?php }?>
                    <table width="100%">
                        <tr></tr>
                        <tr>
                            <td>dengan seorang wanita:</td>
                        </tr>
                        <tr></tr>
                    </table>
                    <?php if ($ibu) {?>
                    <table width="100%">
                        <tr>
                            <td width="23%">Nama Lengkap</td>
                            <td width="3%">:</td>
                            <td width="64%"><?= unpenetration($ibu['nama'])?></td>
                        </tr>
                        <tr>
                            <td>Tempat dan Tgl. Lahir</td>
                            <td>:</td>
                            <td><?= $ibu['tempatlahir']; ?>, <?= tgl_indo($ibu['tanggallahir']); ?></td>
                        </tr>
                        <tr>
                            <td>Warganegara</td>
                            <td>:</td>
                            <td><?= $ibu['wn']; ?></td>
                        </tr>
                        <tr>
                            <td>Agama</td>
                            <td>:</td>
                            <td><?= $ibu['agama']; ?></td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td>:</td>
                            <td><?= $ibu['pek']; ?></td>
                        </tr>
                        <tr>
                            <td>Tempat Tinggal</td>
                            <td>:</td>
                            <td>RW. <?= $ibu['rw']; ?>, RT. <?= $ibu['rt']; ?>, Dusun <?= unpenetration($ibu['dusun']); ?>, Kel. <?= unpenetration($desa['nama_desa']); ?>, Kec. <?= unpenetration($desa['nama_kecamatan']); ?>, Kab. <?= unpenetration($desa['nama_kabupaten']); ?></td>
                        </tr>
                    </table>
                    <?php } else {?>
                    <table width="100%">
                        <tr>
                            <td width="23%">Nama Lengkap</td>
                            <td width="3%">:</td>
                            <td width="64%"><?= unpenetration($input['nama_ibu'])?></td>
                        </tr>
                        <tr>
                            <td>Tempat dan Tgl. Lahir</td>
                            <td>:</td>
                            <td><?= $input['tempatlahir_ibu']; ?>, <?= tgl_indo(tgl_indo_in($input['tanggallahir_ibu'])); ?></td>
                        </tr>
                        <tr>
                            <td>Warganegara</td>
                            <td>:</td>
                            <td><?= $input['wn_ibu']; ?></td>
                        </tr>
                        <tr>
                            <td>Agama</td>
                            <td>:</td>
                            <td><?= $input['agama_ibu']; ?></td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td>:</td>
                            <td><?= $input['pek_ibu']; ?></td>
                        </tr>
                        <tr>
                            <td>Tempat Tinggal</td>
                            <td>:</td>
                            <td><?= $input['alamat_ibu']; ?></td>
                        </tr>
                    </table>
                    <?php }?>
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
                    </table>
                    <table width="100%">
                        <tr></tr>
                        <tr>
                            <td width="10%"></td>
                            <td width="30%"></td>
                            <td align="center"><?= unpenetration($desa['nama_desa'])?>, <?= $tanggal_sekarang?></td>
                        </tr>
                        <tr>
                            <td width="10%"></td>
                            <td width="30%"></td>
                            <td align="center"><?= unpenetration($input['jabatan'])?> <?= unpenetration($desa['nama_desa'])?></td>
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
                            <td align="center">( <?= unpenetration($input['pamong'])?> )</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div id="aside">
            </div>
        </div>
</body>

</html>
