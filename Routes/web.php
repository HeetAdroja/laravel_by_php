<?php

use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;
use App\Controllers\authcontroller;
use App\Controllers\MailController;

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
    '/login',
    [UserController::class, 'showLoginForm'],

);
$router->any(
    '/submitlogin',
    [UserController::class, 'login'],

);
$router->any(
    '/auth',
    [authcontroller::class, 'login'],

);
$router->any(
    '/sendmail',
    [MailController::class, 'verify'],
);
