<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= base_url('favicon.ico')?>">
    <title><?= esc($title ?? 'Sistem Informasi Desa') ?></title>
    <?= $this->renderSection('css') ?>
</head>
<body>
    <?= $this->renderSection('content') ?>
    <?= $this->renderSection('script') ?>
</body>
</html>
