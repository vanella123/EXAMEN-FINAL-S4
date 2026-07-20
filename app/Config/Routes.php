<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/login', 'AuthController::index');

$routes->post('/login', 'AuthController::login');

$routes->get('/logout', 'AuthController::logout');

$routes->get('/client/dashboard', 'ClientController::dashboard');