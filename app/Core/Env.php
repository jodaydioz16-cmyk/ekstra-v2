<?php
namespace App\Core;
final class Env {
    public static function load(string $path): void {
        if (!is_readable($path)) return;
        foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
            if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
            [$key, $value] = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value, " \t\n\r\0\x0B\"");
        }
    }
    public static function get(string $key, ?string $default = null): ?string { return $_ENV[$key] ?? getenv($key) ?: $default; }
}
