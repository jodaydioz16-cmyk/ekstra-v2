<?php
namespace App\Core;
final class Router {
    private array $routes = [];
    public function get(string $path, array $handler): void { $this->add('GET', $path, $handler); }
    public function post(string $path, array $handler): void { $this->add('POST', $path, $handler); }
    private function add(string $method, string $path, array $handler): void { $this->routes[] = compact('method', 'path', 'handler'); }
    public function dispatch(Request $request): never {
        foreach ($this->routes as $route) {
            if ($route['method'] !== $request->method) continue;
            $pattern = '#^' . preg_replace('#\\{([a-z_]+)\\}#', '(?P<$1>[a-z0-9-]+)', $route['path']) . '$#';
            if (preg_match($pattern, $request->path, $matches)) { $controller = new $route['handler'][0](); $method = $route['handler'][1]; $controller->$method($request, ...array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY)); }
        }
        http_response_code(404); View::render('errors/404'); exit;
    }
}
