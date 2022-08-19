<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Main');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Main::index');

// route admin
$routes->get('hom_desa', 'Admin/dashboard/index'); // redirect ke dashboard
$routes->get('admin/dashboard', 'Admin/dashboard/dashboard');

$routes->get('admin/about', 'Admin/dashboard/about');

$routes->get('admin/pengaturan_desa/update/(:any)', 'Admin/dashboard/update/$1');
$routes->get('admin/pengaturan_desa/ajax_kantor_maps', 'Admin/dashboard/ajax_kantor_maps');
$routes->get('admin/pengaturan_desa/ajax_wilayah_maps', 'Admin/dashboard/ajax_wilayah_maps');

// halaman database
$routes->get('database', 'Admin/database/index'); // lempar ke halaman database
$routes->get('admin/database', 'Admin/database/index');
$routes->get('admin/database/import', 'Admin/database/import');
$routes->get('admin/database/exec_backup', 'Admin/database/exec_backup');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
