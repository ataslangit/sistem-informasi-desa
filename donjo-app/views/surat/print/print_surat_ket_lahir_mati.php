<?php $this->load->view('print/headjs.php'); ?>

<body>
    <div id="content" class="container_12 clearfix">
        <div id="content-main" class="grid_7">
            <link href="<?= base_url() ?>assets/css/surat.css" rel="stylesheet" type="text/css" />
            <div>
                <table width="100%">
                    <tr> <img src="<?= base_url() ?>assets/files/logo/<?= $desa['logo'] ?>" alt="" class="logo"></tr>
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
                            <h4 class="kop">SURAT KETERANGAN LAHIR MATI</h4>
                        </u></div>
                    <div align="center">
                        <h4 class="kop3">Nomor : <?= $input['nomor'] ?></h4>
                    </div>
                </table>
                <div class="clear"></div>
                <table width="100%">
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <td class="indentasi">Yang bertanda tangan dibawah ini <?= unpenetration($input['jabatan']) ?> <?= unpenetration($desa['nama_desa']) ?>, Kecamatan <?= unpenetration($desa['nama_kecamatan']) ?>,
                        Kabupaten <?= unpenetration($desa['nama_kabupaten']) ?>, Provinsi <?= unpenetration($desa['nama_propinsi']) ?> menerangkan dengan sebenarnya bahwa seorang ibu: </td>
                    </tr>
                </table>
                <div id="isi3">
                    <table width="100%">
                        <tr>
                            <td width="40%">Nama Lengkap</td>
                            <td width="3%">:</td>
                            <td><?= unpenetration($data['nama']) ?></td>
                        </tr>
                        <tr>
                            <td>NIK/ No KTP</td>
                            <td width="3%">:</td>
                            <td><?= $data['nik'] ?></td>
                        </tr>
                        <tr>
                            <td>Tempat dan Tgl. Lahir </td>
                            <td>:</td>
                            <td><?= $data['tempatlahir'] ?>, <?= tgl_indo($data['tanggallahir']) ?> </td>
                        </tr>
                        <tr>
                            <td>Alamat/ Tempat Tinggal</td>
                            <td>:</td>
                            <td>RT. <?= $data['rt'] ?>, RW. <?= $data['rw'] ?>, Dusun <?= unpenetration(ununderscore($data['dusun'])) ?>, Desa <?= unpenetration($desa['nama_desa']) ?>, Kec. <?= unpenetration($desa['nama_kecamatan']) ?>, Kab. <?= unpenetration($desa['nama_kabupaten']) ?></td>
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
                        <tr>
                            <td>Kewarganegaraan </td>
                            <td>:</td>
                            <td><?= $data['warganegara'] ?></td>
                        </tr>
                        <tr>
                            <td>Pada hari, tanggal</td>
                            <td>:</td>
                            <td> <?= $input['hari'] ?>, <?= tgl_indo(tgl_indo_in($input['tanggal_mati'])) ?></td>
                        </tr>
                        <tr>
                            <td>di </td>
                            <td>:</td>
                            <td> <?= $input['tempat_mati'] ?></td>
                        </tr>
                    </table>
                    <div id="isi3">
                        <table width="100%">
                            <tr>
                                <td colspan="3">telah lahir bayi dalam keadaan mati, setelah dikandungannya selama <?= $input['lama_kandungan'] ?> bulan </td>
                            </tr>
                            <tr>
                                <td colspan="3">Surat keterangan Lahir Mati ini dibuat atas dasar yang sebenarnya. </td>
                            </tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr>
                                <td width="40%">Pelapor</td>
                                <td width="3%">:</td>
                                <td> <?= $input['pelapor'] ?></td>
                            </tr>
                            <tr>
                                <td>Hubungn dengan yang Lahir Mati </td>
                                <td>:</td>
                                <td> <?= $input['hubungan'] ?></td>
                            </tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
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
