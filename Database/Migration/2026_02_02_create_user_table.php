<?php

namespace Database\Migration;

class CreateUserTable
{
    public function up($conn)
    {

        $sql = "CREATE TABLE IF NOT EXISTS user (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $conn->exec($sql);
    }

    public function down($conn)
    {
        $sql = "DROP TABLE IF EXISTS user;";
        $conn->exec($sql);
    }
}
