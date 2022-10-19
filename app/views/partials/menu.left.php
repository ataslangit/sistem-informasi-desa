<div class='cssmenu'>
	<ul class="global-nav main">
		<li><a href="<?php echo site_url()."first"?>">Beranda</a></li>
	<?php foreach($menu_kiri AS $data){?>
		<?php echo $data['menu']?>
	<?php }?>
	</ul>
</div>