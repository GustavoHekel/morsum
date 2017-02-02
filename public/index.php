<?php

 use Core\Router;

/**
 * Composer
 */
require '../vendor/autoload.php';

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::exceptionErrorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Routing
 */
$router = new Router();

// This route is for the index
$router->add('', ['controller' => 'Home', 'method' => 'index']);

// This is for adding routes in a dynamical way matching the following formats.
//
// test.com/posts/create
// Where:
//         posts -> controller
//         create -> method
//
// test.com/posts/1/edit
// Where:
//         posts -> controller
//         1 -> id
//         edit -> method
//
// Just type in that format in the URL and the Router will use the corresponding
// Controller / Method
$router->add('{controller}/{method}');
$router->add('{controller}/{id:\d+}/{method}');

// Execute the method's controller
$router->dispatch($_SERVER['QUERY_STRING']);
