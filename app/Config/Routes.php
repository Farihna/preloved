<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ============================================
// 1. PUBLIC & AUTHENTICATION
// ============================================
$routes->get('/', 'Home::index');

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::register');
$routes->get('logout', 'AuthController::logout');

// ============================================
// 2. PROTECTED ROUTES (Hanya untuk User Login)
// ============================================
$routes->group('', ['filter' => 'auth'], function($routes) {

    // --- DASHBOARD ---
    $routes->get('dashboard', 'DashboardController::index');

    // --- PRODUK CRUD (User to User) ---
    $routes->group('produk', function($routes) {
        $routes->get('', 'ProdukController::index');
        $routes->post('', 'ProdukController::create');
        $routes->get('detail/(:num)', 'ProdukController::detail/$1');
        $routes->post('edit/(:num)', 'ProdukController::edit/$1');
        $routes->get('delete/(:num)', 'ProdukController::delete/$1');
        $routes->get('download', 'ProdukController::download'); // Untuk laporan/admin
    });

    // --- PROFILE ---
    $routes->group('profile', function($routes) {
        $routes->get('', 'ProfileController::index');
        $routes->post('edit/(:num)', 'ProfileController::edit/$1');
    });

    // --- NEGOTIATION (Fitur Tawar Menawar) ---
    $routes->group('negotiation', function($routes) {
        // Sisi Pembeli
        $routes->post('create', 'NegotiationController::create');
        $routes->get('my-offers', 'NegotiationController::myOffers');
        // Sisi Penjual
        $routes->get('requests', 'NegotiationController::requests');
        $routes->post('accept/(:num)', 'NegotiationController::accept/$1');
        $routes->post('reject/(:num)', 'NegotiationController::reject/$1');
    });

    // --- TRANSACTION (Proses Jual Beli) ---
    $routes->group('transaction', function($routes) {
        $routes->get('checkout/(:num)', 'TransactionController::checkout/$1');
        $routes->post('process', 'TransactionController::process');
        $routes->get('my-orders', 'TransactionController::myOrders'); // Pembeli
        $routes->get('my-sales', 'TransactionController::mySales');   // Penjual
        $routes->post('payment-proof', 'TransactionController::uploadPaymentProof');
    });

    // --- ADMIN ONLY (Manage User) ---
    $routes->group('manage_user', function($routes) {
        $routes->get('', 'ManageUserController::index');
        $routes->post('edit/(:num)', 'ManageUserController::edit/$1');
        $routes->get('delete/(:num)', 'ManageUserController::delete/$1');
    });
});

// ============================================
// 3. API & INTEGRASI (Optional)
// ============================================
$routes->group('rajaongkir', function($routes) {
    $routes->get('provinces', 'RajaOngkirController::provinces');
    $routes->get('cities/(:num)', 'RajaOngkirController::cities/$1');
});