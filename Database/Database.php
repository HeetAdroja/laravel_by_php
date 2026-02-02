<?php

namespace Database;

class Database
{
    protected $host;
    protected $db;
    protected $db_password;
    protected $username;
    protected $conn;
    public function __construct()
    {
        $this->host = getenv('DB_HOST');
        $this->db = getenv('DB_DATABASE');
        $this->db_password = getenv('DB_PASSWORD');
        $this->username = getenv('DB_USERNAME');
    }
    public function connect()
    {
        $this->conn = new \PDO("mysql:host=$this->host;dbname=$this->db", $this->username, $this->db_password);
        return $this->conn;
    }
}
