<?php
// Singleton pattern for database connection
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $this->connection = new mysqli('localhost', 'root', '', 'travel_booking');
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

// Factory Method for creating registered customers
class RegisteredCustomerFactory {
    public static function createRegisteredCustomer($username, $password, $email, $name, $birthdate, $gender, $phonenumber) {
        return new RegisteredCustomer($username, $password, $email, $name, $birthdate, $gender, $phonenumber);
    }
}

// RegisteredCustomer class
class RegisteredCustomer {
    private $username;
    private $password;
    private $email;
    private $name;
    private $birthdate;
    private $gender;
    private $phonenumber;

    public function __construct($username, $password, $email, $name, $birthdate, $gender, $phonenumber) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->name = $name;
        $this->birthdate = $birthdate;
        $this->gender = $gender;
        $this->phonenumber = $phonenumber;
    }

    public function save() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO registered_customer (username, password, email, name, birthdate, gender, phonenumber) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $this->username, $this->password, $this->email, $this->name, $this->birthdate, $this->gender, $this->phonenumber);
        $stmt->execute();
        $stmt->close();
    }

    public function login($username, $password) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM registered_customer WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows > 0;
    }

    public function searchTicket($substring) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM ticket WHERE name LIKE ? OR description LIKE ?");
        $searchTerm = '%' . $substring . '%';
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        $tickets = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $tickets;
    }
    
    

    public function addTicketToCart($ticket_id, $user_id, $amount, $datetime) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO ticket_purchase (ticket_id, user_id, ticket_amount, datetime) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siis", $ticket_id, $user_id, $amount, $datetime);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteTicketFromCart($purchase_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM ticket_purchase WHERE id = ?");
        $stmt->bind_param("i", $purchase_id);
        $stmt->execute();
        $stmt->close();
    }

    public function makeReview($dest_id, $user_id, $rating, $title, $description, $datetime) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO review (destination_id, user_id, rating, title, description, datetime) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siisss", $dest_id, $user_id, $rating, $title, $description, $datetime);
        $stmt->execute();
        $stmt->close();
    }

    public function removeReview($review_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM review WHERE id = ?");
        $stmt->bind_param("i", $review_id);
        $stmt->execute();
        $stmt->close();
    }
}
?>
