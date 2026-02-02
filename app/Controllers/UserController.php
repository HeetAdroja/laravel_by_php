<?php

namespace App\Controllers;

use App\Models\User;
use Config\Container;


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
            session_start();
            $_SESSION['user'] = $_POST['name'];
            $_SESSION['email'] = $_POST['email'];
            $passsword_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);


            if ($this->db) {
                $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    ':name' => $_POST['name'],
                    ':email' => $_POST['email'],
                    ':password' => $passsword_hash
                ]);
            }

            echo $_SESSION['user'] . " logged in successfully.";
        }
    }
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = $this->user->fetchUser($email);
            $dbpassword = $user['password'];
            $role = $user['role'];

            if (password_verify($password, $dbpassword)) {

                if ($role === 'admin') {
                    require_once __DIR__ . "/../../Resources/Views/Admindashboard.php";
                } else {
                    require_once __DIR__ . "/../../Resources/Views/Userdashboard.php";
                }
            } else {
                echo "password email incorrect";
            }
        }
    }
}
