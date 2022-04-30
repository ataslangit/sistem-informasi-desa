<!DOCTYPE>
<html>

<head>
    <title>Website Kalurahan Sukoharjo</title>
    <meta content="utf-8" http-equiv="encoding">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta property="og:image" content="https://sukoharjosid.slemankab.go.id/assets/files/artikel/sedang_logo160.png">
    <meta property="og:image:width" content="400">
    <meta property="og:image:height" content="240">
    <meta property="og:url" content="https://sukoharjosid.slemankab.go.id/first">
    <meta property="og:title" content="Sukoharjo">
    <meta property="og:site_name" content="Sukoharjo" />
    <meta property="og:description" content="Sukoharjo">
    <link rel="shortcut icon" href="https://sukoharjosid.slemankab.go.id/assets/files/logo/logo160.png" />


    <link type='text/css' href="<?= assets('assets/first.css') ?>" rel='Stylesheet' />
    <link type='text/css' href="<?= assets('assets/default.css') ?>" rel='Stylesheet' />

    <link type='text/css' href="//cdnsidesimanis.slemankab.go.id//assets/css/ui-buttons.css" rel='Stylesheet' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link type='text/css' href="//cdnsidesimanis.slemankab.go.id//assets/front/css/colorbox.css" rel='Stylesheet' />
    <script src="//cdnsidesimanis.slemankab.go.id//assets/front/js/stscode.js"></script>
    <script src="//cdnsidesimanis.slemankab.go.id//assets/js/jquery-1.5.2.min.js"></script>
    <script src="//cdnsidesimanis.slemankab.go.id//assets/js/jquery-ui-1.8.16.custom.min.js"></script>
    <script src="//cdnsidesimanis.slemankab.go.id//assets/js/donjoscript/donjo.ui.dialog.js"></script>
    <script src="//cdnsidesimanis.slemankab.go.id//assets/front/js/layout.js"></script>
    <script src="//cdnsidesimanis.slemankab.go.id//assets/front/js/jquery.colorbox.js"></script>
    <script>
        $(document).ready(function() {
            $(".group2").colorbox({
                rel: 'group2',
                transition: "fade"
            });
            $(".group3").colorbox({
                rel: 'group3',
                transition: "fade"
            });
        });
    </script>
</head>

<body>
    <div id="maincontainer">

        <?= $this->include('partials/header') ?>
        <?= $this->renderSection('content') ?>
        <?= $this->include('partials/sidebar') ?>
        <?= $this->include('partials/footer') ?>

    </div>
</body>

</html>
