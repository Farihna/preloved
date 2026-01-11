<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::register');
$routes->get('logout', 'AuthController::logout');

$routes->group('', ['filter' => 'auth'], function($routes) {

    $routes->get('dashboard', 'DashboardController::index');

    $routes->group('produk', function($routes) {
        $routes->get('', 'ProdukController::index');
        $routes->post('', 'ProdukController::create');
        $routes->get('detail/(:num)', 'ProdukController::detail/$1');
        $routes->post('edit/(:num)', 'ProdukController::edit/$1');
        $routes->get('delete/(:num)', 'ProdukController::delete/$1');
        $routes->get('download', 'ProdukController::download'); // Untuk laporan/admin
    });

    $routes->group('profile', function($routes) {
        $routes->get('', 'ProfileController::index');
        $routes->post('edit/(:num)', 'ProfileController::edit/$1');
    });

    $routes->group('negotiation', function($routes) {
        // Sisi Pembeli
        $routes->post('create', 'NegotiationController::create');
        $routes->get('my-offers', 'NegotiationController::myOffers');
        $routes->post('counter-offer', 'NegotiationController::counterOffer');
        // Sisi Penjual
        $routes->get('requests', 'NegotiationController::requests');
        $routes->post('counter/(:num)', 'NegotiationController::counter/$1');
        $routes->post('accept/(:num)', 'NegotiationController::accept/$1');
        $routes->post('reject/(:num)', 'NegotiationController::reject/$1');
    });

    $routes->group('transaction', function($routes) {
        $routes->get('checkout/(:num)', 'TransaksiController::checkout/$1');
        $routes->post('process', 'TransaksiController::process');
        $routes->get('my-orders', 'TransaksiController::myOrders');
        $routes->get('my-sales', 'TransaksiController::mySales');   
        $routes->post('payment-proof', 'TransaksiController::uploadPaymentProof');
        $routes->get('detail/(:num)', 'TransaksiController::detail/$1');
        $routes->post('cancel/(:num)', 'TransaksiController::cancel/$1');
    });

    $routes->group('manage_user', function($routes) {
        $routes->get('', 'ManageUserController::index');
        $routes->post('edit/(:num)', 'ManageUserController::edit/$1');
        $routes->get('delete/(:num)', 'ManageUserController::delete/$1');
    });
});

$routes->group('rajaongkir', function($routes) {
    $routes->post('calculate-shipping', 'RajaOngkirController::calculateShipping');
    $routes->get('search-destination', 'RajaOngkirController::searchDestination');
});

$routes->group('address', function($routes) {
    $routes->get('provinces', 'AddressController::getProvinces');
    $routes->get('cities/(:num)', 'AddressController::getCities/$1');
    $routes->get('districts/(:num)', 'AddressController::getDistricts/$1');
    $routes->get('villages/(:num)', 'AddressController::getVillages/$1');
    $routes->get('postal-code/(:num)', 'AddressController::getPostalCodeByVillage/$1');
    $routes->post('store', 'AddressController::store');
    $routes->get('edit/(:num)', 'AddressController::edit/$1');
    $routes->post('update', 'AddressController::update');
    $routes->post('set-default/(:num)', 'AddressController::setDefault/$1');
    $routes->delete('delete/(:num)', 'AddressController::delete/$1');
});

$routes->group('payment', function($routes) {
    $routes->post('create-snap-token', 'PaymentController::createSnapToken');
    $routes->post('midtrans/notification', 'PaymentController::midtransNotification');
    $routes->get('finish', 'PaymentController::finish');
    $routes->get('unfinish', 'PaymentController::unfinish');
    $routes->get('error', 'PaymentController::error');
    $routes->get('check-status/(:num)', 'PaymentController::checkStatus/$1');
    $routes->get('page/(:num)', 'TransaksiController::paymentPage/$1');
});

$routes->get('wallet', 'WalletController::index');
$routes->post('wallet/withdraw', 'WalletController::withdraw');