<div class="module-panel">
    <div class="contentm" style="overflow: hidden;">
        <?php foreach ($moduls as $modul) { ?>
            <a class="cpanel" href="<?= site_url($modul['url']) ?>">
                <img src="<?= base_url('assets/images/cpanel/' . $modul['ikon']) ?>" alt="">
                <span><?= esc($modul['modul']) ?></span>
            </a>
        <?php } ?>
    </div>
</div>
