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

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->post('/logout', 'Auth::logout', ['as' => 'user.logout']);
});

$routes->group('', ['filter' => ['auth', 'verified', 'penyuluh']], function ($routes) {
    $routes->get('/formulir', 'Report::index', ['as' => 'formulir']);
    $routes->post('/formulir', 'Report::store', ['as' => 'lahan.store']);
});

$routes->group('dashboard', ['filter' => ['auth', 'verified']], function ($routes) {
    $routes->get('/', 'Dashboard\HomeController::index', ['as' => 'dashboard']);
    $routes->get('report', 'Dashboard\HomeController::report', ['as' => 'dashboard.reports']);

    // Master Komoditas
    $routes->group('komoditas', ['filter' => 'admin'], function ($routes) {
        $routes->get('/', 'Dashboard\KomoditasController::index', ['as' => 'komoditas.index']);
        $routes->post('/', 'Dashboard\KomoditasController::store', ['as' => 'komoditas.store']);
        $routes->put('(:num)', 'Dashboard\KomoditasController::update/$1', ['as' => 'komoditas.update']);
        $routes->delete('(:num)', 'Dashboard\KomoditasController::destroy/$1', ['as' => 'komoditas.destroy']);
    });

    // Konfirmasi Pengguna
    $routes->group('users', ['filter' => 'admin'], function ($routes) {
        $routes->get('/', 'Dashboard\UserController::index', ['as' => 'users.index']);
        $routes->post('(:num)/verify', 'Dashboard\UserController::verify/$1', ['as' => 'users.verify']);
        $routes->delete('(:num)', 'Dashboard\UserController::destroy/$1', ['as' => 'users.destroy']);
    });

    // Laporan Mingguan
    $routes->get('reports', 'Dashboard\LaporanMingguanController::index', ['as' => 'reports']);
});

$routes->group('ajax', function ($routes) {
    $routes->post('getDetailLuasPerBulan', 'Dashboard\AjaxController::getDetailLuasPerBulan', ['as' => 'ajax.get-detail-luas-per-bulan']);
});

$routes->group('api', function ($routes) {
    $routes->group('reports', function ($routes) {
        $routes->get('', 'Dashboard\HomeController::index', ['as' => 'api.reports']);
        $routes->get('kecamatan', 'Dashboard\HomeController::report', ['as' => 'api.reports.kecamatan']);
        $routes->post('desa', 'Dashboard\AjaxController::getDetailLuasPerBulan');
    });
});
