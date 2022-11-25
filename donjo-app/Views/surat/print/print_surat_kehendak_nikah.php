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
                    <table width="100%">
                        <tr>
                            <td width="10%">Lampiran</td>
                            <td>:</td>
                            <td width="43%" align="left"><?php echo $input['jml_lampiran'] ?> lembar </td>
                            <td align="left"><?php echo unpenetration($desa['nama_desa'])?>, <?php echo $tanggal_sekarang?></td>
                        </tr>
                        <tr>
                        <tr></tr>
                        <tr></tr>
                        <td width="10%">Perihal</td>
                        <td>:</td>
                        <td width="43%" align="left">Pemberitahuan Kehendak Nikah </td>
                        </tr>
                        <tr>
                            <table>
                                <tr></tr>
                                <tr></tr>
                                <tr></tr>
                                <tr></tr>
                                <tr></tr>
                                <tr></tr>
                                <td align="left">Kepada Yth. </br>Kepala KUA / Penghulu Kecamatan <?php echo unpenetration($desa['nama_kecamatan']) ?></td>
                                <tr></tr>
                                <tr></tr>
                                <tr></tr>
                                <tr></tr>
                                <tr></tr>
                                <tr></tr>
                            </table>
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
                    </table>
                </table>
                <div id="isi3">
                    <table width="100%">
                        <tr>
                            <td class="indentasi">Assalamualaikum Wr. Wb.
                            <td>
                        </tr>
                        <tr>
                            <td class="indentasi">Dengan ini kami memberitahukan bahwa akan dilangsungkan pernikahan antara <?php echo unpenetration($input['suami']) ?> dengan <?php echo unpenetration($input['istri']) ?> pada hari <?php echo $input['hari'] ?>, tanggal <?php echo tgl_indo(tgl_indo_in($input['tanggal'])) ?> jam <?php echo $input['jam'] ?> dengan maskawin berupa <?php echo $input['mas_kawin'] ?> dibayar <?php echo $input['tunai'] ?> bertempat di <?php echo $input['tempat'] ?></td>
                        </tr>
                        <tr>
                            <td class="indentasi">Bersama ini kami lampirkan surat-surat yang diperlukan untuk diperiksa, sebagai berikut :</td>
                        </tr>
                        <tr>
                            <td><?php echo $input['lampiran1']?></td>
                        </tr>
                        <tr>
                            <td><?php echo $input['lampiran2']?></td>
                        </tr>
                        <tr>
                            <td><?php echo $input['lampiran3']?></td>
                        </tr>
                        <tr>
                            <td><?php echo $input['lampiran4']?></td>
                        </tr>
                        <tr>
                            <td><?php echo $input['lampiran5']?></td>
                        </tr>
                        <tr>
                            <td><?php echo $input['lampiran6']?></td>
                        </tr>
                        <tr>
                            <td><?php echo $input['lampiran7']?></td>
                        </tr>
                        <tr>
                            <td><?php echo $input['lampiran8']?></td>
                        </tr>
                        <tr></tr>
                        <tr>
                            <td class="indentasi">Kami mohon pernikahan tersebut dapat dihadiri/ diawasi dan dicatat oleh Bapak Penghulu sesuai dengan ketentuan perundang-undangan yang berlaku.</td>
                        </tr>
                        <tr>
                            <td class="indentasi">Wassalamualaikum Wr. Wb.</td>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr></tr>
                        <tr>
                            <td width="50%">Diterima Tanggal : ________________</td>
                            <td></td>
                            <td width="50%"></td>
                        </tr>
                        <tr></tr>
                        <tr></tr>
                        <tr>
                            <td align="center">Yang menerima</td>
                            <td></td>
                            <td align="center">Yang memberitahukan</td>
                        </tr>
                        <tr>
                            <td align="center">Kepala KUA/ Penghulu *)</td>
                            <td></td>
                            <td align="center">Calon mempelai / Wali/ Wakil Wali *)</td>
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
                        <tr></tr>
                        <tr>
                            <td align="center">__________________________</td>
                            <td></td>
                            <td align="center">( <?php echo unpenetration($data['nama']) ?> )</td>
                        </tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr>
                            <td align="center">*) coret yang tidak perlu </td>
                            <td></td>
                            <td align="center"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div id="aside">
            </div>
        </div>
</body>

</html>
