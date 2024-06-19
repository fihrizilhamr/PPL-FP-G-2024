// UserService.php
<?php
// Singleton pattern for database connection
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $this->connection = new mysqli('localhost', 'user', 'password', 'database');
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

    public function searchTicket($name) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM ticket WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $tickets = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $tickets;
    }

    public function addTicketToCart($tic_id, $user_id, $amount, $datetime) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO ticket_purchase (ticket_id, user_id, ticket_amount, datetime) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $tic_id, $user_id, $amount, $datetime);
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

    public function removeReview($rev_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM review WHERE id = ?");
        $stmt->bind_param("i", $rev_id);
        $stmt->execute();
        $stmt->close();
    }
}
?>

<!-- class UserService {
    private static $instance = null;
    
    private function __construct() { }
    
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new UserService();
        }
        return self::$instance;
    }
    
    public function createUser($type, $data) {
        if ($type == 'customer') {
            return new RegisteredCustomer($data);
        } elseif ($type == 'partner') {
            return new BusinessPartner($data);
        }
    }
}

class RegisteredCustomer {
    // Implementation of RegisteredCustomer attributes and methods
}

class BusinessPartner {
    // Implementation of BusinessPartner attributes and methods
} -->


<!-- //          Destination ID: A reference to the destination being reviewed.
// User ID: The ID of the user who wrote the review.
// Rating: A numerical rating (e.g., on a scale of 1 to 5) indicating the user's overall satisfaction with the destination.
// Title: A title for the review, summarizing its content.
// Content/Description: The main body of the review, where the user can provide detailed feedback, opinions, and experiences about the destination.
// Date: T -->
    

<!-- class RegisteredCustomer {
    public $rc_id;
    public $rc_username;
    public $rc_password;
    public $rc_email;
    public $rc_name;
    public $rc_birthdate;
    public $rc_gender;
    public $rc_phonenumber;

    public function login() { /* ... */ }
    public function searchTicket() { /* ... */ }
    public function addTicketToCart() { /* ... */ }
    public function deleteTicketFromCart() { /* ... */ }
    public function makePurchase() { /* ... */ }
    public function confirmPayment() { /* ... */ }
    public function cancelPurchase() { /* ... */ }
    public function makeReview() { /* ... */ }
    public function removeReview() { /* ... */ }
}
class UserService {
    async createUser(data) {
        // API call to User Service
    }
    async login(data) {
        // API call to User Service
    }
    // Other methods...
}
class UserService {
    public function createUser($username, $password, $email, $name, $birthdate, $gender, $phonenumber) {
        // Implementation using Factory Pattern
    }
    public function login($username, $password) {
        // Implementation
    }
    // Other methods...
} -->
