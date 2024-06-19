<?php
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $hostname = "owd.h.filess.io";
        $database = "djalanin_mannerhorn";
        $username = "djalanin_mannerhorn";
        $password = "b3ec9ca5cd7dc0dd82dfce8af9918f6410dd2ccc";
        $port = "3307";

        $this->connection = new mysqli($hostname, $username, $password, $database, $port);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}
?>
