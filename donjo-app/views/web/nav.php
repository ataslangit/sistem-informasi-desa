<div id="nav">
    <ul>
        <?php if($_SESSION['grup']!=4){?>
        <li <?php if($act==0){?>class="selected" <?php }?>>
            <a href="<?php echo site_url('web/index/1')?>">Artikel</a>
        </li>
        <li <?php if($act==1){?>class="selected" <?php }?>>
            <a href="<?php echo site_url('menu/index/1')?>">Menu Statis</a>
        </li>
        <li <?php if($act==7){?>class="selected" <?php }?>>
            <a href="<?php echo site_url('kategori/index/1')?>">Menu Dinamis / Kategori</a>
        </li>
        <li <?php if($act==2){?>class="selected" <?php }?>>
            <a href="<?php echo site_url('komentar')?>">Komentar</a>
        </li>
        <li <?php if($act==3){?>class="selected" <?php }?>>
            <a href="<?php echo site_url('gallery')?>">Gallery</a>
        </li>
        <li <?php if($act==4){?>class="selected" <?php }?>>
            <a href="<?php echo site_url('dokumen')?>">Dokumen</a>
        </li>
        <li <?php if($act==6){?>class="selected" <?php }?>>
            <a href="<?php echo site_url('sosmed')?>">Media Sosial</a>
        </li>
        <?php }else{?>
        <li <?php if($act==0){?>class="selected" <?php }?>>
            <a href="<?php echo site_url('web/index/1')?>">Artikel</a>
        </li>
        <li <?php if($act==3){?>class="selected" <?php }?>>
            <a href="<?php echo site_url('gallery')?>">Gallery</a>
        </li>
        <li <?php if($act==4){?>class="selected" <?php }?>>
            <a href="<?php echo site_url('dokumen')?>">Dokumen</a>
        </li>
        <?php }?>
    </ul>
</div>
