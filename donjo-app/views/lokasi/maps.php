<script>
    (function() {
        var mapOptions = {
            <?php if (!empty($lokasi)) { ?>
                <?php if ($lokasi['lat'] !== '') { ?>
                    center: new google.maps.LatLng(<?= $lokasi['lat'] ?>, <?= $lokasi['lng'] ?>),
                    zoom: 14,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                    <?php } else {
                    if ($desa['lat'] !== '') { ?>
                        center: new google.maps.LatLng(<?= $desa['lat'] ?>, <?= $desa['lng'] ?>),
                        zoom: <?= $desa['zoom'] ?>,
                        mapTypeId: google.maps.MapTypeId.<?= strtoupper($desa['map_tipe']) ?>
                    <?php } else { ?>
                        center: new google.maps.LatLng(-7.885619783139936, 110.39893195996092),
                        zoom: 14,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                <?php }
                }
            } else { ?>
                center: new google.maps.LatLng(-7.885619783139936, 110.39893195996092),
                zoom: 14,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            <?php } ?>
        };
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);

        // map = new google.maps.Map(document.getElementById('map'), options);
        var marker = new google.maps.Marker({
            <?php if ($lokasi['lat'] !== '') { ?>
                position: new google.maps.LatLng(<?= $lokasi['lat'] ?>, <?= $lokasi['lng'] ?>),
            <?php } elseif ($desa['lat'] !== '') { ?>
                position: new google.maps.LatLng(<?= $desa['lat'] ?>, <?= $desa['lng'] ?>),

            <?php } else { ?>
                position: new google.maps.LatLng(-7.885619783139936, 110.39893195996092),

            <?php } ?>
            map: map,
            draggable: true,
            title: "<?= $lokasi['nama'] ?>"
        });
        google.maps.event.addListener(marker, 'drag', function() {
            document.getElementById('lat').value = marker.getPosition().lat();
            document.getElementById('lng').value = marker.getPosition().lng();
            //document.getElementById('zoom').value = map.getZoom();
            //document.getElementById('map_tipe').value = map.getMapTypeId();
        });

    })();
</script>
<style>
    #map {
        width: 420px;
        height: 320px;
        border: 1px solid #000;
    }
</style>
<form action="<?= $form_action ?>" method="post" id="validasi">
    <div id="map"></div>
    <input type="hidden" name="lat" id="lat" />
    <input type="hidden" name="lng" id="lng" />
    <?php ?>
    <div class="buttonpane" style="text-align: right; width:400px;position:absolute;bottom:0px;">
        <div class="uibutton-group">
            <button class="uibutton" type="button" onclick="$('#window').dialog('close');">Close</button>
            <button class="uibutton confirm" type="submit">Simpan</button>
        </div>
    </div>
</form>
