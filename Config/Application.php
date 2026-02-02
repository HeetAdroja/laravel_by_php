<?php

namespace Config;

use Config\Router;
use Config\Container;
use Config\Request;
use App\Providers\databaseServiceProvider;
use App\Controllers\HomeController;
use App\Middleware\AuthMiddleware;
use Dotenv\Dotenv;

class Application
{

    protected $router;
    protected $container;

    public function __construct()
    {

        $this->container = new Container();
        $this->router = new Router($this->container);

        $provider = new databaseServiceProvider();
        $provider->register($this->container);
    }
    public function run()
    {
        $request = new Request();

        global $router;

        $router = $this->router;

        require '../routes/web.php';

        $this->router->render($request);
    }
}
