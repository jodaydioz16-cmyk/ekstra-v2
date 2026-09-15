<?php
namespace App\Core;
final class View {
    public static function render(string $template, array $data = [], string $layout = 'public'): never {
        extract($data, EXTR_SKIP); ob_start(); require dirname(__DIR__, 2) . '/views/' . $template . '.php'; $content = ob_get_clean(); require dirname(__DIR__, 2) . '/views/layouts/' . $layout . '.php'; exit;
    }
    public static function e(?string $value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
}
