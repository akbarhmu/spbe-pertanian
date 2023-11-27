<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('', ['filter' => 'guest'], function ($routes) {
    $routes->get('/register', 'Auth::register', ['as' => 'register']);

    $routes->post('/register', 'Auth::store', ['as' => 'user.store']);

    $routes->get('/login', 'Auth::index', ['as' => 'login']);

    $routes->post('/login', 'Auth::login', ['as' => 'user.login']);
});

$routes->post('/logout', 'Auth::logout', ['as' => 'user.logout', 'filter' => 'auth']);

$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Dashboard\HomeController::index', ['as' => 'dashboard']);
    $routes->get('report/(:any)', 'Dashboard\HomeController::report/$1');

    // Master Komoditas
    $routes->get('komoditas', 'Dashboard\KomoditasController::index', ['as' => 'komoditas.index']);
    $routes->post('komoditas', 'Dashboard\KomoditasController::store', ['as' => 'komoditas.store']);
    $routes->put('komoditas/(:num)', 'Dashboard\KomoditasController::update/$1', ['as' => 'komoditas.update']);
    $routes->delete('komoditas/(:num)', 'Dashboard\KomoditasController::destroy/$1', ['as' => 'komoditas.destroy']);
});

$routes->get('/formulir', 'Report::index', ['filter' => 'auth']);
$routes->post('/formulir', 'Report::store', ['as' => 'lahan.store', ['filter' => 'auth']]);
