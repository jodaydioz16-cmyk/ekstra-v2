<?php
namespace App\Core;
final class Request {
    public readonly string $method; public readonly string $path;
    public function __construct() { $this->method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET'); $this->path = rtrim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/', '/') ?: '/'; }
    public function input(string $key, ?string $default = null): ?string { return isset($_POST[$key]) && is_string($_POST[$key]) ? trim($_POST[$key]) : $default; }
}
