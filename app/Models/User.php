<?php

namespace App\Models;

use PDO;

class User
{
    protected $db;
    public function __construct($container)
    {
        if ($container) {
            $this->db = $container->make('db');
        }
    }

    public function fetchUser($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    public function storeUser($name, $email, $password, $token)
    {
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $password
        ]);
        $sql = "INSERT INTO varifications (email,token) VALUES (:email ,:token)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':token' => $token
        ]);
        return true;
    }
}
