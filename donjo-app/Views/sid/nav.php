<div id="nav">
    <ul>
        <li <?php if($act==0){?>class="selected" <?php }?>>
            <a href="<?php echo site_url('sid_core/clear')?>">Wilayah Administratif</a>
        </li>
        <li <?php if($act==1){?>class="selected" <?php }?>>
            <a href="<?php echo site_url('keluarga/clear')?>">Keluarga</a>
        </li>
        <li <?php if($act==2){?>class="selected" <?php }?>>
            <a href="<?php echo site_url('penduduk/clear')?>">Penduduk</a>
        </li>
        <li <?php if($act==3){?>class="selected" <?php }?>>
            <a href="<?php echo site_url('rtm/clear')?>">Rumah Tangga</a>
        </li>
        <li <?php if($act==4){?>class="selected" <?php }?>>
            <a href="<?php echo site_url('kelompok/clear')?>">Kelompok</a>
        </li>
    </ul>
</div>
