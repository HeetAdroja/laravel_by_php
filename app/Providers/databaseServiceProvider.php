<?php

namespace App\Providers;

use Database\Database;

class databaseServiceProvider
{

    public function register($container)
    {
        $container->singleton('db', function () {
            $database = new Database();
            return $database->connect();
        });
    }

    public function boot() {}
}
