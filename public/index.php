<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\PublicController;
use App\Core\App;
use App\Core\Router;

require dirname(__DIR__) . '/bootstrap.php';

$router = new Router();
$router->get('/', [PublicController::class, 'home']);
$router->get('/ekstrakurikuler', [PublicController::class, 'extracurriculars']);
$router->get('/ekstrakurikuler/{slug}', [PublicController::class, 'showExtracurricular']);
$router->get('/berita', [PublicController::class, 'news']);
$router->get('/berita/{slug}', [PublicController::class, 'showNews']);
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/profil', [DashboardController::class, 'profile']);

$router->dispatch(App::request());
