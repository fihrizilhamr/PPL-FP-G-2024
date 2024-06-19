<?php
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $hostname = "blvf95dkmybpm8s1nymz-mysql.services.clever-cloud.com";
        $database = "blvf95dkmybpm8s1nymz";
        $username = "uzlllwhy5esuidlb";
        $password = "AyrN643IyXluK9TffnNn";
        $port = 3306; 

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
