<?php

use App\Controllers\ManageUserController;
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

$routes->group('profile', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'ProfileController::index');
    $routes->post('', 'ProfileController::create');
    $routes->post('edit/(:any)', 'ProfileController::edit/$1');

});

$routes->group('manage_user', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'ManageUserController::index');
    $routes->post('edit/(:any)', 'ManageUserController::edit/$1');
    $routes->post('delete/(:any)', 'ManageUserController::delete/$1');
});

$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth']);

$routes->get('/', 'Home::index', ['filter' => 'auth']);
$routes->get('/produk', 'ProdukController::index', ['filter' => 'auth']);

$routes->resource('api', ['controller' => 'apiController']);

