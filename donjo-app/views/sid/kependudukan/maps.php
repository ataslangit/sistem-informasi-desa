<script src="<?php echo base_url()?>assets/js/jquery-1.5.2.min.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script>
    (function() {
        var mapOptions = {
            <?php if($penduduk['lat'] != ""){?>
            center: new google.maps.LatLng(<?php echo $penduduk['lat']?>, <?php echo $penduduk['lng']?>),
            zoom: <?php echo $desa['zoom']?>,
            mapTypeId: google.maps.MapTypeId.<?php echo strtoupper($desa['map_tipe'])?>
            <?php }else{
			 if($desa['lat']!=""){?>
            center: new google.maps.LatLng(<?php echo $desa['lat']?>, <?php echo $desa['lng']?>),
            zoom: <?php echo $desa['zoom']?>,
            mapTypeId: google.maps.MapTypeId.<?php echo strtoupper($desa['map_tipe'])?>
            <?php }else{?>
            center: new google.maps.LatLng(-7.885619783139936, 110.39893195996092),
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP
            <?php }
		}?>

        };
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);

        // map = new google.maps.Map(document.getElementById('map'), options);
        var marker = new google.maps.Marker({
            <?php if($penduduk['lat'] != ""){?>
            position: new google.maps.LatLng(<?php echo $penduduk['lat']?>, <?php echo $penduduk['lng']?>),
            <?php }else if($desa['lat'] != ""){?>
            position: new google.maps.LatLng(<?php echo $desa['lat']?>, <?php echo $desa['lng']?>),

            <?php }else{?>
            position: new google.maps.LatLng(-7.885619783139936, 110.39893195996092),
            <?php }?>
            map: map,
            draggable: true,
            title: "<?php echo $penduduk['nama']?>"
        });
        google.maps.event.addListener(marker, 'drag', function() {
            document.getElementById('lat').value = marker.getPosition().lat();
            document.getElementById('lng').value = marker.getPosition().lng();
            document.getElementById('zoom').value = map.getZoom();
            document.getElementById('map_tipe').value = map.getMapTypeId();
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
<form action="<?php echo $form_action?>" method="post" id="validasi">
    <div id="map"></div>
    <input type="hidden" name="lat" id="lat">
    <input type="hidden" name="lng" id="lng">
    <input type="hidden" name="zoom" id="zoom">
    <input type="hidden" name="map_tipe" id="map_tipe">
    <div class="buttonpane" style="text-align: right; width:420px;position:absolute;bottom:0px;">
        <div class="uibutton-group">
            <button class="uibutton confirm" type="submit">Simpan</button>
        </div>
    </div>
</form>
