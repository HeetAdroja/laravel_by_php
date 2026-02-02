<?php

namespace Config;

use Config\Container;

class Router
{
    protected array $routes = [];
    protected $container;

    public function __construct( $container)
    {
        $this->container = $container;
    }

    public function any($uri, $action, $middleware = [])
    {    
        $this->routes[$_SERVER['REQUEST_METHOD']][$uri] = compact('action', 'middleware');
    }

    public function render(Request $request)
    {
        $method = $request->method();
        $uri = $request->uri();

        if (!isset($this->routes[$method][$uri])) {
            die('404 Page Not Found');
        }

        $route = $this->routes[$method][$uri];

        $this->runMiddleware($route['middleware']);

        [$controller, $method] = $route['action'];
        call_user_func([new $controller($this->container), $method]);
    }

    protected function runMiddleware(array $middleware)
    {
        foreach ($middleware as $mid) {
            (new $mid)->handle();
        }
    }
}
