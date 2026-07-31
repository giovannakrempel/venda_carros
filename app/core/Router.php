<?php
class Router
{
    public static function dispatch(): void
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = trim($uri, '/');

        if ($uri === '') {
            $uri = 'home';
        }

        $segments = explode('/', $uri);
        $controllerName = $segments[0] ?? 'Home';
        $action = $segments[1] ?? 'index';

        $map = [
            'login' => ['AuthController', 'login'],
            'register' => ['AuthController', 'register'],
            'logout' => ['AuthController', 'logout'],
            'portal' => ['PortalController', 'index'],
            'portal/create' => ['PortalController', 'create'],
            'home' => ['HomeController', 'index'],
            'home/filters' => ['HomeController', 'filters'],
        ];

        $routeKey = implode('/', array_slice($segments, 0, 2));
        if (isset($map[$routeKey])) {
            [$controllerClass, $action] = $map[$routeKey];
        } else {
            $controllerClass = ucfirst($controllerName) . 'Controller';
        }

        $controllerFile = __DIR__ . '/../controllers/' . $controllerClass . '.php';

        if (!is_file($controllerFile)) {
            http_response_code(404);
            echo 'Página não encontrada';
            return;
        }

        require_once $controllerFile;
        $controller = new $controllerClass();
        if (!method_exists($controller, $action)) {
            http_response_code(404);
            echo 'Ação não encontrada';
            return;
        }
        $controller->$action();
    }
}
