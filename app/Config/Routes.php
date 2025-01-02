
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//  director
$routes->get('director/statics/conduct', 'DirectorController::staticsConduct');
$routes->get('director/statics/student', 'DirectorController::staticsStudent');
$routes->get('director/statics/grade', 'DirectorController::staticsGrade');


// Director - Danh sách học sinh
$routes->get('director/student/add', 'DirectorController::studentAdd');
$routes->post('director/student/add', 'DirectorController::addStudent');
$routes->get('director/student/update/(:segment)', 'DirectorController::studentUpdate/$1');
$routes->post('director/student/updateStudent', 'DirectorController::updateStudent');
$routes->get('director/student/list', 'DirectorController::studentList');
$routes->get('director/student/delete/(:segment)', 'DirectorController::deleteStudent/$1');

// Director - Thông tin học bạ
$routes->get('director/student/record', 'DirectorController::studentRecord');
//$routes->get('director/student/perserved', 'DirectorController::studentPerserved');

// Director - Thông tin thanh toán
$routes->get('director/student/payment', 'DirectorController::studentPayment');

// Director - Danh hiệu
$routes->get('director/title/list', 'DirectorController::titleList');
$routes->post('director/title/list', 'DirectorController::updateRule');
$routes->get('director/title/add', 'DirectorController::titleAdd');
$routes->post('director/title/add', 'DirectorController::addTitle');
$routes->get('director/title/update/(:num)', 'DirectorController::titleUpdate/$1');
$routes->post('director/title/update', 'DirectorController::updateTitle');  
$routes->get('director/title/delete/(:num)', 'DirectorController::titleDelete/$1');

// Director - Quản lý lớp học
$routes->get('director/class/list', 'DirectorController::classList');
$routes->get('director/class/add', 'DirectorController::classAdd');
$routes->post('director/class/add', 'DirectorController::addClass');
$routes->get('director/class/update/(:num)', 'DirectorController::classUpdate/$1');
$routes->post('director/class/update', 'DirectorController::updateClass');
$routes->get('director/class/delete/(:num)', 'DirectorController::deleteClass/$1');

// Director - Xếp lớp
$routes->get('director/class/arrange/student/(:num)', 'DirectorController::classArrangeStudent/$1');
$routes->get('director/class/arrange/student/delete/(:segment)', 'DirectorController::deleteStudentFromClass/$1');
$routes->get('director/class/arrange/teacher/(:num)', 'DirectorController::classArrangeTeacher/$1');
$routes->get('director/class/arrange/teacher/delete/(:segment)', 'DirectorController::deleteTeacherFromClass/$1');

// Director - Xếp lớp - Thêm học sinh    
$routes->get('director/class/arrange/addstudent/(:num)', 'DirectorController::classArrangeAddStudent/$1');
$routes->post('director/class/arrange/addstudent', 'DirectorController::addStudentToClass');
// Director - Xếp lớp - Thêm giáo viên
$routes->get('director/class/arrange/addteacher/(:num)', 'DirectorController::classArrangeAddTeacher/$1');
$routes->post('director/class/arrange/addteacher', 'DirectorController::addTeacherToClass');


// Director - Quản lý giáo viên
$routes->get('director/employee/teacher/list', 'DirectorController::employeeTeacherList');
$routes->get('director/employee/teacher/add', 'DirectorController::employeeTeacherAdd');
$routes->post('director/employee/teacher/add', 'DirectorController::addEmployeeTeacher');
$routes->get('director/employee/teacher/update/(:segment)', 'DirectorController::employeeTeacherUpdate/$1');
$routes->post('director/employee/teacher/update/(:segment)', 'DirectorController::updateEmployeeTeacher/$1');
$routes->get('director/employee/teacher/delete/(:segment)', 'DirectorController::deleteEmployeeTeacher/$1');

// Director - Quản lý Thu ngân
$routes->get('director/employee/cashier/list', 'DirectorController::employeeCashierList');
$routes->get('director/employee/cashier/add', 'DirectorController::employeeCashierAdd');
$routes->post('director/employee/cashier/add', 'DirectorController::addEmployeeCashier');
$routes->get('director/employee/cashier/update/(:segment)', 'DirectorController::employeeCashierUpdate/$1');
$routes->post('director/employee/cashier/update/(:segment)', 'DirectorController::updateEmployeeCashier/$1');
$routes->get('director/employee/cashier/delete/(:segment)', 'DirectorController::deleteEmployeeCashier/$1');

// Director - Quản lý Giám thị
$routes->get('director/employee/supervisor/list', 'DirectorController::employeeSupervisorList');
$routes->get('director/employee/supervisor/add', 'DirectorController::employeeSupervisorAdd');
$routes->post('director/employee/supervisor/add', 'DirectorController::addEmployeeSupervisor');
$routes->get('director/employee/supervisor/update/(:segment)', 'DirectorController::employeeSupervisorUpdate/$1');
$routes->post('director/employee/supervisor/update/(:segment)', 'DirectorController::updateEmployeeSupervisor/$1');
$routes->get('director/employee/supervisor/delete/(:segment)', 'DirectorController::deleteEmployeeSupervisor/$1');

// Director - Thanh Header
$routes->get('director/profile', 'DirectorController::profile');
$routes->post('director/profile', 'DirectorController::updateProfile');
$routes->get('director/changepw', 'DirectorController::changepw');
$routes->post('director/changepw', 'DirectorController::updatePassword');

// student
$routes->get('student/score', 'StudentController::score');
$routes->get('student/profile', 'StudentController::profile');
$routes->get('student/final_result', 'StudentController::final_result');
$routes->get('student/conduct', 'StudentController::conduct');
$routes->get('student/fee_info', 'StudentController::fee_info');
$routes->get('student/changepw', 'StudentController::changepw');



// cashier

$routes->get('cashier/profile', 'CashierController::profile');
$routes->post('cashier/profile', 'CashierController::updateProfile');

$routes->get('cashier/invoice/list', 'CashierController::listInvoice');
$routes->get('cashier/invoice/add', 'CashierController::addInvoice');
$routes->get('cashier/payment/add/(:num)', 'CashierController::addPaymentForm/$1'); 
$routes->post('cashier/payment/add/(:num)', 'CashierController::addPayment/$1');
$routes->get('cashier/payment/list/(:num)', 'CashierController::listPayment/$1');
$routes->get('cashier/payment/delete/(:num)', 'CashierController::deletePayment/$1');


$routes->get('cashier/invoice/add', 'CashierController::invoice');
$routes->post('cashier/invoice/add', 'CashierController::addInvoice');


$routes->get('cashier/changepw', 'CashierController::changepw');
$routes->post('cashier/changepw', 'CashierController::updatePassword');
//$routes->get('cashier/statics/student', 'cashierController::staticStudent');


// supervisor

$routes->get('supervisor/profile', 'SupervisorController::profile');
$routes->post('supervisor/profile', 'SupervisorController::updateProfile');

$routes->get('supervisor/fault', 'SupervisorController::fault');
$routes->get('supervisor/addfault', 'SupervisorController::addfaultForm');
$routes->get('supervisor/faultDetail/(:num)', 'SupervisorController::faultDetail/$1');
$routes->post('supervisor/addfault', 'SupervisorController::addfault');
$routes->get('supervisor/deletefault/(:num)', 'SupervisorController::deletefault/$1');

$routes->get('supervisor/category', 'SupervisorController::category');
$routes->get('supervisor/addcategory', 'SupervisorController::addcategoryForm');
$routes->post('supervisor/addcategory', 'SupervisorController::addcategory');
$routes->get('supervisor/updatecategory/(:num)', 'SupervisorController::updatecategoryForm/$1');
$routes->post('supervisor/updatecategory/(:num)', 'SupervisorController::updatecategory/$1');
$routes->get('supervisor/deletecategory/(:num)', 'SupervisorController::deletecategory/$1');

$routes->get('supervisor/changepw', 'SupervisorController::changepw');
$routes->post('supervisor/changepw', 'SupervisorController::updatePassword');



// login 
$routes->get('/', 'LoginController::index');
$routes->post('login/authenticate', 'LoginController::authenticate');
$routes->get('logout', 'LoginController::logout');

// Teacher
// Teacher - Danh sách học sinh
$routes->get('teacher/student/list', 'TeacherController::studentList');

// Teacher - Thống kê học lực
$routes->get('teacher/statics/grade', 'TeacherController::statics');

// Teacher - Đánh giá kết quả học tập
$routes->get('teacher/class/rate', 'TeacherController::classRate');
$routes->post('teacher/class/rate', 'TeacherController::addRate');

// Teacher Chưa code frontend
$routes->get('teacher/class/rating', 'TeacherController::classRating');
$routes->get('teacher/class/enter/student', 'TeacherController::enterStudent');

// Teacher - Báo cáo học lực lớp
$routes->get('teacher/class/record/list', 'TeacherController::recordList');
$routes->get('teacher/class/record/detail', 'TeacherController::recordDetail');

// Teacher - Nhập điểm
$routes->get('teacher/class/enter/list', 'TeacherController::enterList');
$routes->get('teacher/class/enter/next', 'TeacherController::enterNext');
$routes->post('teacher/class/enter/next', 'TeacherController::enterScore');


// Teacher - Thanh Header
$routes->get('teacher/profile', 'TeacherController::profile');
$routes->post('teacher/profile', 'TeacherController::updateProfile');
$routes->get('teacher/changepw', 'TeacherController::changepw');
$routes->post('teacher/changepw', 'TeacherController::updatePassword');