<?php

namespace Config;

// use Database\Database;

class Migrate
{
    protected $conn;

    public function run()
    {
        $db= new \Database\Database();
;
        $this->conn = $db->connect();
 
        $baseDir = __DIR__ . '/../../Database/Migration'; 
        $migrated = [];

        $stmt = $this->conn->query("SELECT migration_table FROM migrations");
        while ($row = $stmt->fetch()) {
            $migrated[] = $row['migration_table'];
        }

      
        $allMigrations = glob($baseDir . '/*.php');
        sort($allMigrations);

        foreach ($allMigrations as $file) {
            $filename = basename($file, '.php'); 

            if (!in_array($filename, $migrated)) {
                require_once $file;

                
                $className = 'Database\Migration\\' . $filename; 

                if (class_exists($className)) {
                    $migrationInstance = new $className();
                    $migrationInstance->up($this->conn);

                    $stmt = $this->conn->prepare("INSERT INTO migrations (migration_table) VALUES (?)");
                    $stmt->execute([$filename]);
                    echo "Migration $filename created successfully.\n";
                } else {
                    echo "Migration class $className not found.\n";
                }
            } else {
                echo "No new migration for $filename.\n";
            }
        }
    }
}

$migrate = new Migrate();
$migrate->run();
