<?php

if (PHP_SAPI === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) return false;

require __DIR__ . '/../vendor/autoload.php';

use App\Router;
use App\Controllers\HomeController;
use App\Controllers\ArticleController;
use App\Controllers\CategoryController;

$router = new Router();

$router->add('GET', '/', [HomeController::class, 'index']);
$router->add('GET', '/article/{id}', [ArticleController::class, 'show']);
$router->add('GET', '/category/{id}', [CategoryController::class, 'show']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);