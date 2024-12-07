<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//  director
$routes->get('director/statics/conduct', 'DirectorController::staticsConduct');
$routes->get('director/statics/student', 'DirectorController::staticsStudent');
$routes->get('director/statics/grade', 'DirectorController::staticsGrade');


// Director - Trang Danh sách học sinh
$routes->get('director/student/add', 'DirectorController::studentAdd');
$routes->post('director/student/add', 'DirectorController::addStudent');
$routes->get('director/student/update/(:segment)', 'DirectorController::studentUpdate/$1');
$routes->post('/director/student/updateStudent', 'DirectorController::updateStudent');
$routes->get('director/student/list', 'DirectorController::studentList');


$routes->get('director/student/record', 'DirectorController::studentRecord');
$routes->get('director/student/perserved', 'DirectorController::studentPerserved');
$routes->get('director/student/payment', 'DirectorController::studentPayment');
$routes->get('director/title/list', 'DirectorController::titleList');
$routes->get('director/title/add', 'DirectorController::titleAdd');
$routes->get('director/title/update', 'DirectorController::titleUpdate');
$routes->get('director/class/list', 'DirectorController::classList');
$routes->get('director/class/add', 'DirectorController::classAdd');
$routes->get('director/class/update', 'DirectorController::classUpdate');
$routes->get('director/class/arrange/student', 'DirectorController::classArrangeStudent');
$routes->get('director/class/arrange/teacher', 'DirectorController::classArrangeTeacher');
$routes->get('director/employee/teacher/list', 'DirectorController::employeeTeacherList');
$routes->get('director/employee/teacher/add', 'DirectorController::employeeTeacherAdd');
$routes->get('director/employee/cashier/list', 'DirectorController::employeeCashierList');
$routes->get('director/employee/cashier/add', 'DirectorController::employeeCashierAdd');
$routes->get('director/employee/cashier/update', 'DirectorController::employeeCashierUpdate');
$routes->get('director/employee/supervisor/list', 'DirectorController::employeeSupervisorList');
$routes->get('director/employee/supervisor/add', 'DirectorController::employeeSupervisorAdd');
$routes->get('director/employee/supervisor/update', 'DirectorController::employeeSupervisorUpdate');
$routes->get('director/profile', 'DirectorController::profile');
$routes->get('director/changepw', 'DirectorController::changepw');

// student
$routes->get('student/score', 'StudentController::score');
$routes->get('student/profile', 'StudentController::profile');
$routes->get('student/final_result', 'StudentController::final_result');
$routes->get('student/fee_payment', 'StudentController::fee_payment');
$routes->get('student/conduct', 'StudentController::conduct');
$routes->get('student/fee_info', 'StudentController::fee_info');
$routes->get('student/changepw', 'StudentController::changepw');



// cashier
$routes->get('cashier/payment/list', 'CashierController::list');
$routes->get('cashier/extense', 'CashierController::extense');
$routes->get('cashier/profile', 'CashierController::profile');
$routes->get('cashier/payment/viewinfo', 'CashierController::viewinfo');
$routes->get('cashier/payment/add', 'CashierController::add');
$routes->get('cashier/payment/addextense', 'CashierController::addextense');
$routes->get('cashier/changepw', 'cashierController::changepw');



// supervisor
$routes->get('supervisor/fault', 'SupervisorController::fault');
$routes->get('supervisor/profile', 'SupervisorController::profile');
$routes->get('supervisor/category', 'SupervisorController::category');
$routes->get('supervisor/addfault', 'SupervisorController::addfault');
$routes->get('supervisor/addcategory', 'SupervisorController::addcategory');
$routes->get('supervisor/changepw', 'SupervisorController::changepw');
$routes->get('supervisor/updatecategory', 'SupervisorController::updatecategory');



// login 
$routes->get('/', 'LoginController::index');
$routes->post('login/authenticate', 'LoginController::authenticate');
$routes->get('logout', 'LoginController::logout');
