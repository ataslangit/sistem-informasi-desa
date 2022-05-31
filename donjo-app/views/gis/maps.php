<script>
    (function() {
        var infoWindow;
        window.onload = function() {
            var options = {
                <?php if ($desa['lat'] !== '') { ?>
                    center: new google.maps.LatLng(<?= $desa['lat'] ?>, <?= $desa['lng'] ?>),
                    zoom: <?= $desa['zoom'] ?>,
                    mapTypeId: google.maps.MapTypeId.<?= strtoupper($desa['map_tipe']) ?>
                <?php } else { ?>
                    center: new google.maps.LatLng(-7.885619783139936, 110.39893195996092),
                    zoom: 14,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                <?php } ?>
            };
            var map = new google.maps.Map(document.getElementById('map'), options);
            <?php if ($layer_desa === 1) { ?>
                <?php $path = preg_split('/\\;/', $desa['path']);
                echo 'var path = [';

                foreach ($path as $p) {
                    if ($p !== '') {
                        echo 'new google.maps.LatLng' . $p . ',';
                    }
                }
                echo '];'; ?>

                var desa = new google.maps.Polygon({
                    paths: path,
                    map: map,
                    strokeColor: '#555555',
                    strokeOpacity: 0.5,
                    strokeWeight: 2,
                    fillColor: '#8888dd',
                    fillOpacity: 0.05
                });
            <?php } ?>
            <?php if ($layer_wilayah === 1) { ?>
                <?php foreach ($wilayah as $wil) { ?>
                    <?php $path = preg_split('/\\;/', $wil['path']);
                    echo "var path_{$wil['id']} = [";

                    foreach ($path as $p) {
                        if ($p !== '') {
                            echo 'new google.maps.LatLng' . $p . ',';
                        }
                    }
                    echo '];'; ?>

                    var wil = new google.maps.Polygon({
                        paths: path_<?= $wil['id'] ?>,
                        map: map,
                        strokeColor: '#00ff00',
                        strokeOpacity: 0.5,
                        strokeWeight: 2,
                        <?php if ($wil['rw'] === 0 && $wil['rw'] === 0) { ?>
                            fillColor: '#00ff00',
                        <?php } elseif ($wil['rw'] !== 0 && $wil['rt'] === 0) { ?>
                            fillColor: '#ffff00',
                        <?php } else { ?>
                            fillColor: '#00ffff',
                        <?php } ?>
                        fillOpacity: 0.22
                    });
            <?php }
            } ?>
            <?php if ($layer_area === 1) { ?>
                <?php foreach ($area as $area) { ?>
                    <?php $path = preg_split('/\\;/', $area['path']);
                    echo "var polygon_{$area['id']} = [";

                    foreach ($path as $p) {
                        if ($p !== '') {
                            echo 'new google.maps.LatLng' . $p . ',';
                        }
                    }
                    echo '];'; ?>

                    var area_<?= $area['id'] ?> = new google.maps.Polygon({
                        paths: polygon_<?= $area['id'] ?>,
                        map: map,
                        strokeColor: '#555555',
                        strokeOpacity: 0.5,
                        strokeWeight: 1,
                        fillColor: '#<?= $area['color'] ?>',
                        fillOpacity: 0.22,
                        title: "<?= $area['nama'] ?>"
                    });
                    google.maps.event.addListener(area_<?= $area['id'] ?>, 'click', showArrays_area_<?= $area['id'] ?>);
                    if (!infoWindow) {
                        infoWindow = new google.maps.InfoWindow();
                    }

                    function showArrays_area_<?= $area['id'] ?>(event) {
                        var vertices = this.getPath();
                        var contentString = '<div id="content">' +
                            '<div id="siteNotice">' +
                            '</div>' +
                            '<h1 id="firstHeading" class="firstHeading"><?= $area['nama'] ?></h1>' +
                            '<div id="bodyContent">' +
                            '<img src="<?= base_url() ?>assets/files/gis/area/sedang_<?= $area['foto'] ?>" style=" width:200px;height:140px;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;border:2px solid #555555;"/>' +
                            '<p><?= $area['desk'] ?></p>' +
                            '</div>' +
                            '</div>';




                        infoWindow.setContent(contentString);
                        infoWindow.setPosition(event.latLng);
                        infoWindow.open(map);
                    }
                <?php } ?>
            <?php } ?>
            <?php if ($layer_line === 1) { ?>
                <?php foreach ($garis as $garis) { ?>
                    <?php $path = preg_split('/\\;/', $garis['path']);
                    echo "var line_{$garis['id']} = [";

                    foreach ($path as $p) {
                        if ($p !== '') {
                            echo 'new google.maps.LatLng' . $p . ',';
                        }
                    }
                    echo '];'; ?>

                    var garis_<?= $garis['id'] ?> = new google.maps.Polyline({
                        path: line_<?= $garis['id'] ?>,
                        map: map,
                        strokeColor: '#00bb00',
                        strokeOpacity: 0.5,
                        strokeWeight: 5
                    });
                    google.maps.event.addListener(garis_<?= $garis['id'] ?>, 'click', showArrays_line_<?= $garis['id'] ?>);
                    if (!infoWindow) {
                        infoWindow = new google.maps.InfoWindow();
                    }

                    function showArrays_line_<?= $garis['id'] ?>(event) {
                        var vertices = this.getPath();
                        var contentString = '<div id="content">' +
                            '<div id="siteNotice">' +
                            '</div>' +
                            '<h1 id="firstHeading" class="firstHeading"><?= $garis['nama'] ?></h1>' +
                            '<div id="bodyContent">' +
                            '<img src="<?= base_url() ?>assets/files/gis/garis/sedang_<?= $garis['foto'] ?>" style=" width:200px;height:140px;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;border:2px solid #555555;"/>' +
                            '<p><?= $garis['desk'] ?></p>' +
                            '</div>' +
                            '</div>';





                        infoWindow.setContent(contentString);
                        infoWindow.setPosition(event.latLng);
                        infoWindow.open(map);
                    }
                <?php } ?>
            <?php } ?>
            <?php if ($layer_point === 1) { ?>
                var shadow = new google.maps.MarkerImage(
                    '<?= base_url() ?>assets/images/gis/point/shadow.png',
                    null,
                    null,
                    new google.maps.Point(16, 35)
                );
                <?php foreach ($lokasi as $data) {
                    if ($data['lat'] !== '') { ?>

                        <?php $simbol = base_url() . 'assets/images/gis/point/' . $data['simbol']; ?>
                        var cusicon_<?= $data['id'] ?> = new google.maps.MarkerImage("<?= $simbol ?>");

                        var prop_<?= $data['id'] ?> = new google.maps.Marker({
                            position: new google.maps.LatLng(<?= $data['lat'] ?>, <?= $data['lng'] ?>),
                            map: map,
                            icon: cusicon_<?= $data['id'] ?>,
                            shadow: shadow,
                            title: "<?= $data['nama'] ?>"
                        });

                        google.maps.event.addListener(prop_<?= $data['id'] ?>, 'click', function() {
                            if (!infoWindow) {
                                infoWindow = new google.maps.InfoWindow();
                            }

                            var content = '<table border=0 style="width:400px"><tr>' +
                                <?php if ($data['foto'] !== '') { ?> '<td><img src="<?= base_url() ?>assets/files/gis/lokasi/sedang_<?= $data['foto'] ?>" class="foto"/></td>' +
                                <?php } ?> '<td style="padding-left:3px"><font size="2.5" style="font-weight:bold;"><?= $data['nama'] ?></font>' +
                                '<p><?= $data['desk'] ?></p>' +
                                '</tr><tr><td></td></tr></table>';
                            infoWindow.setContent(content);
                            infoWindow.open(map, prop_<?= $data['id'] ?>);
                        });
            <?php }
                }
            } ?>
            <?php if ($layer_penduduk === 1 || $layer_keluarga === 1) { ?>
                <?php $pendc = base_url() . 'assets/images/gis/point/pend.png'; ?>
                var pend_icon = new google.maps.MarkerImage("<?= $pendc ?>");
                <?php foreach ($penduduk as $data) {
                    if ($data['lat'] !== '') { ?>
                        var marker_<?= $data['id'] ?> = new google.maps.Marker({
                            position: new google.maps.LatLng(<?= $data['lat'] ?>, <?= $data['lng'] ?>),
                            map: map,
                            title: "<?= $data['nama'] ?>"
                        });

                        google.maps.event.addListener(marker_<?= $data['id'] ?>, 'click', function() {
                            if (!infoWindow) {
                                infoWindow = new google.maps.InfoWindow();
                            }
                            <?php if ($data['foto'] !== '') { ?>
                                var poto = '<td><img src="<?= base_url() ?>assets/files/user_pict/kecil_<?= $data['foto'] ?>" class="foto_pend"/></td>';
                            <?php } else { ?>
                                var poto = '<td><img src="<?= base_url() ?>assets/files/user_pict/kuser.png" class="foto_pend"/></td>';
                            <?php } ?>

                            var content = '<table border=0><tr>' + poto +
                                '<td style="padding-left:2px"><font size="2.5" style="bold"><?= $data['nama'] ?></font> - <?= ucwords(strtolower($data['sex'])) ?>' +
                                '<p><?= $data['umur'] ?> Tahun (<?= $data['agama'] ?>)</p>' +
                                '<p><?= $data['alamat'] ?></p>' +
                                '<p><a href="<?= site_url("penduduk/detail/1/0/{$data['id']}") ?>" target="ajax-modalx" rel="content" header="Detail Data <?= $data['nama'] ?>" >Data Detail</a></p></td>' +
                                '</tr></table>';
                            infoWindow.setContent(content);
                            infoWindow.open(map, marker_<?= $data['id'] ?>);
                        });
            <?php }
                }
            } ?>
        };
    })();
</script>
<style>
    #map {
        width: 100%;
        height: 94%;
    }

    .foto {
        width: 200px;
        height: 140px;
        border-radius: 3px;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
        border: 2px solid #555555;
    }

    .foto_pend {
        width: 70px;
        height: 70px;
        border-radius: 3px;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
    }
</style>
<?= form_open('', ['id' => 'mainform', 'name' => 'mainform']) ?>
    <div class="ui-layout-west" id="sidebar" style="width:200px;">
        <div class="module">
            <table border="0">
                <h3>Legenda</h3>
                <tr>
                    <td>
                        <input type="checkbox" name="layer_penduduk" value="1" onchange="handle_pend(this);" <?php if ($layer_penduduk === 1) {
                                                                                                                    echo 'checked';
                                                                                                                } ?>> Penduduk
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="layer_keluarga" value="1" onchange="handle_kel(this);" <?php if ($layer_keluarga === 1) {
                                                                                                                echo 'checked';
                                                                                                            } ?>> Keluarga
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="layer_desa" value="1" onchange="handle_desa(this);" <?php if ($layer_desa === 1) {
                                                                                                                echo 'checked';
                                                                                                            } ?>> Desa
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="layer_wilayah" value="1" onchange="handle_wil(this);" <?php if ($layer_wilayah === 1) {
                                                                                                                echo 'checked';
                                                                                                            } ?>> Wilayah Administratif
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="layer_area" value="1" onchange="handle_area(this);" <?php if ($layer_area === 1) {
                                                                                                                echo 'checked';
                                                                                                            } ?>> Area
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="layer_line" value="1" onchange="handle_line(this);" <?php if ($layer_line === 1) {
                                                                                                                echo 'checked';
                                                                                                            } ?>> Line
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="layer_point" value="1" onchange="handle_point(this);" <?php if ($layer_point === 1) {
                                                                                                                echo 'checked';
                                                                                                            } ?>> Point
                    </td>
                </tr>
            </table>


            <script>
                function handle_pend(cb) {
                    formAction('mainform', '<?= site_url('gis') ?>/layer_penduduk');
                }

                function handle_kel(cb) {
                    formAction('mainform', '<?= site_url('gis') ?>/layer_keluarga');
                }

                function handle_desa(cb) {
                    formAction('mainform', '<?= site_url('gis') ?>/layer_desa');
                }

                function handle_wil(cb) {
                    formAction('mainform', '<?= site_url('gis') ?>/layer_wilayah');
                }

                function handle_area(cb) {
                    formAction('mainform', '<?= site_url('gis') ?>/layer_area');
                }

                function handle_line(cb) {
                    formAction('mainform', '<?= site_url('gis') ?>/layer_line');
                }

                function handle_point(cb) {
                    formAction('mainform', '<?= site_url('gis') ?>/layer_point');
                }
            </script>

        </div>
    </div>
    <div class="ui-layout-center" id="wrapper">
        <div class="table-panel top">
            <div class="left">

                <select name="filter" onchange="formAction('mainform','<?= site_url('gis/filter') ?>')" title="Cari Data">
                    <option value="">Status</option>
                    <option value="1" <?php if ($filter === 1) : ?>selected<?php endif ?>>Tetap</option>
                    <option value="2" <?php if ($filter === 2) : ?>selected<?php endif ?>>Pasif</option>
                    <option value="3" <?php if ($filter === 3) : ?>selected<?php endif ?>>Pendatang</option>
                </select>
                <select name="sex" onchange="formAction('mainform','<?= site_url('gis/sex') ?>')">
                    <option value="">J. Kelamin</option>
                    <option value="1" <?php if ($sex === 1) : ?>selected<?php endif ?>>Laki-laki</option>
                    <option value="2" <?php if ($sex === 2) : ?>selected<?php endif ?>>Perempuan</option>
                </select>
                <select name="dusun" onchange="formAction('mainform','<?= site_url('gis/dusun') ?>')">
                    <option value="">Dusun</option>
                    <?php foreach ($list_dusun as $data) { ?>
                        <option <?php if ($dusun === $data['dusun']) : ?>selected<?php endif ?> value="<?= $data['dusun'] ?>"><?= $data['dusun'] ?></option>
                    <?php } ?>
                </select>
                <?php if ($dusun) { ?>
                    <select name="rw" onchange="formAction('mainform','<?= site_url('gis/rw') ?>')">
                        <option value="">RW</option>
                        <?php foreach ($list_rw as $data) { ?>
                            <option <?php if ($rw === $data['rw']) : ?>selected<?php endif ?>><?= $data['rw'] ?></option>
                        <?php } ?>
                    </select>
                    <?php if ($rw) { ?>
                        <select name="rt" onchange="formAction('mainform','<?= site_url('gis/rt') ?>')">
                            <option value="">RT</option>
                            <?php foreach ($list_rt as $data) { ?>
                                <option <?php if ($rt === $data['rt']) : ?>selected<?php endif ?>><?= $data['rt'] ?></option>
                            <?php } ?>
                        </select>
                <?php }
                } ?>
                <select name="agama" onchange="formAction('mainform','<?= site_url('gis/agama') ?>')">
                    <option value="">Agama</option>
                    <?php foreach ($list_agama as $data) { ?>
                        <option value="<?= $data['id'] ?>" <?php if ($agama === $data['id']) { ?>selected<?php } ?>><?= $data['nama'] ?></option>
                    <?php } ?>
                </select>
                <input name="cari" id="cari" type="text" class="inputbox2 help tipped" size="20" value="<?= $cari ?>" title="Search.." />
                <button type="button" onclick="$('#'+'mainform').attr('action','<?= site_url('gis/search') ?>');$('#'+'mainform').submit();" class="uibutton tipsy south" title="Cari Data"><span class="ui-icon ui-icon-search">&nbsp;</span>Search</button>
                <button href="<?= site_url('gis/ajax_adv_search') ?>" target="ajax-modalx" rel="window" header="Pencarian Spesifik" class="uibutton tipsy south" title="Pencarian Spesifik"><span class="ui-icon ui-icon-search">&nbsp;</span>Pencarian Spesifik</button>
                <a href="<?= site_url('gis/clear') ?>" class="uibutton tipsy south" title="Clear Pencarian" style=""><span class="ui-icon ui-icon-search">&nbsp;</span>Clear</a>
<?= form_close() ?>
</div>
</div>
<div id="map"></div>
