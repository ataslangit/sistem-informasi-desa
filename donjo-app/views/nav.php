<div id="nav">
	<ul>
	<li <?php if ($act === 1) {?>class="selected"<?php }?>>
		<a href="<?= site_url('database')?>">Export</a>
	</li>
	<li <?php if ($act === 2) {?>class="selected"<?php }?>>
		<a href="<?= site_url('database/import')?>">Import Excel</a>
	</li>
	<li <?php if ($act === 3) {?>class="selected"<?php }?>>
		<a href="<?= site_url('database/backup')?>">Backup/Restore</a>
	</li>
	<li <?php if ($act === 4) {?>class="selected"<?php }?>>
		<a href="<?= site_url('database/import_ppls')?>">Import PPLS</a>
	</li>
	</ul>
</div>
