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
                            <h4 class="kop">SURAT KETERANGAN IZIN ORANG TUA</h4>
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
                    <td class="indentasi">Yang bertanda tangan dibawah ini: </td>
                    </tr>
                </table>
                <div id="isi2">
                    <table width="100%">
                        <tr>
                            <td width="30%">Nama Lengkap</td>
                            <td width="3%">:</td>
                            <td width="64%"><?= unpenetration($ayah['nama']); ?></td>
                        </tr>
                        <tr>
                            <td>Tempat dan tanggal lahir</td>
                            <td>:</td>
                            <td><?= $ayah['tempatlahir']; ?>, <?= tgl_indo(($ayah['tanggallahir'])); ?></td>
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
                        <tr></tr>
                        <tr>
                            <td width="30%">Nama Lengkap</td>
                            <td width="3%">:</td>
                            <td width="64%"><?= unpenetration($ibu['nama']); ?></td>
                        </tr>
                        <tr>
                            <td>Tempat dan tanggal lahir</td>
                            <td>:</td>
                            <td><?= $ibu['tempatlahir']; ?>, <?= tgl_indo(($ibu['tanggallahir'])); ?></td>
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
                            <td>RT. <?= $ibu['rt']; ?>, RW. <?= $ibu['rw']; ?>, Dusun <?= unpenetration(ununderscore($ibu['dusun'])); ?>, Kel. <?= unpenetration($desa['nama_desa']); ?>, Kec. <?= unpenetration($desa['nama_kecamatan']); ?>, Kab. <?= unpenetration($desa['nama_kabupaten']); ?></td>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr></tr>
                        <tr>
                            <td class="indentasi">Adalah ayah kandung dan ibu kandung dari</td>
                        </tr>
                        <tr></tr>
                    </table>
                    <table width="100%">
                        <tr>
                            <td width="30%">Nama Lengkap</td>
                            <td width="3%">:</td>
                            <td width="64%"><?= unpenetration($pribadi['nama']); ?></td>
                        </tr>
                        <tr>
                            <td>Tempat dan tanggal lahir</td>
                            <td>:</td>
                            <td><?= $pribadi['tempatlahir']; ?>, <?= tgl_indo($pribadi['tanggallahir']); ?></td>
                        </tr>
                        <tr>
                            <td>Warganegara</td>
                            <td>:</td>
                            <td><?= $pribadi['wn']; ?></td>
                        </tr>
                        <tr>
                            <td>Agama</td>
                            <td>:</td>
                            <td><?= $pribadi['agama']; ?></td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td>:</td>
                            <td><?= $pribadi['pek']; ?></td>
                        </tr>
                        <tr>
                            <td>Tempat Tinggal</td>
                            <td>:</td>
                            <td>RT. <?= $pribadi['rt']; ?>, RW. <?= $pribadi['rw']; ?>, Dusun <?= unpenetration(ununderscore($pribadi['dusun'])); ?>, Kel. <?= unpenetration($desa['nama_desa']); ?>, Kec. <?= unpenetration($desa['nama_kecamatan']); ?>, Kab. <?= unpenetration($desa['nama_kabupaten']); ?></td>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr></tr>
                        <tr>
                            <td class="indentasi">Memberikan izin kepadanya untuk melakukan pernikahan dengan:</td>
                        </tr>
                        <tr></tr>
                    </table>
                    <table width="100%">
                        <tr>
                            <td width="30%">Nama Lengkap</td>
                            <td width="3%">:</td>
                            <td width="64%"><?= unpenetration($input['nama_pasangan']); ?></td>
                        </tr>
                        <tr>
                            <td>Tempat dan tanggal lahir</td>
                            <td>:</td>
                            <td><?= $input['tempatlahir_pasangan']; ?>, <?= tgl_indo(tgl_indo_in($input['tanggallahir_pasangan'])); ?></td>
                        </tr>
                        <tr>
                            <td>Warganegara</td>
                            <td>:</td>
                            <td><?= $input['wn_pasangan']; ?></td>
                        </tr>
                        <tr>
                            <td>Agama</td>
                            <td>:</td>
                            <td><?= $input['agama_pasangan']; ?></td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td>:</td>
                            <td><?= $input['pekerjaan_pasangan']; ?></td>
                        </tr>
                        <tr>
                            <td>Tempat Tinggal</td>
                            <td>:</td>
                            <td><?= $input['alamat_pasangan']; ?></td>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr>
                            <td class="indentasi">Demikianlah surat izin ini dibuat dengan kesadaran tanpa ada paksaan dari siapapun juga dan dipergunakan seperlunya.</td>
                        </tr>
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
                        <td width="30%"></td>
                        <td width="33%"></td>
                        <td align="center"><?= unpenetration($desa['nama_desa'])?>, <?= $tanggal_sekarang?></td>
                    </tr>
                    <tr>
                        <td width="30%" align="center">I. Ayah</td>
                        <td width="33%"></td>
                        <td align="center">II. Ibu</td>
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
                        <td align="center">( <?= unpenetration($ayah['nama_ayah']); ?> )
                        <td></td>
                        <td align="center">( <?= unpenetration($ibu['nama_ibu']); ?> )</td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="aside">
        </div>
    </div>
</body>

</html>
