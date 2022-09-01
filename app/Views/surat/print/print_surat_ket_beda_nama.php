<?php echo view('print/headjs.php'); ?>

<body>
    <div id="content" class="container_12 clearfix">
        <div id="content-main" class="grid_7">
            <link href="<?= base_url() ?>/assets/css/surat.css" rel="stylesheet" type="text/css" />
            <div>
                <table width="100%">
                    <tr> <img src="<?= base_url() ?>/assets/files/logo/<?= $desa['logo'] ?>" alt="" class="logo"></tr>
                    <div class="header">
                        <h4 class="kop">PEMERINTAH KABUPATEN <?= strtoupper(unpenetration($desa['nama_kabupaten'])) ?> </h4>
                        <h4 class="kop">KECAMATAN <?= strtoupper(unpenetration($desa['nama_kecamatan'])) ?> </h4>
                        <h4 class="kop">DESA <?= strtoupper(unpenetration($desa['nama_desa'])) ?></h4>
                        <h5 class="kop2"><?= unpenetration($desa['alamat_kantor']) ?> </h5>
                        <div style="text-align: center;">
                            <hr />
                        </div>
                    </div>
                    <div align="center"><u>
                            <h4 class="kop">SURAT KETERANGAN BEDA IDENTITAS</h4>
                        </u></div>
                    <div align="center">
                        <h4 class="kop3">Nomor : <?= $input['nomor'] ?></h4>
                    </div>
                </table>
                <div class="clear"></div>
                <table width="100%">
                    <td class="indentasi">Yang bertanda tangan dibawah ini <?= unpenetration($input['jabatan']) ?> <?= unpenetration($desa['nama_desa']) ?>, Kecamatan <?= unpenetration($desa['nama_kecamatan']) ?>,
                        Kabupaten <?= unpenetration($desa['nama_kabupaten']) ?>, Provinsi <?= unpenetration($desa['nama_propinsi']) ?> menerangkan dengan sebenarnya bahwa: </td>
                    </tr>
                </table>
                <div id="isi3">
                    <table width="100%">
                        <tr></tr>
                        <tr>
                            <td colspan="3">I. Identitas dalam KK</td>
                        </tr>
                        <tr>
                            <td width="30%">Nama Lengkap</td>
                            <td width="3%">:</td>
                            <td width="64%"><?= unpenetration($data['nama']) ?></td>
                        </tr>
                        <tr>
                            <td>Tempat dan Tgl. Lahir </td>
                            <td>:</td>
                            <td><?= $data['tempatlahir'] ?>, <?= tgl_indo($data['tanggallahir']) ?> </td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td><?= $data['sex'] ?></td>
                        </tr>
                        <tr>
                            <td>Alamat/ Tempat Tinggal</td>
                            <td>:</td>
                            <td>RW. <?= $data['rw'] ?>, RT. <?= $data['rt'] ?>, Dusun <?= unpenetration(ununderscore($data['dusun'])) ?>, Desa <?= unpenetration($desa['nama_desa']) ?>, Kec. <?= unpenetration($desa['nama_kecamatan']) ?>, Kab. <?= unpenetration($desa['nama_kabupaten']) ?></td>
                        </tr>
                        <tr>
                            <td>Agama</td>
                            <td>:</td>
                            <td><?= $data['agama'] ?></td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td>:</td>
                            <td><?= $data['pekerjaan'] ?></td>
                        </tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr>
                            <td colspan="3">II. Identitas dalam <?= $input['kartu'] ?></td>
                            <td width="3%"></td>
                            <td width="64%"></td>
                        </tr>
                        <tr>
                            <td width="30%">No Identitas</td>
                            <td width="3%">:</td>
                            <td width="64%"><?= $input['identitas'] ?></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td><?= $input['nama'] ?></td>
                        </tr>
                        <tr>
                            <td>Tempat dan Tanggal Lahir
                            <td>:</td>
                            <td><?= $input['tempatlahir'] ?> <?= tgl_indo(tgl_indo_in($input['tanggallahir'])) ?> </td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td><?= $input['sex'] ?></td>
                        </tr>
                        <tr>
                            <td>Alamat/ Tempat Tinggal</td>
                            <td>:</td>
                            <td><?= $input['alamat'] ?></td>
                        </tr>
                        <tr>
                            <td>Agama</td>
                            <td>:</td>
                            <td><?= $input['agama'] ?></td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td>:</td>
                            <td><?= $input['pekerjaan'] ?></td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td>:</td>
                            <td><?= $input['keterangan'] ?></td>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr></tr>
                        <tr></tr>
                        <tr>
                            <td class="indentasi">Adalah benar-benar warga Desa <?= unpenetration($desa['nama_desa']) ?> dan merupakan orang yang sama namun terdapat perbedaan <?= $input['perbedaan'] ?> seperti tersebut di atas. Adapun data yang benar dan dipakai seperti yang tercantum di Kartu Keluarga (KK). </td>
                        </tr>
                        <tr>
                            <td class="indentasi">Demikian surat keterangan ini dibuat dengan sesungguhnya agar dapat dipergunakan sebagaimana mestinya</td>
                        </tr>
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
                    <tr></tr>
                    <tr></tr>
                    <tr>
                        <td width="23%"></td>
                        <td width="30%"></td>
                        <td align="center"><?= unpenetration($desa['nama_desa']) ?>, <?= $tanggal_sekarang ?></td>
                    </tr>
                    <tr>
                        <td width="23%"></td>
                        <td width="30%"></td>
                        <td align="center"><?= unpenetration($input['jabatan']) ?> <?= unpenetration($desa['nama_desa']) ?></td>
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
                        <td align="center">( <?= unpenetration($input['pamong']) ?> )</td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="aside">
        </div>
    </div>
</body>

</html>
