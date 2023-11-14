<?= $this->extend('siteman/template') ?>

<?= $this->section('content') ?>

<main id="main-container">
    <!-- Page Content -->
    <div class="bg-image" style="background-image: url('<?= asset('resources/images/bg.jpg') ?>');">
        <div class="row mx-0 bg-black-50">
            <div class="hero-static col-md-6 col-xl-8 d-none d-md-flex align-items-md-end">
                <div class="p-4">
                    <p class="fs-3 fw-semibold text-white">
                        Menuju Desa Digital
                    </p>
                    <p class="text-white-75 fw-medium">
                        Copyright &copy; <span data-toggle="year-copy">2009 - 2016</span> Combine Resource Institution<br>
                        Copyright &copy; <span data-toggle="year-copy">2022 - <?= date('Y') ?></span> Atas Langit
                    </p>
                </div>
            </div>
            <div class="hero-static col-md-6 col-xl-4 d-flex align-items-center bg-body-extra-light">
                <div class="content content-full">
                    <!-- Header -->
                    <div class="px-4 py-2 mb-4">
                        <div class="logo">
                            <?= SID_LOGO ?>
                        </div>
                        <h1 class="h3 fw-bold mt-4 mb-2">Selamat Datang</h1>
                        <h2 class="h5 fw-medium text-muted mb-0">Silakan Masuk</h2>
                    </div>
                    <!-- END Header -->

                    <!-- Sign In Form -->
                    <?= form_open(route_to('login.submit'), ['class' => 'px-4']) ?>
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" id="login-username" name="username" placeholder="Masukkan namapengguna" required>
                        <label class="form-label" for="login-username">Nama Pengguna</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="login-password" name="password" placeholder="Masukkan katasandi" required>
                        <label class="form-label" for="login-password">Kata Sandi</label>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-lg btn-alt-primary fw-semibold">
                            Masuk
                        </button>
                    </div>
                    <?= form_close() ?>
                    <!-- END Sign In Form -->
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
</main>

<?= $this->endSection() ?>
