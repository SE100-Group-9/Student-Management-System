<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$route['director/dashboard'] = 'director/dashboard/index';
$routes->get('director/dashboard', 'Director\Dashboard::index');
$routes->get('student/score', 'StudentController::score');

$routes->get('cashier/payment', 'CashierController::payment');
$routes->get('cashier/extense', 'CashierController::extense');

$routes->get('supervisor/fault', 'SupervisorController::fault');

// $routes->get('/', 'LoginController::index'); // Trỏ tới controller LoginController và phương thức index
