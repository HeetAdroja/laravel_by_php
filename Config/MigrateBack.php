<?php

class MigrateBack
{
    private $conn;

    public function connect(): void
    {
        $this->conn = new PDO(
            "mysql:host=localhost;dbname=laravel_By_php;charset=utf8mb4",
            "root",
            "",
        );
    }

    public function run(): void
    {
        $stmt = $this->conn->query("SELECT migration_table FROM migrations");
        $migrated = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $baseDir = __DIR__ . '/../Database/Migration';
        $files = glob($baseDir . '/*.php');

        if (!$files) {
            die("No migration files found");
        }

        foreach ($files as $file) {
            $filename = basename($file, '.php');

            if (in_array($filename, $migrated)) {
                echo "Skipped: $filename";
                continue;
            } else {
                require_once $file;

                $class = "Database\\Migration\\$filename";
                if (!class_exists($class)) {
                    die("Class not found: $class");
                }

                $this->conn->beginTransaction();
                (new $class())->up($this->conn);
                $stmt = $this->conn->prepare("INSERT INTO migrations (migration_table) VALUES (?)");
                $stmt->execute([$filename]);

                echo "Migrated: $filename" ;
            }
        }
    }
}

$migrate = new MigrateBack();
$migrate->connect();
$migrate->run();
