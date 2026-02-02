<?php

namespace App\Controllers;

use Config\Container;

class UserController
{
    protected $db;
    protected $container;


    public function __construct(Container $container)
    {
        $this->container = $container;
        if ($this->container) {
            $this->db = $this->container->make('db');
        }
    }

    public function index()
    {
        include __DIR__ . '/../../Resources/Views/home.php';
    }

    public function showRegisterForm()
    {
        include __DIR__ . '/../../Resources/Views/register.php';
    }

    public function Register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $_SESSION['user'] = $_POST['name'];
            $_SESSION['email'] = $_POST['email'];
            $passsword_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Use the injected database connection
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

}
