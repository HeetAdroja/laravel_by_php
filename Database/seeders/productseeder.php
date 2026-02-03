<?php

namespace Database\Seeders;

use Database\Factories\Productfactory;

class productseeder
{

    public function add($conn, $name, $time)
    {
        $sql = "INSERT INTO products (name ,created_at) VALUES (?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $time]);
    }
    public function run($conn, $faker)
    {
        $name = 'heet';
        $time = 'now()';
        $this->add($conn, $name, $time);

        for ($i = 1; $i <= 20; $i++) {
            $data = (new Productfactory())->fakeproduct($faker);
            $this->add($conn, $data['name'], $data['created_at']);
        }
    }
}
