<?php

namespace App\Models;

use PDO;

class Mail
{
    protected $db;
    public function __construct($container)
    {
        if ($container) {
            $this->db = $container->make('db');
        }
    }
    public function makeurl()
    {
        $sql = "SELECT token FROM varifications WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($_SESSION['email']);
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }
}
