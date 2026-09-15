<?php

declare(strict_types=1);

use App\Core\App;
use App\Core\Container;
use App\Core\Database;
use App\Core\Env;

spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';
    if (!str_starts_with($class, $prefix)) return;
    $file = __DIR__ . '/app/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (is_file($file)) require $file;
});

Env::load(__DIR__ . '/.env');
date_default_timezone_set('Asia/Jakarta');

$container = new Container();
$container->set(Database::class, static fn (): Database => new Database());
App::boot($container);
