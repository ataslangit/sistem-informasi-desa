<div class="module-panel">
    <div class="contentm" style="overflow: hidden;">
        <?php if ($_SESSION['grup'] === 1 || $_SESSION['grup'] === 2) { ?>
            <a class="cpanel" href="<?= site_url('admin/about') ?>">
                <img src="<?= base_url() ?>assets/images/cpanel/go-home-5.png" alt="" />
                <span>SID Home</span>
            </a>
            <a class="cpanel" href="<?= site_url() ?>sid_core/clear">
                <img src="<?= base_url() ?>assets/images/cpanel/preferences-contact-list.png" alt="" />
                <span>Penduduk</span>
            </a>
            <a class="cpanel" href="<?= site_url() ?>statistik/clear">
                <img src="<?= base_url() ?>assets/images/cpanel/statistik.png" alt="" />
                <span>Statistik</span>
            </a>
            <a class="cpanel" href="<?= site_url() ?>surat">
                <img src="<?= base_url() ?>assets/images/cpanel/applications-office-5.png" alt="" />
                <span>Cetak Surat</span>
                <a class="cpanel" href="<?= site_url() ?>analisis">
                    <img src="<?= base_url() ?>assets/images/cpanel/analysis.png" alt="" />
                    <span>Analisis</span>
                </a>
                <a class="cpanelx" href="<?= site_url() ?>plan">
                    <img src="<?= base_url() ?>assets/images/cpanel/planmap.png" alt="" />
                    <span>Plan Maps</span>
                </a>
                <a class="cpanel" href="<?= site_url() ?>gis/clear">
                    <img src="<?= base_url() ?>assets/images/cpanel/gis.png" alt="" />
                    <span>SID GIS</span>
                </a>
            </a>
            <?php if ($_SESSION['grup'] === 1) { ?>
                <a class="cpanel" href="<?= site_url() ?>man_user/clear">
                    <img src="<?= base_url() ?>assets/images/cpanel/system-users.png" alt="" />
                    <span>Pengguna</span>
                </a>
            <?php } ?>
        <?php } ?>
        <a class="cpanel" href="<?= site_url() ?>sms">
            <img src="<?= base_url() ?>assets/images/cpanel/mail-send-receive.png" alt="" />
            <span>SMS</span>
        </a>
        <a class="cpanel" href="<?= site_url() ?>web">
            <img src="<?= base_url() ?>assets/images/cpanel/message-news.png" alt="" />
            <span>Admin Web</span>
        </a>
    </div>
</div>
