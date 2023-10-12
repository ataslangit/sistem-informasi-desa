<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?></title>

    <?= link_tag(asset('resources/scss/app.scss')) ?>

    <?= $this->renderSection('css') ?>
</head>

<body class="<?= esc($bodyClass ?? '') ?>">
    <?= $this->renderSection('content') ?>

    <?= $this->renderSection('js') ?>
</body>

</html>
