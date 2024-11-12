<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$route['director/dashboard'] = 'director/dashboard/index';
$routes->get('director/dashboard', 'Director\Dashboard::index');

// $routes->get('/', 'LoginController::index'); // Trỏ tới controller LoginController và phương thức index
