<?php

namespace Core;

use Core\Middleware\Middleware;

class Router
{

    protected $routes = [];

    public function only($key)
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;
        return $this;
    }

    public function get($uri, $controller, $action = "")
    {
        return $this->add('GET', $uri, $controller, $action);
    }

    public function add($method, $uri, $controller, $action = "")
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'action' => $action,
            'method' => $method,
            'middleware' => null,
        ];

        return $this;
    }

    public function post($uri, $controller, $action = "")
    {
        return $this->add('POST', $uri, $controller, $action);
    }

    public function delete($uri, $controller, $action = "")
    {
        return $this->add('DELETE', $uri, $controller, $action);
    }

    public function patch($uri, $controller, $action = "")
    {
        return $this->add('PATCH', $uri, $controller, $action);
    }

    public function put($uri, $controller, $action = "")
    {
        return $this->add('PUT', $uri, $controller, $action);
    }

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {

            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
                Middleware::resolve($route['middleware']);

                if (class_exists($route['controller'])) {
                    $controller = new $route['controller'];
                    if(method_exists($controller, $route['action'])) {
                        return $controller->{$route['action']}();
                    }
                    throw new Exception("Method '{$route['action']}' not found in controller '{$route['controller']}'");
                }
//                return require base_path('Http/controllers' . $route['controller']);
            }
        }
        $this->abort();
    }

    protected function abort($code = 404)
    {
        http_response_code($code);

        require base_path("views/{$code}.php");

        die();
    }

    public function previousUrl()
    {
        return $_SERVER['HTTP_REFERER'];
    }

}
