<?php
$desa      = $data['header']['desa'];
$judul     = 'Desa ' . $desa['nama_desa'] . ', ' . $desa['nama_kecamatan'] . ', ' . $desa['nama_kabupaten'];
$foto_user = $data['header']['foto'];
$nama_user = $data['header']['nama'];

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi Desa: <?= $judul ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />

    <style>
        img.logo {
            width: 36px;
            height: auto;
        }

        .header-2nd a {
            font-size: 0.8em;
        }

        .header-2nd img {
            width: 40px;
            height: 40px;
        }
    </style>
</head>

<body>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">

        <button class="navbar-toggler d-md-none ms-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a href="<?= site_url('first') ?>" class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 d-flex align-items-center" target="_blank">
            <img class="logo me-2" src="<?= base_url('assets/files/logo/' . $desa['logo']) ?>" alt="" />
            <div class="sid_info small text-truncate">
                <div class="fw-bold">Sistem Informasi Desa</div>
                <div id="sid-info"><?= 'Desa ' . $desa['nama_desa'] ?></div>
            </div>
        </a>



        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a href="#" class="d-flex align-items-center nav-link px-3" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="true">
                    <span class="d-block me-2 small">
                        <span class="d-block">Masuk sebagai</span>
                        <span class="d-block"><?= $nama_user ?></span>
                    </span>
                    <?php if ($foto_user !== '') {
    $img = base_url('assets/files/user_pict/kecil_' . $foto_user);
} else {
    $img = base_url('assets/files/user_pict/kuser.png');
} ?>
                    <img src="<?= $img ?>" alt="<?= $nama_user ?>" width="32" height="32" class="rounded-circle border border-primary" />
                </a>
                <div class="flex-shrink-0 dropdown">
                    <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2" data-popper-placement="bottom-end" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(0px, 34.4px, 0px);">
                        <li><a class="dropdown-item" href="<?= site_url('admin/dashboard') ?>">Dasbor</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('user_setting') ?>">Pengaturan Akun</a></li>
                        <?php if ($_SESSION['grup'] === 1) { ?>
                            <li><a class="dropdown-item" href="<?= site_url('modul/clear') ?>">Pengaturan</a></li>
                        <?php } ?>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?= site_url('siteman') ?>">Keluar</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav nav-pills flex-column mb-auto">
                        <?php foreach ($data['header']['modul'] as $mod) { ?>

                            <li class="nav-item">
                                <a href="<?= site_url($mod['url']) ?>" class="nav-link" aria-current="page">
                                    <i class="<?= (isset($mod['icon']) && ! empty($mod['icon']) ? $mod['icon'] : 'fa-regular fa-note-sticky') ?> me-2"></i>
                                    <span><?= $mod['modul'] ?></span>
                                </a>
                            </li>
                        <?php } ?>

                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <?php $this->load->view($view, $data) ?>

            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/3ce9aa789a.js" crossorigin="anonymous" defer></script>
</body>

</html>
