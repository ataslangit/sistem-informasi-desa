<?php

use App\Controllers\Main;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Main::class, 'index']);

$routes->get('install', [Main::class, 'initial'], ['as' => 'install']);
