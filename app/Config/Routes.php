<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

$routes->get('register', 'AuthController::register'); 
$routes->post('register', 'AuthController::register');

$routes->group('produk', ['filter' => 'auth'], function ($routes) { 
    $routes->get('', 'ProdukController::index');
    $routes->post('', 'ProdukController::create');
    $routes->post('edit/(:any)', 'ProdukController::edit/$1');
    $routes->get('delete/(:any)', 'ProdukController::delete/$1');
    $routes->get('download', 'ProdukController::download');
});


$routes->get('/', 'Home::index', ['filter' => 'auth']);
$routes->get('/produk', 'ProdukController::index', ['filter' => 'auth']);

$routes->resource('api', ['controller' => 'apiController']);

