<?php
namespace App\Core;
final class Session {
    public static function start(): void { if (session_status() !== PHP_SESSION_ACTIVE) { session_name('ekstra_session'); session_set_cookie_params(['httponly'=>true,'secure'=>(($_SERVER['HTTPS'] ?? '') === 'on'),'samesite'=>'Lax','path'=>'/']); session_start(); } }
    public static function csrf(): string { self::start(); return $_SESSION['_csrf'] ??= bin2hex(random_bytes(32)); }
    public static function verifyCsrf(?string $token): bool { self::start(); return is_string($token) && isset($_SESSION['_csrf']) && hash_equals($_SESSION['_csrf'], $token); }
    public static function flash(string $key, ?string $message = null): ?string { self::start(); if ($message !== null) { $_SESSION['_flash'][$key] = $message; return null; } $v=$_SESSION['_flash'][$key]??null; unset($_SESSION['_flash'][$key]); return $v; }
}
