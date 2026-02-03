<?php

namespace App\Controllers;

use App\Models\User;
use Config\Container;
use Config\mailer;


class UserController
{
    protected $db;
    protected $container;
    protected $user;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->user = new User($this->container);
    }

    public function index()
    {
        include __DIR__ . '/../../Resources/Views/home.php';
    }

    public function showRegisterForm()
    {
        include __DIR__ . '/../../Resources/Views/register.php';
    }

    public function showLoginForm()
    {
        include __DIR__ . '/../../Resources/Views/login.php';
    }

    public function Register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $_SESSION['user'] = $_POST['name'];
            $_SESSION['email'] = $_POST['email'];
            $passsword_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $token = $this->generate_secure_token(32);
            if ($this->user->storeUser($_POST['name'], $_POST['email'], $passsword_hash, $token)) {
                require_once __DIR__ . "/../../Resources/Views/Userdashboard.php";
            } else {
                echo $_SESSION['user'] . " not register successfully.";
            }
        }
    }
    function generate_secure_token($length = 32)
    {
        $bytes = random_bytes($length / 2);
        return bin2hex($bytes);
    }
    public function login()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $email = $_POST['email'];
            $_SESSION['email'] = $_POST['email'];
            $password = $_POST['password'];
            $user = $this->user->fetchUser($email);
            $dbpassword = $user['password'];
            $role = $user['role'];

            if (password_verify($password, $dbpassword)) {
                if ($role === 'admin') {
                    require_once __DIR__ . "/../../Resources/Views/Admindashboard.php";
                } else {
                    echo $_SESSION['email'];
                    require_once __DIR__ . "/../../Resources/Views/Userdashboard.php";
                }
            } else {
                echo "password email incorrect";
            }
        }
    }
}
