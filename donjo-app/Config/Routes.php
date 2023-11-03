<?php

use App\Controllers\Install;
use App\Controllers\Main;
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
