<!-- Sidebar -->
<?php /*
<!--
Helper classes

Adding .smini-hide to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
Adding .smini-show to an element will make it visible (opacity: 1) when the sidebar is in mini mode
    If you would like to disable the transition, just add the .no-transition along with one of the previous 2 classes

Adding .smini-hidden to an element will hide it when the sidebar is in mini mode
Adding .smini-visible to an element will show it only when the sidebar is in mini mode
Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
-->
*/ ?>
<nav id="sidebar">
    <!-- Sidebar Content -->
    <div class="sidebar-content">
        <!-- Side Header -->
        <div class="content-header justify-content-lg-center">
            <!-- Logo -->
            <div>
                <span class="smini-visible fw-bold tracking-wide fs-lg">
                    a<span class="text-danger">l</span>
                </span>
                <a class="link-fx fw-bold tracking-wide mx-auto" href="<?= site_url() ?>">
                    <span class="smini-hidden">
                        <span class="fs-4 text-dual">atas</span><span class="fs-4 text-danger">langit</span>
                    </span>
                </a>
            </div>
            <!-- END Logo -->

            <!-- Options -->
            <div>
                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-sm btn-alt-danger d-lg-none" data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-fw fa-times"></i>
                </button>
                <!-- END Close Sidebar -->
            </div>
            <!-- END Options -->
        </div>
        <!-- END Side Header -->

        <!-- Sidebar Scrolling -->
        <div class="js-sidebar-scroll">

            <!-- Side Navigation -->
            <div class="content-side content-side-full">
                <ul class="nav-main">
                    <?php
                    $moduls = $this->SettingModul->find()->where(['aktif' => '1', 'level >=' => $_SESSION['grup']])->get()->result_array();

                    foreach ($moduls as $modul) : ?>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="<?= site_url($modul['url']) ?>">
                                <i class="nav-main-link-icon fa fa-file"></i>
                                <span class="nav-main-link-name"><?= $modul['modul'] ?></span>
                            </a>
                        </li>
                    <?php endforeach ?>

                </ul>
            </div>
            <!-- END Side Navigation -->
        </div>
        <!-- END Sidebar Scrolling -->
    </div>
    <!-- Sidebar Content -->
</nav>
<!-- END Sidebar -->
