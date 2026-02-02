<?php

use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;
use App\Controllers\authcontroller;

$router->any(
    '/',
    [UserController::class, 'index'],

);
$router->any(
    '/register',
    [UserController::class, 'showRegisterForm'],

);
$router->any(
    '/submitregister',
    [UserController::class, 'Register'],
    // [AuthMiddleware::class]
);
$router->any(
    '/auth',
    [authcontroller::class, 'login'],
);
