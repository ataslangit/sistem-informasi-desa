<?php

use App\Controllers\Install;
use App\Controllers\Main;
use App\Controllers\Siteman\Dashboard;
use App\Controllers\Siteman\Login;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Main::class, 'index']);

// install
$routes->group('install', static function ($routes) {
    $routes->get('/', [Install::class, 'index'], ['as' => 'install.view']);
    $routes->post('/', [Install::class, 'submit'], ['as' => 'install.process']);
});

// siteman
$routes->group('siteman', static function ($routes) {
    // login
    $routes->get('/', [Login::class, 'index'], ['as' => 'login.view', 'filter' => 'isLogin']);
    $routes->post('/', [Login::class, 'submit'], ['as' => 'login.submit', 'filter' => 'isLogin']);

    // dashboard
    $routes->get('dashboard', [Dashboard::class, 'index'], ['as' => 'siteman.dashboard.view']);
});

// redirect halaman yang lama
$routes->addRedirect('hom_desa', 'siteman.dashboard.view');
