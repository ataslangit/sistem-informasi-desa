<?= $this->extend('main') ?>

<?= $this->section('css') ?>

<style>
    html,
    body,
    body .text-center {
        height: 100%;
    }

    body .text-center {
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

    .form-signin input[type="text"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <div class="text-center">
        <main class="form-signin w-100 m-auto">
            <?= form_open('siteman/check') ?>
            <h1 class="h3 mb-3 fw-normal">Sistem Informasi Desa</h1>

            <div class="form-floating">
                <?= form_input([
                    'class'       => 'form-control',
                    'id'          => 'username',
                    'name'        => 'username',
                    'placeholder' => 'nama pengguna',
                    'required'    => '',
                    'value'       => set_value('username'),
                ]) ?>

                <?= form_label('Nama Pengguna', 'username') ?>
            </div>

            <div class="form-floating">
                <?= form_password([
                    'class'       => 'form-control',
                    'id'          => 'password',
                    'name'        => 'password',
                    'placeholder' => 'kata sandi',
                    'required'    => '',
                ]) ?>

                <?= form_label('Kata Sandi', 'password') ?>
            </div>

            <?= form_button([
                'class'   => 'w-100 btn btn-lg btn-primary',
                'content' => 'Masuk',
                'type'    => 'submit',
            ]) ?>

            <p class="mt-5 mb-3 text-muted">&copy; 2022</p>

            <?= form_close() ?>

        </main>
    </div>

<?= $this->endSection() ?>
