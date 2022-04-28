<link type='text/css' href="<?= base_url()?>assets/front/css/default.css" rel='Stylesheet' />
<div id='cssmenu'>
	<ul id="global-nav" class="top">
	<?php foreach ($menu_atas as $data) {?>
		<?= $data['menu']?>
	<?php }?>
	</ul>
</div>