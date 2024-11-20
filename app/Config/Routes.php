<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//  director
$routes->get('/director/dashboard', 'DirectorController::dashboard');
$routes->get('/director/news', 'DirectorController::news');
$routes->get('director/statics/conduct', 'DirectorController::staticsConduct');
$routes->get('director/statics/student', 'DirectorController::staticsStudent');
$routes->get('director/statics/grade', 'DirectorController::staticsGrade');
$routes->get('director/student/add', 'DirectorController::studentAdd');
$routes->get('director/student/update', 'DirectorController::studentUpdate');
$routes->get('director/student/list', 'DirectorController::studentList');
$routes->get('director/student/record', 'DirectorController::studentRecord');
$routes->get('director/student/perserved', 'DirectorController::studentPerserved');
$routes->get('director/student/payment', 'DirectorController::studentPayment');

// student
$routes->get('student/score', 'StudentController::score');
$routes->get('student/profile', 'StudentController::profile');
$routes->get('student/final_result', 'StudentController::final_result');
$routes->get('student/fee_payment', 'StudentController::fee_payment');
$routes->get('student/conduct', 'StudentController::conduct');

// cashier
$routes->get('cashier/payment/list', 'CashierController::list');
$routes->get('cashier/extense', 'CashierController::extense');
$routes->get('cashier/profile', 'CashierController::profile');
$routes->get('cashier/payment/viewinfo', 'CashierController::viewinfo');
$routes->get('cashier/payment/add', 'CashierController::add');
$routes->get('cashier/payment/addextense', 'CashierController::addextense');

// supervisor
$routes->get('supervisor/fault', 'SupervisorController::fault');
$routes->get('supervisor/profile', 'SupervisorController::profile');

// login 
$routes->get('/', 'Home::index');
