// TicketService.php

class TicketService {
    public function getTicket($ticketId) {
        // Fetch ticket details from database
    }
    
    public function purchaseTicket($ticketData) {
        // Handle ticket purchase logic
    }
}

class Ticket {
    // Ticket attributes and methods
}





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

// Factory Method for creating tickets
class TicketFactory {
    public static function createTicket($name, $price, $status, $description) {
        return new Ticket($name, $price, $status, $description);
    }
}

// Ticket class
class Ticket {
    private $name;
    private $price;
    private $status;
    private $description;

    public function __construct($name, $price, $status, $description) {
        $this->name = $name;
        $this->price = $price;
        $this->status = $status;
        $this->description = $description;
    }

    public function save() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO tickets (name, price, status, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdsb", $this->name, $this->price, $this->status, $this->description);
        $stmt->execute();
        $stmt->close();
    }
}
?>
<?php

class Ticket {
    public $t_id;
    public $t_name;
    public $t_price;
    public $t_status;
    public $t_description;

    public function getName() { /* ... */ }
    public function getPrice() { /* ... */ }
    public function getStatus() { /* ... */ }
    public function setStatus($status) { /* ... */ }
    public function getDescription() { /* ... */ }
}
?>



class TicketService {
    async createTicket(data) {
        // API call to Ticket Service
    }
    // Other methods...
}
class TicketService {
    public function createTicket($name, $price, $status, $description) {
        // Implementation using Factory Pattern
    }
    // Other methods...
}

