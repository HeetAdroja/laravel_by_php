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
}
