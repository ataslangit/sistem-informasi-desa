<?php

use App\Controllers\Install;
use App\Controllers\Main;
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
$routes->group('siteman', ['filter' => 'isLogin'], static function ($routes) {
    $routes->get('/', [Login::class, 'index'], ['as' => 'login.view']);
    $routes->post('/', [Login::class, 'submit'], ['as' => 'login.submit']);
});
