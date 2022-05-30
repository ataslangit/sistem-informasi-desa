<div id='cssmenu'>
    <ul id="global-nav" class="main">
        <li><a href="<?= site_url() . 'first' ?>">Beranda</a></li>
        <?php foreach ($menu_kiri as $data) { ?>
            <?= $data['menu'] ?>
        <?php } ?>
    </ul>
</div>
