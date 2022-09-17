<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

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

        .form-signin {
            max-width: 330px;
            padding: 15px;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin input[name="username"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[name="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
</head>

<body class="text-center">

    <main class="form-signin w-100 m-auto">
        <?= form_open('siteman') ?>
        <img class="mb-4" src="/docs/5.2/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
        <h1 class="h3 mb-3 fw-normal">Silakan masuk</h1>

        <div class="form-floating">
            <?= form_input([
                'class'       => 'form-control',
                'id'          => 'username',
                'name'        => 'username',
                'placeholder' => 'nama pengguna',
                'required'    => true,
            ]) ?>
            <?= form_label('Nama Pengguna', 'username') ?>
        </div>
        <div class="form-floating">
            <?= form_password([
                'class'       => 'form-control',
                'id'          => 'password',
                'name'        => 'password',
                'placeholder' => 'kata sandi',
                'required'    => true,
            ]) ?>
            <?= form_label('Kata Sandi', 'password') ?>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-muted">Atas Langit &copy; 2022</p>
        <?= form_close() ?>
    </main>
</body>

</html>
