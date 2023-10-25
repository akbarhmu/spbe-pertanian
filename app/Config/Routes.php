<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('', ['filter' => 'guest'], function($routes){
    $routes->get('/register', 'Auth::register', ['as' => 'register']);
    
    $routes->post('/register', 'Auth::store', ['as' => 'user.store']);
    
    $routes->get('/login', 'Auth::index', ['as' => 'login']);
    
    $routes->post('/login', 'Auth::login', ['as' => 'user.login']);
});

$routes->post('/logout', 'Auth::logout', ['as' => 'user.logout', 'filter' => 'auth']);

$routes->group('dashboard', ['filter' => 'auth'], function($routes){
    $routes->get('/', 'Dashboard\HomeController::index', ['as' => 'dashboard']);
});
