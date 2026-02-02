<?php

namespace Database\Migration;

class Create_product_Table
{
    public function up($conn)
    {

        $sql = "CREATE TABLE IF NOT EXISTS product (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $conn->exec($sql);
    }

    public function down($conn)
    {
        $sql = "DROP TABLE IF EXISTS product;";
        $conn->exec($sql);
    }
}
