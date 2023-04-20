<?php

namespace Config;

use App\Controllers\Admin\Hom_desa;
use App\Controllers\Admin\Pengurus;
use App\Controllers\First;
use App\Controllers\Main;
use App\Controllers\Siteman;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', [First::class, 'index']);

$routes->get('instal', [Main::class, 'initial'], ['filter' => 'instal:done', 'as' => 'instal.view']);

$routes->group('first', static function ($routes) {
    $routes->get('/', [First::class, 'index']);
    $routes->get('artikel/(:segment)', [First::class, 'artikel']);
    $routes->get('kategori/(:num)', [First::class, 'kategori']);
    $routes->get('gallery', [First::class, 'gallery']);
    $routes->get('sub_gallery/(:num)', [First::class, 'sub_gallery']);
    $routes->get('statistik/(:segment)', [First::class, 'statistik']);
    $routes->get('statistik/(:segment)/(:num)', [First::class, 'statistik']);
    $routes->get('wilayah', [First::class, 'wilayah']);
});

$routes->group('siteman', ['filter' => 'login:view'], static function ($routes) {
    $routes->get('/', [Siteman::class, 'index'], ['as' => 'login.view']);
    $routes->post('/', [Siteman::class, 'auth'], ['as' => 'login.auth']);
});

$routes->group('admin', ['filter' => 'login:admin'], static function ($routes) {
    $routes->group('hom_desa', ['filter' => 'login:admin'], static function ($routes) {
        $routes->get('/', [Hom_desa::class, 'index'], ['as' => 'admin.dashboard']);
        $routes->post('update', [Hom_desa::class, 'update'], ['as' => 'admin.infodesa.update']);
    });

    $routes->group('pengurus', ['filter' => 'login:admin'], static function ($routes) {
        $routes->get('/', [Pengurus::class, 'index'], ['as' => 'admin.pengurus.index']);
        $routes->get('form', [Pengurus::class, 'create'], ['as' => 'admin.pengurus.create']);
        $routes->post('form', [Pengurus::class, 'submit'], ['as' => 'admin.pengurus.submit']);
        $routes->get('edit/(:num)', [Pengurus::class, 'edit'], ['as' => 'admin.pengurus.edit']);
        $routes->post('edit', [Pengurus::class, 'update'], ['as' => 'admin.pengurus.update']);
        $routes->get('delete/(:num)', [Pengurus::class, 'delete'], ['as' => 'admin.pengurus.delete']);
        $routes->post('delete_all', [Pengurus::class, 'delete_all'], ['as' => 'admin.pengurus.deleteAll']);
    });

    $routes->addRedirect('/', 'admin.dashboard', 301);
});

$routes->addRedirect('hom_desa', 'admin.dashboard', 301);
$routes->addRedirect('pengurus', 'admin.pengurus.index', 301);

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
