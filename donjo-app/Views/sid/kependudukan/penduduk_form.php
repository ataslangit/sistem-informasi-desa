<script src="http://maps.googleapis.com/maps/api/js?v=2&sensor=false"></script>

<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <td style="background:#fff;padding:0px;">
                <div class="content-header">
                    <h3>Form Data Penduduk</h3>
                </div>
                <div id="contentpane">
                    <form id="mainform" name="mainform" action="<?php echo $form_action ?>" method="POST" enctype="multipart/form-data">
                        <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                            <table class="form">
                                <?php if (empty($penduduk)) { ?>
                                <tr>
                                    <th width="100">Dusun</th>
                                    <td><select name="dusun" onchange="formAction('mainform','<?php echo site_url('penduduk/form') ?>')" <?php if ($dusun) { ?>class="required" <?php } ?>>
                                            <option value="">Pilih Dusun</option>
                                            <?php foreach ($dusun as $data) { ?>
                                            <option value="<?php echo $data['dusun'] ?>" <?php if ($dus_sel == $data['dusun']) { ?>selected<?php } ?>><?php echo unpenetration(ununderscore($data['dusun'])) ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>RW</th>
                                    <td><select name="rw" onchange="formAction('mainform','<?php echo site_url('penduduk/form') ?>')" <?php if ($rw) { ?>class="required" <?php } ?>>
                                            <option value="">Pilih RW</option>
                                            <?php foreach ($rw as $data) { ?>
                                            <option value="<?php echo $data['rw'] ?>" <?php if ($rw_sel == $data['rw']) { ?>selected<?php } ?>><?php echo $data['rw'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>RT</th>
                                    <td><select name="rt" onchange="formAction('mainform','<?php echo site_url('penduduk/form') ?>')" <?php if ($rt) { ?>class="required" <?php } ?>>
                                            <option value="">Pilih RT</option>
                                            <?php foreach ($rt as $data) { ?>
                                            <option value="<?php echo $data['id'] ?>" <?php if ($rt_sel == $data['id']) { ?>selected<?php } ?>><?php echo $data['rt'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php if (!empty($rt_sel) or (!empty($penduduk))) { ?>
                                <tr>
                                    <th class="top">Foto</th>
                                    <td>
                                        <div class="userbox-avatar">
                                            <?php if ($penduduk['foto']) { ?>
                                            <img src="<?php echo base_url() ?>assets/files/user_pict/kecil_<?php echo $penduduk['foto'] ?>" alt="">
                                            <?php } else { ?>
                                            <img src="<?php echo base_url() ?>assets/files/user_pict/kuser.png" alt="">
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <input type="hidden" name="old_foto" value="<?php echo $penduduk['foto'] ?>">
                                </tr>
                                <tr>
                                    <th>Ganti Foto</th>
                                    <td><input type="file" name="foto"> <span style="color: #aaa;">(Kosongkan jika tidak ingin mengubah foto)</span></td>
                                </tr>
                                <tr>
                                    <th width="100">Nama</th>
                                    <td><input name="nama" type="text" class="inputbox required" size="60" value="<?php echo strtoupper(unpenetration($penduduk['nama'])) ?>"></td>
                                </tr>
                                <tr>
                                    <th>NIK</th>
                                    <td><input name="nik" type="text" class="inputbox required" size="30" value="<?php echo $penduduk['nik'] ?>"></td>
                                </tr>
                                <tr>
                                    <th>Akta Kelahiran</th>
                                    <td><input name="akta_lahir" type="text" class="inputbox" size="30" value="<?php echo $penduduk['akta_lahir'] ?>"></td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>
                                        <div class="uiradio">
                                            <input type="radio" id="sx1" name="sex" value="1" <?php if ($penduduk['id_sex'] == '1' or $penduduk['id_sex'] == '') {
                                                                                                        echo 'checked';
                                                                                                    } ?>>
                                            <label for="sx1">Laki-laki</label>
                                            <input type="radio" id="sx2" name="sex" value="2" <?php if ($penduduk['id_sex'] == '2') {
                                                                                                        echo 'checked';
                                                                                                    } ?>>
                                            <label for="sx2">Perempuan</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tempat Lahir</th>
                                    <td><input name="tempatlahir" type="text" class="inputbox" size="65" value="<?php echo strtoupper($penduduk['tempatlahir']) ?>"></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahir</th>
                                    <td><input name="tanggallahir" type="text" class="inputbox datepicker" size="20" value="<?php echo $penduduk['tanggallahir'] ?>"></td>
                                </tr>
                                <tr>
                                    <th>Agama</th>
                                    <td><select name="agama_id" class="required">
                                            <option value="">Pilih Agama</option>
                                            <?php foreach ($agama as $data) { ?>
                                            <option value="<?php echo $data['id'] ?>" <?php if ($penduduk['agama_id'] == $data['id']) { ?>selected<?php } ?>><?php echo strtoupper($data['nama']) ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Pendidikan dalam KK</th>
                                    <td><select name="pendidikan_kk_id">
                                            <option value="">Pilih Pendidikan</option>
                                            <?php foreach ($pendidikan_kk as $data) { ?>
                                            <option value="<?php echo $data['id'] ?>" <?php if ($penduduk['pendidikan_kk_id'] == $data['id']) { ?>selected<?php } ?>><?php echo strtoupper($data['nama']) ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Pendidikan sedang ditempuh</th>
                                    <td><select name="pendidikan_sedang_id">
                                            <option value="">Pilih Pendidikan</option>
                                            <?php foreach ($pendidikan_sedang as $data) { ?>
                                            <option value="<?php echo $data['id'] ?>" <?php if ($penduduk['pendidikan_sedang_id'] == $data['id']) { ?>selected<?php } ?>><?php echo strtoupper($data['nama']) ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan</th>
                                    <td><select name="pekerjaan_id">
                                            <option value="">Pilih Pekerjaan</option>
                                            <?php foreach ($pekerjaan as $data) { ?>
                                            <option value="<?php echo $data['id'] ?>" <?php if ($penduduk['pekerjaan_id'] == $data['id']) { ?>selected<?php } ?>><?php echo strtoupper($data['nama']) ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status Kawin</th>
                                    <td><select name="status_kawin">
                                            <option value="">Pilih Status</option>
                                            <?php foreach ($kawin as $data) { ?>
                                            <option value="<?php echo $data['id'] ?>" <?php if ($penduduk['status_kawin'] == $data['id']) { ?>selected<?php } ?>><?php echo strtoupper($data['nama']) ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Hubungan dalam Keluarga</th>
                                    <td><select name="kk_level">
                                            <option value="">Pilih Hubungan</option>
                                            <?php foreach ($hubungan as $data) { ?>
                                            <option value="<?php echo $data['id'] ?>" <?php if ($penduduk['kk_level'] == $data['id']) { ?> selected<?php } ?>><?php echo strtoupper($data['nama']) ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Warganegara</th>
                                    <td><select name="warganegara_id">
                                            <option value="">Pilih warganegara</option>
                                            <?php foreach ($warganegara as $data) { ?>
                                            <option value="<?php echo $data['id'] ?>" <?php if ($penduduk['warganegara_id'] == $data['id']) { ?>selected<?php } ?>><?php echo strtoupper($data['nama']) ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Dokumen Paspor</th>
                                    <td><input name="dokumen_pasport" type="text" class="inputbox" size="20" value="<?php echo ($penduduk['dokumen_pasport']) ?>"></td>
                                </tr>
                                <tr>
                                    <th>Dokumen KITAS</th>
                                    <td><input name="dokumen_kitas" type="text" class="inputbox" size="20" value="<?php echo ($penduduk['dokumen_kitas']) ?>"></td>
                                </tr>
                                <tr>
                                    <th>Akta Perkawinan</th>
                                    <td><input name="akta_perkawinan" type="text" class="inputbox" size="20" value="<?php echo ($penduduk['akta_perkawinan']) ?>"></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Perkawinan</th>
                                    <td><input name="tanggalperkawinan" type="text" class="inputbox datepicker" size="20" value="<?php echo $penduduk['tanggalperkawinan'] ?>"></td>
                                </tr>
                                <tr>
                                    <th>Akta Perceraian</th>
                                    <td><input name="akta_perceraian" type="text" class="inputbox" size="20" value="<?php echo ($penduduk['akta_perceraian']) ?>"></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Perceraian</th>
                                    <td><input name="tanggalperceraian" type="text" class="inputbox datepicker" size="20" value="<?php echo $penduduk['tanggalperceraian'] ?>"></td>
                                </tr>
                                <tr>
                                    <th>NIK Ayah</th>
                                    <td><input name="ayah_nik" type="text" class="inputbox" size="30" value="<?php echo $penduduk['ayah_nik'] ?>"></td>
                                </tr>
                                <tr>
                                    <th>NIK Ibu</th>
                                    <td><input name="ibu_nik" type="text" class="inputbox" size="30" value="<?php echo $penduduk['ibu_nik'] ?>"></td>
                                </tr>
                                <tr>
                                    <th>Nama Ayah</th>
                                    <td><input name="nama_ayah" type="text" class="inputbox" size="60" value="<?php echo strtoupper(unpenetration($penduduk['nama_ayah'])) ?>"></td>
                                </tr>
                                <tr>
                                    <th>Nama Ibu</th>
                                    <td><input name="nama_ibu" type="text" class="inputbox" size="60" value="<?php echo strtoupper(unpenetration($penduduk['nama_ibu'])) ?>"></td>
                                </tr>
                                <tr>
                                    <th>Golongan Darah</th>
                                    <td><select name="golongan_darah_id" class="required">
                                            <option value="">Pilih Golongan Darah</option>
                                            <?php foreach ($golongan_darah as $data) { ?>
                                            <option value="<?php echo $data['id'] ?>" <?php if ($penduduk['golongan_darah_id'] == $data['id']) { ?>selected<?php } ?>><?php echo strtoupper($data['nama']) ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <div class="uiradio">
                                            <?php $ch = 'checked'; ?>
                                            <input type="radio" id="group2" name="status" value="1" <?php if ($penduduk['status'] == "TETAP" or $penduduk['status'] == "") {
                                                                                                            echo $ch;
                                                                                                        } ?>><label for="group2">Tetap</label>
                                            <input type="radio" id="group3" name="status" value="2" <?php if ($penduduk['status'] == "TIDAK AKTIF") {
                                                                                                            echo $ch;
                                                                                                        } ?>><label for="group3">Tidak Aktif</label>
                                            <input type="radio" id="group1" name="status" value="3" <?php if ($penduduk['status'] == "PENDATANG") {
                                                                                                            echo $ch;
                                                                                                        } ?>><label for="group1">Pendatang</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Alamat Sebelumnya</th>
                                    <td><input name="alamat_sebelumnya" type="text" class="inputbox" size="60" value="<?php echo strtoupper($penduduk['alamat_sebelumnya']) ?>"></td>
                                </tr>
                                <tr>
                                    <th>Alamat Sekarang</th>
                                    <td><input name="alamat_sekarang" type="text" class="inputbox" size="60" value="<?php echo strtoupper($penduduk['alamat_sekarang']) ?>"></td>
                                </tr>
                                <tr>
                                    <th>Cacat</th>
                                    <td><select name="cacat_id">
                                            <option value="">Pilih Jenis</option>
                                            <?php foreach ($cacat as $data) { ?>
                                            <option value="<?php echo $data['id'] ?>" <?php if ($penduduk['cacat_id'] == $data['id']) { ?>selected<?php } ?>><?php echo strtoupper($data['nama']) ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status Kehamilan/ Ibu Menyusui</th>
                                    <td>
                                        <div class="uiradio">
                                            <input type="radio" id="sh2" name="hamil" value="0" <?php if ($penduduk['hamil'] == '0' or $penduduk['hamil'] == '') {
                                                                                                        echo 'checked';
                                                                                                    } ?>><label for="sh2">Tidak Hamil</label>
                                            <input type="radio" id="sh1" name="hamil" value="1" <?php if ($penduduk['hamil'] == '1') {
                                                                                                        echo 'checked';
                                                                                                    } ?>><label for="sh1">Hamil Tua</label>
                                            <input type="radio" id="sh3" name="hamil" value="2" <?php if ($penduduk['hamil'] == '2') {
                                                                                                        echo 'checked';
                                                                                                    } ?>><label for="sh3">Hamil Muda</label>
                                            <input type="radio" id="sh4" name="hamil" value="3" <?php if ($penduduk['hamil'] == '3') {
                                                                                                        echo 'checked';
                                                                                                    } ?>><label for="sh4">Ibu Menyusui</label>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                    /*
                                    <tr>
                                        <th>JAMKESMAS</th>
                                        <td>
                                        <div class="uiradio">
                                        <input type="radio" id="jkm1" name="jamkesmas" value="1"/<?php if($penduduk['jamkesmas'] == '1'){echo 'checked';}?>>
                                <label for="jkm1">Ya</label>
                                <input type="radio" id="jkm3" name="jamkesmas" value="3" /<?php if($penduduk['jamkesmas'] == '3'){echo 'checked';}?>>
                                <label for="jkm3">Lainnya</label>
                                <input type="radio" id="jkm2" name="jamkesmas" value="2" /<?php if($penduduk['jamkesmas'] == '2' OR $penduduk['jamkesmas'] == ''){echo 'checked';}?>>
                                <label for="jkm2">Tidak</label>
                        </div>
            </td>
        </tr>
        */
        ?>
        <tr>
            <th>Lokasi Penduduk</th>
            <td>
                <a href="<?php echo site_url("penduduk/ajax_penduduk_maps/$p/$o/$penduduk[id]") ?>" target="ajax-modalz" rel="window<?php echo $penduduk['id'] ?>" header="Lokasi <?php echo $penduduk['nama'] ?>" class="uibutton special" title="Lokasi <?php echo $penduduk['nama'] ?>">Edit Lokasi</a>
            </td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <th colspan="2">DOKUMEN / KELENGKAPAN PENDUDUK</th>
        </tr>
        <tr>
            <th>Dokumen / Kelengkapan Penduduk</th>
            <td>
                <a href="<?php echo site_url("penduduk/dokumen/$penduduk[id]") ?>" class="uibutton confirm">Manajemen Dokumen</a>
            </td>
        </tr>
        <?php } ?>
    </table>
    <table class="list" width="80%">
        <thead>
            <tr>
                <th width="2">No</th>
                <th width="220">Nama Dokumen</th>
                <th width="360">File</th>
                <th width="200">Tanggal Upload</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
                                    if($list_dokumen !== null) {
                                    foreach ($list_dokumen as $data) { ?>
            <tr>
                <td align="center" width="2"><?php echo $data['no'] ?></td>
                <td><?php echo $data['nama'] ?></td>
                <td><a href="<?php echo base_url() ?>assets/files/dokumen/<?php echo urlencode($data['satuan']) ?>"><?php echo $data['satuan'] ?></a></td>
                <td><?php echo tgl_indo2($data['tgl_upload']) ?></td>
                <td></td>
            </tr>
            <?php }
                                    } ?>
        </tbody>
    </table>
</div>
<div class="ui-layout-south panel bottom">
    <div class="left">
        <a href="<?php echo site_url() ?>penduduk" class="uibutton icon prev">Kembali</a>
    </div>
    <div class="right">
        <div class="uibutton-group">
            <button class="uibutton confirm" type="submit">Simpan</button>
        </div>
    </div>
</div>
</form>
</div>
</td>
</tr>
</table>
</div>
