<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/director/dashboard', 'DirectorController::dashboard');

$routes->get('student/score', 'StudentController::score');
$routes->get('student/profile', 'StudentController::profile');
$routes->get('student/final_result', 'StudentController::final_result');

$routes->get('cashier/payment/list', 'CashierController::list');
$routes->get('cashier/extense', 'CashierController::extense');
$routes->get('cashier/profile', 'CashierController::profile');
$routes->get('cashier/payment/viewinfo', 'CashierController::viewinfo');

$routes->get('supervisor/fault', 'SupervisorController::fault');
$routes->get('supervisor/profile', 'SupervisorController::profile');

$routes->get('/', 'Home::index');

