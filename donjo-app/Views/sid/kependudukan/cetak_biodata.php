<?= view('print/headjs.php'); ?>

<body>
    <div id="content" class="container_12 clearfix">
        <div id="content-main" class="grid_7">
            <link href="<?= base_url('assets/css/surat.css') ?>" rel="stylesheet">
            <div>
                <table width="100%">
                    <div>

                        <div align="center">
                            <td rowspan="18" align="center"><?php if ($penduduk['foto']) {?>
                                <img src="<?= base_url('assets/files/user_pict/kecil_' . $penduduk['foto']) ?>" alt="">
                                <?php }?>
                            </td>
                        </div>
                        <div align="center">
                            <h3 style="text-decoration: underline;">BIODATA PENDUDUK WARGANEGARA INDONESIA</h3>
                        </div>
                        <br>
                        <div style="display: inline-block;">
                            <table width="100%">
                                <tr>
                                    <td width="90">Kabupaten</td>
                                    <td width="2px">:</td>
                                    <td width="300"><?= $desa['desa']['nama_kabupaten']?></td>
                                    <td width="90">Desa</td>
                                    <td width="2px">:</td>
                                    <td><?= $desa['desa']['nama_desa']?></td>
                                </tr>
                                <tr>
                                    <td>Kecamatan</td>
                                    <td>:</td>
                                    <td><?= $desa['desa']['nama_kecamatan']?></td>
                                    <td width="90">Dusun</td>
                                    <td width="2px">:</td>
                                    <td><?= strtoupper($penduduk['dusun'])?></td>
                                </tr>

                            </table>
                        </div>
                        <hr>
                        </hr>
                        <table width="100%">
                            <tr>
                                <td style="font-weight:bold; line-height: 2em;" colspan="2">DATA PERSONAL</td>
                            </tr>
                            <tr>
                                <td width="2px">1.</td>
                                <td width="300">Nama</td>
                                <td width="2px">:</td>
                                <td><?= strtoupper($penduduk['nama'])?></td>

                            <tr>
                                <td width="2px">2.</td>
                                <td>NIK</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['nik'])?></td>
                            </tr>

                            <tr>
                                <td width="2px">3.</td>
                                <td>Dusun</td>
                                <td>:</td>
                                <td><?= strtoupper(ununderscore($penduduk['dusun']))?></td>
                            </tr>

                            <tr>
                                <td width="2px">4.</td>
                                <td>RT/ RW</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['rt'])?> / <?= $penduduk['rw']?></td>
                            </tr>

                            <tr>
                                <td width="2px">5.</td>
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['sex'])?></td>
                            </tr>

                            <tr>
                                <td width="2px">6.</td>
                                <td>Tempat / Tanggal Lahir</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['tempatlahir'])?> / <?= strtoupper($penduduk['tanggallahir'])?></td>
                            </tr>

                            <tr>
                                <td width="2px">7.</td>
                                <td>Agama</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['agama'])?></td>
                            </tr>
                            <tr>
                                <td width="2px">8.</td>
                                <td>Pendidikan</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['pendidikan'])?></td>
                            </tr>
                            <tr>
                                <td width="2px">9.</td>
                                <td>Pekerjaan</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['pekerjaan'])?></td>
                            </tr>

                            <tr>
                                <td width="2px">10.</td>
                                <td>Status Kawin</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['kawin'])?></td>
                            </tr>
                            <tr>
                                <td width="2px">11.</td>
                                <td>Warga Negara</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['warganegara'])?></td>
                            </tr>

                            <tr>
                                <td width="2px">12.</td>
                                <td>Alamat Sekarang</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['alamat_sekarang'])?></td>
                            </tr>
                            <tr>
                                <td width="2px">13.</td>
                                <td>Akta perkawinan</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['akta_perkawinan'])?></td>
                            </tr>

                            <tr>
                                <td width="2px">14.</td>
                                <td>Data Orang Tua</td>
                            </tr>
                            <tr>
                                <td width="2px">15.</td>
                                <td>NIK Ayah</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['ayah_nik'])?></td>
                            </tr>
                            <tr>
                                <td width="2px">16.</td>
                                <td>Nama Ayah</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['nama_ayah'])?></td>
                            </tr>
                            <tr>
                                <td width="2px">17.</td>
                                <td>NIK Ibu</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['ibu_nik'])?></td>
                            </tr>
                            <tr>
                                <td width="2px">18.</td>
                                <td>Nama Ibu</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['nama_ibu'])?></td>
                            </tr>
                            <tr>
                                <td width="2px">19.</td>
                                <td>Status</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['status'])?></td>
                            </tr>

                            <tr>
                                <td colspan="2" style="font-weight:bold; line-height: 2em;">DATA KEPEMILIKAN DOKUMEN</td>
                            </tr>
                            <tr>
                                <td width="2px">1.</td>
                                <td>Nomor Kartu Keluarga (No.KK)</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['no_kk'])?></td>
                            </tr>
                            <tr>
                                <td width="2px">2.</td>
                                <td>Nomor Akta Kelahiran</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['akta_lahir'])?></td>
                            </tr>
                            <tr>
                                <td width="2px">3.</td>
                                <td>Dokumen Pasport</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['dokumen_pasport'])?></td>
                            </tr>
                            <tr>
                                <td width="2px">4.</td>
                                <td>Dokumen Kitas</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['dokumen_kitas'])?></td>
                            </tr>
                            <tr>
                                <td width="2px">5.</td>
                                <td>Nomor Paspor</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['no_paspor'])?></td>
                            </tr>

                            <tr>
                                <td width="2px">6.</td>
                                <td>Nomor Perkawinan</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['nomor_kawin'])?></td>
                            </tr>
                            <tr>
                                <td width="2px">7.</td>
                                <td>Tanggal perkawinan</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['tanggalperkawinan'])?></td>
                            </tr>
                            <tr>
                                <td width="2px">8.</td>
                                <td>Akta perceraian</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['akta_perceraian'])?></td>
                            </tr>
                            <tr>
                                <td width="2px">9.</td>
                                <td>Tanggal perceraian</td>
                                <td>:</td>
                                <td><?= strtoupper($penduduk['tanggalperceraian'])?></td>
                            </tr>

                        </table>
                    </div>
            </div>


        </div>
        <div style="float:right;">
            <label>Tanggal cetak : &nbsp; </label><?= tgl_indo(date('Y m d'))?>
        </div>
    </div>
</body>

</html>
