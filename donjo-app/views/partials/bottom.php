
<?php $i = 1;

foreach ($slide as $data) {
    if ($i < 5) {?>
<div class="contentbotm nobig">
	<div class="contentbotm_feature">
	<?php if ($data['gambar'] !== '') {?>
		<?php if (is_file('assets/front/slide/kecil_' . $data['gambar'])) {?>
			<img style="margin-right: 10px; margin-bottom: 5px; float: left;" src="<?= base_url()?>assets/front/data/kecil_<?= $single_artikel['gambar']?>" />
			<?php } else {?>
			<img style="margin-right: 10px; margin-bottom: 5px; float: left;" src="<?= base_url()?>assets/images/404-image-not-found.jpg" />
		<?php }?>
	<?php }?>

	</div>
</div>
<?php }
    $i++;
}?>
