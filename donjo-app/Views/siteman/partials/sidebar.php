<?php

use App\Models\SettingModul;

?>
<!-- Side Overlay-->
<aside id="side-overlay">
    <!-- Side Header -->
    <div class="content-header">
        <!-- User Avatar -->
        <a class="img-link me-2" href="be_pages_generic_profile.html">
            <img class="img-avatar img-avatar32" src="assets/media/avatars/avatar15.jpg" alt="">
        </a>
        <!-- END User Avatar -->

        <!-- User Info -->
        <a class="link-fx text-body-color-dark fw-semibold fs-sm" href="be_pages_generic_profile.html">
            John Smith
        </a>
        <!-- END User Info -->

        <!-- Close Side Overlay -->
        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
        <button type="button" class="btn btn-sm btn-alt-danger ms-auto" data-toggle="layout" data-action="side_overlay_close">
            <i class="fa fa-fw fa-times"></i>
        </button>
        <!-- END Close Side Overlay -->
    </div>
    <!-- END Side Header -->

    <!-- Side Content -->
    <div class="content-side">
        <!-- Search -->
        <div class="block pull-t pull-x">
            <div class="block-content block-content-full block-content-sm bg-body-light">
                <form action="be_pages_generic_search.html" method="POST">
                    <div class="input-group">
                        <input type="text" class="form-control" id="side-overlay-search" name="side-overlay-search" placeholder="Search..">
                        <button type="submit" class="btn btn-secondary">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END Search -->

        <!-- Mini Stats -->
        <div class="block pull-x">
            <div class="block-content block-content-full block-content-sm bg-body-light">
                <div class="row text-center">
                    <div class="col-4">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">Clients</div>
                        <div class="fs-4">460</div>
                    </div>
                    <div class="col-4">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">Sales</div>
                        <div class="fs-4">728</div>
                    </div>
                    <div class="col-4">
                        <div class="fs-sm fw-semibold text-uppercase text-muted">Earnings</div>
                        <div class="fs-4">$7,860</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Mini Stats -->

        <!-- Friends -->
        <div class="block pull-x">
            <div class="block-header bg-body-light">
                <h3 class="block-title">
                    <i class="fa fa-fw fa-users opacity-50 me-1"></i> Friends
                </h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                        <i class="si si-refresh"></i>
                    </button>
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                </div>
            </div>
            <div class="block-content">
                <ul class="nav-users">
                    <li>
                        <a href="be_pages_generic_profile.html">
                            <img class="img-avatar" src="assets/media/avatars/avatar3.jpg" alt="">
                            <i class="fa fa-circle text-success"></i>
                            <div>Lori Grant</div>
                            <div class="fw-normal fs-xs text-muted">Photographer</div>
                        </a>
                    </li>
                    <li>
                        <a href="be_pages_generic_profile.html">
                            <img class="img-avatar" src="assets/media/avatars/avatar11.jpg" alt="">
                            <i class="fa fa-circle text-success"></i>
                            <div>Brian Cruz</div>
                            <div class="fw-normal fs-xs text-muted">Web Designer</div>
                        </a>
                    </li>
                    <li>
                        <a href="be_pages_generic_profile.html">
                            <img class="img-avatar" src="assets/media/avatars/avatar4.jpg" alt="">
                            <i class="fa fa-circle text-warning"></i>
                            <div>Danielle Jones</div>
                            <div class="fw-normal fs-xs text-muted">UI Designer</div>
                        </a>
                    </li>
                    <li>
                        <a href="be_pages_generic_profile.html">
                            <img class="img-avatar" src="assets/media/avatars/avatar12.jpg" alt="">
                            <div>Justin Hunt</div>
                            <div class="fw-normal fs-xs text-muted">Copywriter</div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- END Friends -->

        <!-- Activity -->
        <div class="block pull-x">
            <div class="block-header bg-body-light">
                <h3 class="block-title">
                    <i class="far fa-fw fa-clock opacity-50 me-1"></i> Activity
                </h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                        <i class="si si-refresh"></i>
                    </button>
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                </div>
            </div>
            <div class="block-content">
                <ul class="list list-activity mb-0">
                    <li>
                        <i class="si si-wallet text-success"></i>
                        <div class="fs-sm fw-semibold">+$29 New sale</div>
                        <div class="fs-sm">
                            <a href="javascript:void(0)">Admin Template</a>
                        </div>
                        <div class="fs-xs text-muted">5 min ago</div>
                    </li>
                    <li>
                        <i class="si si-close text-danger"></i>
                        <div class="fs-sm fw-semibold">Project removed</div>
                        <div class="fs-sm">
                            <a href="javascript:void(0)">Best Icon Set</a>
                        </div>
                        <div class="fs-xs text-muted">26 min ago</div>
                    </li>
                    <li>
                        <i class="si si-pencil text-info"></i>
                        <div class="fs-sm fw-semibold">You edited the file</div>
                        <div class="fs-sm">
                            <a href="javascript:void(0)">
                                <i class="fa fa-file-alt"></i> Docs.doc
                            </a>
                        </div>
                        <div class="fs-xs text-muted">3 hours ago</div>
                    </li>
                    <li>
                        <i class="si si-plus text-success"></i>
                        <div class="fs-sm fw-semibold">New user</div>
                        <div class="fs-sm">
                            <a href="javascript:void(0)">StudioWeb - View Profile</a>
                        </div>
                        <div class="fs-xs text-muted">5 hours ago</div>
                    </li>
                    <li>
                        <i class="si si-wrench text-warning"></i>
                        <div class="fs-sm fw-semibold">App v5.5 is available</div>
                        <div class="fs-sm">
                            <a href="javascript:void(0)">Update now</a>
                        </div>
                        <div class="fs-xs text-muted">8 hours ago</div>
                    </li>
                    <li>
                        <i class="si si-user-follow text-pulse"></i>
                        <div class="fs-sm fw-semibold">+1 Friend Request</div>
                        <div class="fs-sm">
                            <a href="javascript:void(0)">Accept</a>
                        </div>
                        <div class="fs-xs text-muted">1 day ago</div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- END Activity -->

        <!-- Profile -->
        <div class="block pull-x">
            <div class="block-header bg-body-light">
                <h3 class="block-title">
                    <i class="fa fa-fw fa-pencil-alt opacity-50 me-1"></i> Profile
                </h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <form action="be_pages_dashboard.html" method="POST" onsubmit="return false;">
                    <div class="mb-3">
                        <label class="form-label" for="side-overlay-profile-name">Name</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="side-overlay-profile-name" name="side-overlay-profile-name" placeholder="Your name.." value="John Smith">
                            <span class="input-group-text">
                                <i class="fa fa-user"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="side-overlay-profile-email">Email</label>
                        <div class="input-group">
                            <input type="email" class="form-control" id="side-overlay-profile-email" name="side-overlay-profile-email" placeholder="Your email.." value="john.smith@example.com">
                            <span class="input-group-text">
                                <i class="fa fa-envelope"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="side-overlay-profile-password">New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="side-overlay-profile-password" name="side-overlay-profile-password" placeholder="New Password..">
                            <span class="input-group-text">
                                <i class="fa fa-asterisk"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="side-overlay-profile-password-confirm">Confirm New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="side-overlay-profile-password-confirm" name="side-overlay-profile-password-confirm" placeholder="Confirm New Password..">
                            <span class="input-group-text">
                                <i class="fa fa-asterisk"></i>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <button type="submit" class="btn btn-alt-primary">
                                <i class="fa fa-sync opacity-50 me-1"></i> Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END Profile -->

        <!-- Settings -->
        <div class="block pull-x">
            <div class="block-header bg-body-light">
                <h3 class="block-title">
                    <i class="fa fa-fw fa-wrench opacity-50 me-1"></i> Settings
                </h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="side-overlay-settings-security-status" name="side-overlay-settings-security-status" checked>
                        <label class="form-check-label fw-medium" for="side-overlay-settings-security-status">Online Status</label>
                        <div class="fs-sm text-muted">Show your status to all</div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="side-overlay-settings-security-verify" name="side-overlay-settings-security-verify">
                        <label class="form-check-label fw-medium" for="side-overlay-settings-security-verify">Verify on Login</label>
                        <div class="fs-sm text-muted">Most secure option</div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="side-overlay-settings-security-updates" name="side-overlay-settings-security-updates" checked>
                        <label class="form-check-label fw-medium" for="side-overlay-settings-security-updates">Auto Updates</label>
                        <div class="fs-sm text-muted">Keep app updated</div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="side-overlay-settings-security-notifications" name="side-overlay-settings-security-notifications" checked>
                        <label class="form-check-label fw-medium" for="side-overlay-settings-security-notifications">Notifications</label>
                        <div class="fs-sm text-muted">For every transaction</div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="side-overlay-settings-security-api" name="side-overlay-settings-security-api" checked>
                        <label class="form-check-label fw-medium" for="side-overlay-settings-security-api">API Access</label>
                        <div class="fs-sm text-muted">Enable access from third party apps</div>
                    </div>
                </div>
                <div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="side-overlay-settings-security-2fa" name="side-overlay-settings-security-2fa">
                        <label class="form-check-label fw-medium" for="side-overlay-settings-security-2fa">Two Factor Auth</label>
                        <div class="fs-sm text-muted">Using an authenticator</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Settings -->
    </div>
    <!-- END Side Content -->
</aside>
<!-- END Side Overlay -->

<!-- Sidebar -->
<?php
/*
    Helper classes

    Adding .smini-hide to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
    Adding .smini-show to an element will make it visible (opacity: 1) when the sidebar is in mini mode
        If you would like to disable the transition, just add the .no-transition along with one of the previous 2 classes

    Adding .smini-hidden to an element will hide it when the sidebar is in mini mode
    Adding .smini-visible to an element will show it only when the sidebar is in mini mode
    Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
*/
?>
<nav id="sidebar" class="">
    <!-- Sidebar Content -->
    <div class="sidebar-content">
        <!-- Side Header -->
        <div class="content-header justify-content-lg-center">
            <!-- Logo -->
            <div>
                <span class="smini-visible fw-bold tracking-wide fs-lg">
                    c<span class="text-primary">b</span>
                </span>
                <a class="link-fx fw-bold tracking-wide mx-auto" href="index.html">
                    <span class="smini-hidden">
                        <span class="fs-4 text-dual">Atas</span><span class="fs-4 text-primary">Langit</span>
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
                    $moduls = model(SettingModul::class)->where(['aktif' => '1'])->orderBy('urut asc')->findAll();

                    foreach ($moduls as $modul): ?>

                        <li class="nav-main-item">
                            <a class="nav-main-link" href="<?= site_url($modul['url']) ?>">
                                <i class="nav-main-link-icon fa <?= esc($modul['icon'] ?? 'fa-file') ?>"></i>
                                <span class="nav-main-link-name"><?= esc($modul['modul']) ?></span>
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
