<div id="nav">
    <ul>
        <?php if ($_SESSION['grup'] === 1) { ?>
            <li <?php if ($act === 0) { ?>class="selected" <?php } ?>>
                <a href="<?= site_url('admin/dashboard') ?>">Identitas Desa</a>
            </li>
        <?php } ?>
        <li <?php if ($act === 1) { ?>class="selected" <?php } ?>>
            <a href="<?= site_url('pengurus') ?>">Pemerintah Desa</a>
        </li>
        <li <?php if ($act === 2) { ?>class="selected" <?php } ?>>
            <a href="<?= site_url('admin/about') ?>">SID <?= APP_VERSION ?></a>
        </li>
    </ul>
</div>
