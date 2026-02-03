<?php
class Migrate
{
    private $conn;

    public function connect()
    {
        $this->conn = new \PDO(
            "mysql:host=localhost;dbname=laravel_By_php;charset=utf8mb4",
            "root",
            "",
        );
        return $this->conn;
    }
    public function run($migrateone): void
    {
        $stmt = $this->conn->query("SELECT migration_table FROM migrations");
        $migrated = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $baseDir = __DIR__ . '/../Database/Migration';

        if ($migrateone == null) {
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


                    (new $class())->up($this->conn);
                    $stmt = $this->conn->prepare("INSERT INTO migrations (migration_table) VALUES (?)");
                    $stmt->execute([$filename]);

                    echo "Migrated: $filename";
                }
            }
        } else {
            $file = $baseDir . '/' . $migrateone . '.php';
            $filename = basename($file, '.php');

            if (in_array($filename, $migrated)) {
                echo "Skipped: $filename";
            } else {
                require_once $file;

                $class = "Database\\Migration\\$filename";
                if (!class_exists($class)) {
                    die("Class not found: $class");
                }


                (new $class())->up($this->conn);
                $stmt = $this->conn->prepare("INSERT INTO migrations (migration_table) VALUES (?)");
                $stmt->execute([$filename]);

                echo "Migrated: $filename";
            }
        }
    }

    public function rollback($rollbackone): void
    {
        $baseDir = __DIR__ . '/../Database/Migration';
        if ($rollbackone == null) {
            $stmt = $this->conn->query("SELECT migration_table FROM migrations ORDER BY id DESC LIMIT 1");
            $lastMigration = $stmt->fetchColumn();

            if (!$lastMigration) {
                echo "No migrations to rollback.\n";
                return;
            }

            $file = $baseDir . '/' . $lastMigration . '.php';
            require_once $file;

            $class = "Database\\Migration\\$lastMigration";
            if (!class_exists($class)) {
                die("Class not found: $class\n");
            }

            (new $class())->down($this->conn);

            $stmt = $this->conn->prepare("DELETE FROM migrations WHERE migration_table = ?");
            $stmt->execute([$lastMigration]);
            echo "Rolled back: $lastMigration\n";
        } else {

            $stmt = $this->conn->prepare("SELECT migration_table FROM migrations WHERE migration_table = ?");
            $stmt->execute([$rollbackone]);
            $lastMigration = $stmt->fetch(PDO::FETCH_COLUMN);

            if (!$lastMigration) {
                echo "No migrations to rollback.\n";
                return;
            }

            $file = $baseDir . '/' . $lastMigration . '.php';
            require_once $file;

            $class = "Database\\Migration\\$lastMigration";
            if (!class_exists($class)) {
                die("Class not found: $class\n");
            }

            (new $class())->down($this->conn);

            $stmt = $this->conn->prepare("DELETE FROM migrations WHERE migration_table = ?");
            $stmt->execute([$lastMigration]);
            echo "Rolled back: $lastMigration\n";
        }
    }
}

$migrate = new Migrate();
$migrate->connect();

if ($argv[1] == 'rollback') {
    if (isset($argv[2])) {
        $migrate->rollback($argv[2]);
    } else {
        $migrate->rollback($rollbackone = null);
    }
} elseif ($argv[1] == "migrate") {
    if (isset($argv[2])) {
        $migrate->run($argv[2]);
    } else {
        $migrate->run($migrateone = null);
    }
}
