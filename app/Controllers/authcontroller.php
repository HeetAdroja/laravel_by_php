<?php

namespace App\Controllers;

class authcontroller
{
    public function login()
    {
        echo "This is the login page.";
    }
}
$auth = new authcontroller();
$auth->login();
