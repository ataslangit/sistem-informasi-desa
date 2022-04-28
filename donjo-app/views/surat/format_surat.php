<div id="pageC">
	<div id="contentpane">
		<div class="ui-layout-north panel">
			<h3>Layanan Surat Administrasi Kependudukan</h3>
		</div>
		<div class="ui-layout-center" id="maincontent" style="padding: 5px;">
			<div>
			<?php foreach ($menu_surat2 as $data) {?>
			<a class="csurat" href="<?= site_url()?>/surat/form/<?= $data['url_surat']?>">
				<img src="<?= base_url()?>assets/images/cpanel/applications-office-5.png" alt="sss"/>
				<span><?= $data['nama']?></span>
			</a>
			<?php }?>
			</div>
		</div>
	</div>
</div>
