<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Sistem Informasi Desa') ?></title>
    <?= $this->renderSection('css') ?>
</head>
<body>
    <?= $this->renderSection('content') ?>

    <?= $this->renderSection('js') ?>
</body>
</html>
