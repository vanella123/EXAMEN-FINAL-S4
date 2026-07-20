<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/login', 'AuthController::index');

$routes->post('/login', 'AuthController::login');

$routes->get('/logout', 'AuthController::logout');

$routes->get('/client/dashboard', 'ClientController::dashboard');

$routes->get('/depot', 'OperationController::depot');
$routes->post('/depot/save', 'OperationController::saveDepot');
$routes->get('/retrait', 'OperationController::retrait');
$routes->post('/retrait/save', 'OperationController::saveRetrait');
// Transfert
$routes->get('/transfert', 'OperationController::transfert');
$routes->post('/transfert/save', 'OperationController::saveTransfert');