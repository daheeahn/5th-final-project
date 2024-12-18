<?php

class DatabaseConnection {
    private static $instance = null; // Singleton instance
    private $pdo;

    private function __construct() {
        $this->pdo = new \PDO("mysql:host=localhost;dbname=lecture_platform_db", "tamwood", "1234");
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance->getConnection();
    }

    public function getConnection() {
        return $this->pdo;
    }
}

?>