<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Instal Sistem Informasi Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: flex;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
    }

    .blanko {
        max-width: 330px;
        padding: 15px;
    }

    .blanko .form-floating:focus-within {
        z-index: 2;
    }

    .blanko input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .blanko input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    </style>
</head>

<body class="bg-light mx-auto">
    <div class="card blanko w-100 m-auto">
        <div class="card-body">
            <?php if ($step === '0') : ?>
            <p>
                Selamat datang dihalaman instalasi Sistem Informasi Desa. Sebelum memulai, Anda harus mengetahui hal-hal
                berikut.
            </p>

            <ol>
                <li>Nama basis data</li>
                <li>Nama pengguna basis data</li>
                <li>Sandi basis data</li>
                <li>Host basis data</li>
                <li>Prefiks Tabel (opsional)</li>
            </ol>
            <p>
                Informasi berikut dibutuhkan untuk membuat berkas <b>.env</b>. Tidak perlu khawatir jika proses
                pembuatan file otomatis gagal disebabkan oleh hal tertentu. Proses ini hanya untuk mengisikan informasi
                basis data ke dalam file konfigurasi. Anda juga bisa membuka file <b>env</b> dengan sebuah
                editor teks, lengkapi informasi, kemudian simpan sebagai <b>.env</b>.
            </p>

            <a class="btn btn-sm btn-outline-primary" href="<?= site_url('install?step=1') ?>">Lanjut</a>

            <?php elseif ($step === '1'): // install database?>
            <p>Anda harus mengisi informasi berikut untuk terhubung ke basis data Anda.</p>

            <?= form_open() ?>

            <div class="mb-3">
                <label for="database" class="form-label">Nama Basis data</label>
                <input name="database" class="form-control" id="database" type="text" placeholder="database" require>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Nama Pengguna</label>
                <input name="username" class="form-control" id="username" type="text" placeholder="username" require>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Sandi</label>
                <input name="password" class="form-control" id="password" type="text" placeholder="password" require>
            </div>
            <div class="mb-3">
                <label for="host" class="form-label">Host Basis data</label>
                <input name="host" class="form-control" id="host" type="text" placeholder="host" require>
            </div>
            <div class="mb-3">
                <label for="prefix" class="form-label">Prefix</label>
                <input name="prefix" class="form-control" id="prefix" type="text" placeholder="prefix">
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-primary">Simpan</button>
            </div>

            <?= form_close() ?>

            <?php elseif ($step === '2'): // setting username & password login?>

            <?php endif ?>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>
