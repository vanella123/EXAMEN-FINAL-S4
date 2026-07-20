<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'AuthController::index');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');

$routes->get('/client/dashboard', 'ClientController::dashboard');

$routes->get('/depot', 'OperationController::depot');
$routes->post('/depot/save', 'OperationController::saveDepot');
$routes->get('/retrait', 'OperationController::retrait');
$routes->post('/retrait/save', 'OperationController::saveRetrait');

$routes->get('/transfert', 'TransfertController::index');
$routes->post('/transfert/save', 'TransfertController::save');

$routes->get('/historique', 'HistoriqueController::index');

// Admin
$routes->get('/admin/login', 'AdminAuthController::index');
$routes->post('/admin/login', 'AdminAuthController::login');
$routes->get('/admin/logout', 'AdminAuthController::logout');

$routes->get('/admin/dashboard', 'AdminDashboardController::index');

$routes->get('/admin/prefixes', 'PrefixeController::index');
$routes->post('/admin/prefixes/create', 'PrefixeController::create');
$routes->post('/admin/prefixes/update', 'PrefixeController::update');
$routes->get('/admin/prefixes/delete/(:num)', 'PrefixeController::delete/$1');

$routes->get('/admin/types-operations', 'TypeOperationController::index');
$routes->post('/admin/types/create', 'TypeOperationController::create');
$routes->post('/admin/types/update', 'TypeOperationController::update');
$routes->get('/admin/types-operations/delete/(:num)', 'TypeOperationController::delete/$1');

$routes->get('/admin/baremes', 'BaremeController::index');
$routes->post('/admin/baremes/create', 'BaremeController::create');
$routes->post('/admin/baremes/update', 'BaremeController::update');
$routes->get('/admin/baremes/delete/(:num)', 'BaremeController::delete/$1');

$routes->get('/admin/comptes', 'CompteController::index');

$routes->get('/admin/gains', 'GainController::index');