<?php
?>
<div id="pageC">
    <table class="inner">
        <tr style="vertical-align:top">
            <td class="side-menu">
                <?php
		view('program_bantuan/menu_kiri.php')
		?>
            </td>
            <td class="contentpane">
                <legend>Form Penulisan Program Bantuan</legend>
                <div class="contentpane">
                    <?php echo validation_errors(); ?>
                    <?php echo form_open('program_bantuan/form') ?>
                    <div class="form-group">
                        <label>Sasaran Program</label>
                        <select class="form-control" name="cid" id="cid">
                            <option value="">Pilih Sasaran Program</option>
                            <option value="0">Penduduk Perorangan</option>
                            <option value="1">Keluarga - KK</option>
                            <option value="2">Rumah Tangga</option>
                            <option value="3">Kelompok</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Program</label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Tuliskan nama program">
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea class="form-control" name="nama" id="nama" placeholder="Tuliskan nama program">
						</textarea>
                    </div>
                    <div class="form-group">
                        <label>Rentang Waktu Program</label>
                        Mulai <input type="text" class="inputbox required" style="width:200px" name="sdate" id="sdate" placeholder="" value="">
                        s.d <input type="text" class="inputbox required" style="width:200px" name="edate" id="edate" placeholder="" value="">
                    </div>

                    <div class="form-group">
                        <div class="uibutton-group">
                            <input type="submit" class="uibutton confirm" name="tombol" id="tombol" value="Simpan">
                            <input type="reset" class="uibutton" name="tombolreset" id="tombolreset" value="Batal">
                        </div>
                    </div>
                    </form>
                </div>
            </td>
            <td style="width:250px;" class="contentpane">
                <h3>Panduan</h3>
                <p>Isikanlah formulir disamping ini untuk menambahkan data program bantuan. </p>
                <p>
                <ul>
                    <li>Kolom <strong>Sasaran Program</strong>
                        <p>Pilihlah salah satu dari sasaran program, apakah pribadi/perorangan, keluarga/kk, Rumah Tangga, ataupu Organisasi/kelompok warga</p>
                    </li>
                    <li>Kolom <strong>Nama Program</strong>
                        <p>Nama program wajib diisi</p>
                    </li>
                    <li>Kolom <strong>Keterangan Program</strong>
                        <p>Isikan keterangan program ini</p>
                    </li>
                </ul>
                </p>
            </td>
        </tr>
    </table>
    <script>
        $(document).ready(function() {
            var daysToAdd = 4;
            $("#sdate").datepicker({
                onSelect: function(selected) {
                    var dtMax = new Date(selected);
                    dtMax.setDate(dtMax.getDate() + daysToAdd);
                    var dd = dtMax.getDate();
                    var mm = dtMax.getMonth() + 1;
                    var y = dtMax.getFullYear();
                    var dtFormatted = mm + '/' + dd + '/' + y;
                    $("#edate").datepicker("option", "minDate", dtFormatted);
                }
            });

            $("#edate").datepicker({
                onSelect: function(selected) {
                    var dtMax = new Date(selected);
                    dtMax.setDate(dtMax.getDate() - daysToAdd);
                    var dd = dtMax.getDate();
                    var mm = dtMax.getMonth() + 1;
                    var y = dtMax.getFullYear();
                    var dtFormatted = mm + '/' + dd + '/' + y;
                    $("#sdate").datepicker("option", "maxDate", dtFormatted)
                }
            });
        });

    </script>
    <script src="<?php echo base_url()?>assets/tiny_mce/tiny_mce_src.js"></script>
    <script>
        tinyMCE.init({

            mode: "textareas",
            theme: "advanced",
            relative_urls: false,
            language: "en",
            skin: "o2k7",
            plugins: "jbimages,lists,pagebreak,table,advlink,preview,paste,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",

            theme_advanced_buttons1: "pastetext,pasteword,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,jbimages,cleanup,help,code,|,preview,|,forecolor,backcolor|,fullscreen",
            theme_advanced_toolbar_location: "top",
            theme_advanced_toolbar_align: "left",
            theme_advanced_statusbar_location: "bottom",
            theme_advanced_resizing: true,

            skin: "o2k7",
            skin_variant: "blue"
        });

    </script>
</div>
