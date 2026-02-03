<?php

require __DIR__ . '/../vendor/autoload.php';

use Config\Application;

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/..');
$dotenv->Load();
session_start();
$app = new Application();
$app->run();
