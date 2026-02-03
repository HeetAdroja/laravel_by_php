<?php

namespace Database\Migration;

class Create_Car_Table
{
    public function up($conn)
    {

        $sql = "CREATE TABLE IF NOT EXISTS cars (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            brand VARCHAR(100) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $conn->exec($sql);
    }

    public function down($conn)
    {
        $sql = "DROP TABLE IF EXISTS cars;";
        $conn->exec($sql);
    }
}
