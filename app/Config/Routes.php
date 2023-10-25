<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/register', 'Auth::register', ['as' => 'register']);

$routes->post('/register', 'Auth::store', ['as' => 'user.store']);

$routes->get('/login', 'Auth::index', ['as' => 'login']);

$routes->post('/login', 'Auth::login', ['as' => 'user.login']);
