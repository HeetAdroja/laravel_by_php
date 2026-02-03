<?php
require_once __DIR__ . "/../vendor/autoload.php";

use Faker\Factory;
use Database\Factories\Productfactory;
use Database\Seeders\productseeder;

class seeder
{
    protected $conn;
    protected $prseed;
    protected $prfacker;
    protected $faker;


    public function connect()
    {
        $this->conn = new \PDO(
            "mysql:host=localhost;dbname=laravel_By_php;charset=utf8mb4",
            "root",
            "",
        );
        $this->faker = Factory::create('en_US');
    }
    public function run($runone)
    {
        $basdir = __DIR__ . "/../Database/seeders";

        if ($runone == null) {
            $files = glob($basdir . '/*.php');
            if (!$files) {
                echo "no file for seeding";
            }
            foreach ($files as $file) {
                $filen = basename($file, '.php');

                require_once $file;

                $class = "Database\\seeders\\$filen";
                if (!$class) {
                    echo "class does not exist";
                }
                (new $class())->run($this->conn, $this->faker);
            }
        } else {
            $file = $basdir . '/' . $runone . '.php';
            $filen = basename($file, '.php');

            require_once $file;

            $class = "Database\\seeders\\$filen";
            if (!$class) {
                echo "class does not exist";
            }
            (new $class())->run($this->conn, $this->faker);
        }
    }
}

$seed = new seeder();
$seed->connect();

if (isset($argv[1])) {
    $seed->run($argv[1]);
} else {
    $seed->run($runone = null);
    echo "data add successfully";
}
