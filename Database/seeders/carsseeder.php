<?php

namespace Database\Seeders;

use Database\Factories\Carsfactory;

class carsseeder
{

    public function add($conn, $name, $brand)
    {
        $sql = "INSERT INTO cars (name,brand) VALUES (?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $brand]);
    }
    public function run($conn, $faker)
    {
        $this->add($conn, "BMWQ7", "BMW");
        for ($i = 1; $i <= 10; $i++) {
            $data = (new Carsfactory())->fakeproduct($faker);
            $this->add($conn, $data['name'], $data['brand']);
        }
    }
}
