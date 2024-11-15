<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/director/dashboard', 'DirectorController::dashboard');

$routes->get('supervisor/fault', 'SupervisorController::fault');
