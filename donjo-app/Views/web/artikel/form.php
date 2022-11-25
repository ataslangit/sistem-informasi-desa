<script src="<?php echo base_url()?>assets/tiny_mce/jquery.tinymce.min.js"></script>
<script src="<?php echo base_url()?>assets/tiny_mce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: 'textarea',
        height: 600,
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code ',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image,print preview media | forecolor backcolor emoticons',
        image_advtab: true
    });

</script>
<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <td style="background:#fff;padding:0px;">
                <div id="contentpane">
                    <form id="validasi" action="<?php echo $form_action?>" method="POST" enctype="multipart/form-data">
                        <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
                            <h3>Form Artikel <?php if($kategori){echo $kategori['kategori'];}else{echo "Artikel Statis";}?></h3>
                            <table class="form">
                                <tr>
                                    <th width="120">Judul Artikel</th>
                                    <td><input class="inputbox" type="text" name="judul" value="<?php echo @$artikel['judul'] ?>" size="60"></td>
                                </tr>
                                <tr>
                                <tr>
                                    <th width="120" colspan="2">Isi Artikel</th>
                                </tr>
                                <tr>
                                <tr>
                                    <td colspan="2">
                                        <textarea name="isi" style="width: 800px; height: 500px;"><?php echo @$artikel['isi'] ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <th>Dokumen Lampiran</th>
                                    <td><input type="file" name="dokumen"> <span style="color: #aaa;"></span></td>
                                </tr>
                                <?php if(isset($artikel['dokumen'])){?>
                                <tr>
                                    <th class="top">Dokumen</th>
                                    <td>
                                        <a href="<?php echo base_url('assets/files/dokumen/' . $artikel['dokumen']) ?>">Download</a>
                                    </td>
                                </tr>
                                <?php }?>
                                <tr>
                                    <th>Nama Dokumen (Nantinya akan menjadi link unduh/download)</th>
                                    <td><input size="30" type="text" name="link_dokumen" value="<?php echo @$artikel['link_dokumen'] ?>"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="background-color:#ffddcc;">
                                        &nbsp;
                                    </td>
                                </tr>
                                <?php if(isset($artikel['gambar'])){?>
                                <tr>
                                    <th class="top">Gambar</th>
                                    <td>
                                        <div class="gallerybox-avatar">
                                            <img src="<?php echo base_url('assets/files/artikel/kecil_' . $artikel['gambar']) ?>" alt="" width="200">
                                        </div><input type="checkbox" name="gambar_hapus" value="<?php echo $artikel['gambar']?>"> Hapus Gambar
                                    </td>
                                </tr>
                                <?php }?>
                                <tr>
                                    <th>Unggah/Upload Gambar Utama</th>
                                    <td><input type="file" name="gambar"> <span style="color: #aaa;">(Kosongi jika tidak ingin mengubah gambar)</span></td>
                                </tr>
                                <tr>
                                    <th class="top">Gambar</th>
                                    <td>
                                        <?php if(isset($artikel['gambar1'])){?>
                                        <div class="gallerybox-avatar">
                                            <img src="<?php echo base_url('assets/files/artikel/kecil_' . $artikel['gambar1']) ?>" alt="" width="200">
                                        </div> <input type="checkbox" name="gambar1_hapus" value="<?php echo $artikel['gambar1']?>"> Hapus Gambar
                                    </td>
                                </tr>
                                <?php }?>
                                <tr>
                                    <th>Gambar Tambahan</th>
                                    <td><input type="file" name="gambar1"> <span style="color: #aaa;">(Kosongi jika tidak ingin mengubah gambar)</span></td>
                                </tr>
                                <tr>
                                    <th class="top">Gambar</th>
                                    <td>
                                        <?php if(isset($artikel['gambar2'])){?>
                                        <div class="gallerybox-avatar">
                                            <img src="<?php echo base_url('assets/files/artikel/kecil_' . $artikel['gambar2']) ?>" alt="" width="200">
                                        </div> <input type="checkbox" name="gambar2_hapus" value="<?php echo $artikel['gambar2']?>"> Hapus Gambar
                                    </td>
                                </tr>
                                <?php }?>
                                <tr>
                                    <th>Gambar Tambahan</th>
                                    <td><input type="file" name="gambar2"> <span style="color: #aaa;">(Kosongi jika tidak ingin mengubah gambar)</span></td>
                                </tr>
                                <tr>
                                    <th class="top">Gambar</th>
                                    <td>
                                        <?php if(isset($artikel['gambar3'])){?>
                                        <div class="gallerybox-avatar">
                                            <img src="<?php echo base_url('assets/files/artikel/kecil_' . $artikel['gambar3']) ?>" alt="" width="200">
                                        </div> <input type="checkbox" name="gambar3_hapus" value="<?php echo $artikel['gambar3']?>"> Hapus Gambar
                                    </td>
                                </tr>
                                <?php }?>
                                <tr>
                                    <th>Gambar Tambahan</th>
                                    <td><input type="file" name="gambar3"> <span style="color: #aaa;">(Kosongi jika tidak ingin mengubah gambar)</span></td>
                                </tr>
                            </table>
                        </div>

                        <div class="ui-layout-south panel bottom">
                            <div class="left">
                                <a href="<?php echo site_url()?>web/index/<?php echo $cat?>" class="uibutton icon prev">Kembali</a>
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
