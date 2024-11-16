<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/director/dashboard', 'DirectorController::dashboard');

$routes->get('student/score', 'StudentController::score');
$routes->get('student/profile', 'StudentController::profile');

$routes->get('cashier/payment', 'CashierController::payment');
$routes->get('cashier/extense', 'CashierController::extense');

$routes->get('supervisor/fault', 'SupervisorController::fault');

$routes->get('/', 'Home::index');