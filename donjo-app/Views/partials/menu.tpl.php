<link href="<?= asset('resources/css/default.css')?>" rel="stylesheet">
<div class='cssmenu'>
    <ul class="global-nav top">
        <?php foreach($menu_atas AS $data){?>
        <?php echo $data['menu']?>
        <?php }?>
    </ul>
</div>
