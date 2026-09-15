<?php
namespace App\Core;
final class App {
    private static Container $container;
    public static function boot(Container $container): void { self::$container = $container; }
    public static function container(): Container { return self::$container; }
    public static function request(): Request { return new Request(); }
}
