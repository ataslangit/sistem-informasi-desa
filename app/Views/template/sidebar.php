<div id="rightcolumn">
    <div class="innertube">

        <!-- widget Agenda-->
        <div class="box box-primary box-solid">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-user"></i> Layanan Mandiri</h3><br />
                Silakan datang / hubungi perangkat desa untuk mendapatkan kode PIN Anda.
            </div>
            <div class="box-body">
                <h4>Masukkan NIK dan PIN!</h4>
                <form action="<?= site_url() ?>first/auth" method="post" accept-charset="utf-8">
                    <input name="nik" type="text" placeholder="NIK" value="" required>
                    <input type="password" name="pin" value="" placeholder="PIN" required />
                    <button type="submit" id="but">Masuk</button>
                </form>
            </div>
        </div>
        <div class="box box-primary box-solid">
            <div class="box-header">
                <h3 class="box-title"><a href="<?= site_url() ?>first/kategori/4"><i class="fa fa-calendar"></i> Agenda</a></h3>
            </div>
            <div class="box-body">
                <ul class="sidebar-latest">
                    <li><a href="<?= site_url() ?>first/artikel/32">Agenda Kegiatan Desa Bumi Pertiwi per Februari 2017</a></li>
                    <li><a href="<?= site_url() ?>first/artikel/31">Agenda Kegiatan Desa Bumi Pertiwi per Januari 2017</a></li>
                </ul>
            </div>
        </div>
        <!-- widget Galeri-->
        <div class="box box-warning box-solid">
            <div class="box-header">
                <h3 class="box-title"><a href="<?= site_url() ?>first/gallery"><i class="fa fa-camera"></i> Galeri Foto</a></h3>
            </div>
            <div class="box-body">
                <ul class="sidebar-latest">

                    <a class="group3" href="<?= site_url() ?>assets/files/galeri/sedang_2017 02 - Contoh Foto SID 3.10.jpg">

                        <img src="<?= site_url() ?>assets/files/galeri/kecil_2017 02 - Contoh Foto SID 3.10.jpg" width="130" alt="Tani 2">

                    </a>

                    <a class="group3" href="<?= site_url() ?>assets/files/galeri/sedang_2017 02 - Contoh Foto SID 3.10 c.jpg">

                        <img src="<?= site_url() ?>assets/files/galeri/kecil_2017 02 - Contoh Foto SID 3.10 c.jpg" width="130" alt="Tani 1">

                    </a>

                    <a class="group3" href="<?= site_url() ?>assets/files/galeri/sedang_2017 02 - Contoh Foto SID 3.10 d.jpg">

                        <img src="<?= site_url() ?>assets/files/galeri/kecil_2017 02 - Contoh Foto SID 3.10 d.jpg" width="130" alt="Desa 2">

                    </a>

                    <a class="group3" href="<?= site_url() ?>assets/files/galeri/sedang_2017 02 - Contoh Foto SID 3.10 b.jpg">

                        <img src="<?= site_url() ?>assets/files/galeri/kecil_2017 02 - Contoh Foto SID 3.10 b.jpg" width="130" alt="Desa 1">

                    </a>
                </ul>
            </div>
        </div>
        <!-- widget Komentar-->
        <!-- widget SocMed -->
        <div class="box box-default">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-globe"></i> Media Sosial</h3>
            </div>
            <div class="box-body">
                <a href="https://www.facebook.com/combine.ri" target="_blank"><img src="<?= site_url() ?>assets/front/fb.png" alt="Facebook" style="width:50px;height:50px;" /></a><a href="https://twitter.com/combineri" target="_blank"><img src="<?= site_url() ?>assets/front/twt.png" alt="Twitter" style="width:50px;height:50px;" /></a><a href="https://plus.google.com/u/0/104218605911096018855" target="_blank"><img src="<?= site_url() ?>assets/front/goo.png" alt="Google Pluss" style="width:50px;height:50px;" /></a><a href="http://www.youtube.com/channel/UCk3eN9fI_eLGYzAn_lOlgXQ" target="_blank"><img src="<?= site_url() ?>assets/front/yb.png" alt="Youtube" style="width:50px;height:50px;" /></a><a href="http://instagram.com/combine_ri" target="_blank"><img src="<?= site_url() ?>assets/front/ins.png" alt="Instagram" style="width:50px;height:50px;" /></a>
            </div>
        </div>
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-bar-chart-o"></i> Statistik Kunjungan</h3>
            </div>
            <div class="box-body">
                <div id="container" align="center">
                    <table cellpadding="0" cellspacing="0" class="counter">
                        <tr>
                            <td> Hari ini</td>
                            <td><img src="<?= site_url() ?>assets/images/counter/0.gif" align="absmiddle" /><img src="<?= site_url() ?>assets/images/counter/0.gif" align="absmiddle" /><img src="<?= site_url() ?>assets/images/counter/0.gif" align="absmiddle" /><img src="<?= site_url() ?>assets/images/counter/1.gif" align="absmiddle" /><img src="<?= site_url() ?>assets/images/counter/animasi/9.gif" align="absmiddle" /></td>
                        </tr>
                        <tr>
                            <td valign="middle" height="20">Kemarin </td>
                            <td valign="middle"><img src="<?= site_url() ?>assets/images/counter/0.gif" align="absmiddle" /><img src="<?= site_url() ?>assets/images/counter/0.gif" align="absmiddle" /><img src="<?= site_url() ?>assets/images/counter/0.gif" align="absmiddle" /><img src="<?= site_url() ?>assets/images/counter/2.gif" align="absmiddle" /><img src="<?= site_url() ?>assets/images/counter/animasi/9.gif" align="absmiddle" /></td>
                        </tr>
                        <tr>
                            <td valign="middle" height="20">Jumlah pengunjung</td>
                            <td valign="middle"><img src="<?= site_url() ?>assets/images/counter/0.gif" align="absmiddle" /><img src="<?= site_url() ?>assets/images/counter/0.gif" align="absmiddle" /><img src="<?= site_url() ?>assets/images/counter/0.gif" align="absmiddle" /><img src="<?= site_url() ?>assets/images/counter/4.gif" align="absmiddle" /><img src="<?= site_url() ?>assets/images/counter/animasi/8.gif" align="absmiddle" /></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <!-- widget Arsip Artikel -->
        <div class="box box-primary box-solid">
            <div class="box-header">
                <h3 class="box-title"><a href="<?= site_url() ?>first/arsip"><i class="fa fa-archive"></i> Arsip Artikel</a></h3>
            </div>
            <div class="box-body">
                <ul>
                    <li><a href="<?= site_url() ?>first/artikel/40">PKK Desa Bumi Pertiwi Raih Juara 1 Tingkat Kabupaten</a></li>
                    <li><a href="<?= site_url() ?>first/artikel/39">Gotong Royong Pemugaran Masjid Desa </a></li>
                    <li><a href="<?= site_url() ?>first/artikel/38">Pelatihan Jurnalistik untuk Pegiat Karang Taruna</a></li>
                    <li><a href="<?= site_url() ?>first/artikel/37">SK Operator SID</a></li>
                    <li><a href="<?= site_url() ?>first/artikel/36">Jam Kerja Kantor Desa</a></li>
                    <li><a href="<?= site_url() ?>first/artikel/35">Selamat Datang</a></li>
                    <li><a href="<?= site_url() ?>first/artikel/34">Presiden RI Kunjungi Desa Bumi Pertiwi</a></li>
                </ul>
            </div>
        </div>
        <!--widget Manual-->
        <!-- widget Google Map -->

        <div class="box box-default box-solid">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-map-marker"></i> Lokasi Bumi Pertiwi</h3>
            </div>
            <div class="box-body">
                <div id="map_canvas" style="height:200px;"></div>
                <script type="text/javascript" src="//maps.google.com/maps/api/js?key=AIzaSyDI70EOSFvckxwK-ZGUONYJ6nUJBFf9f7g&sensor=false"></script>
                <script type="text/javascript">
                    var map;
                    var marker;
                    var location;

                    function initialize() {
                        var myLatlng = new google.maps.LatLng(-7.817710559245467, 110.24645910630034);
                        var myOptions = {
                            zoom: 11,
                            center: myLatlng,
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                            overviewMapControl: true
                        }
                        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

                        var marker = new google.maps.Marker({
                            position: new google.maps.LatLng(-7.817710559245467, 110.24645910630034),
                            map: map,
                            draggable: false
                        });
                    }

                    function addEvent(obj, evType, fn) {
                        if (obj.addEventListener) {
                            obj.addEventListener(evType, fn, false);
                            return true;
                        } else if (obj.attachEvent) {
                            var r = obj.attachEvent("on" + evType, fn);
                            return r;
                        } else {
                            return false;
                        }
                    }
                    addEvent(window, 'load', initialize);
                </script>

                <a href="//www.google.co.id/maps/@-7.817710559245467,110.24645910630034z?hl=id" target="_blank">tampilkan dalam peta lebih besar</a><br />
            </div>
        </div>


    </div>
</div>
