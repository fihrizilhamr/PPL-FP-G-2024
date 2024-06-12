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
        return new RegisteredCustomerService($username, $password, $email, $name, $birthdate, $gender, $phonenumber);
    }
}

// Observer interface
interface Observer {
    public function update($data);
}

// Subject class
abstract class Subject {
    private $observers = [];

    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer) {
        $this->observers = array_filter($this->observers, function($o) use ($observer) {
            return $o !== $observer;
        });
    }

    protected function notify($data) {
        foreach ($this->observers as $observer) {
            $observer->update($data);
        }
    }
}

// Concrete Observer
class CustomerObserver implements Observer {
    public function update($data) {
        // Implement logic for what happens when a customer is updated
        echo "Customer data has been updated: " . json_encode($data) . "\n";
    }
}

class TicketObserver implements Observer {
    public function update($data) {
        // Implement logic for what happens when a customer is updated
        echo "Ticket data has been updated: " . json_encode($data) . "\n";
    }
}

class CartObserver implements Observer {
    public function update($data) {
        // Implement logic for what happens when a customer is updated
        echo "Ticket data has been updated: " . json_encode($data) . "\n";
    }
}

class ReviewObserver implements Observer {
    public function update($data) {
        // Implement logic for what happens when a customer is updated
        echo "Ticket data has been updated: " . json_encode($data) . "\n";
    }
}

// RegisteredCustomer class
class RegisteredCustomerService extends Subject {
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

        $this->notify(['action' => 'save', 'username' => $this->username]);
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

}
class TicketService extends Subject {
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
}

class CartService extends Subject {
    public function addTicketToCart($ticket_id, $user_id, $amount, $datetime) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO ticket_purchase (ticket_id, user_id, ticket_amount, datetime) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siis", $ticket_id, $user_id, $amount, $datetime);
        $stmt->execute();
        $stmt->close();

        $this->notify(['action' => 'addTicketToCart', 'ticket_id' => $ticket_id, 'user_id' => $user_id]);
    }

    public function deleteTicketFromCart($purchase_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM ticket_purchase WHERE id = ?");
        $stmt->bind_param("i", $purchase_id);
        $stmt->execute();
        $stmt->close();

        $this->notify(['action' => 'deleteTicketFromCart', 'purchase_id' => $purchase_id]);
    }
}
class ReviewService extends Subject {
    public function makeReview($dest_id, $user_id, $rating, $description, $image_path, $datetime) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO review (destination_id, user_id, rating, description, image_path, datetime) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siisss", $dest_id, $user_id, $rating, $description, $image_path, $datetime);
        $stmt->execute();
        $stmt->close();

        $this->notify(['action' => 'makeReview', 'dest_id' => $dest_id, 'user_id' => $user_id]);
    }

    public function removeReview($review_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM review WHERE id = ?");
        $stmt->bind_param("i", $review_id);
        $stmt->execute();
        $stmt->close();

        $this->notify(['action' => 'removeReview', 'review_id' => $review_id]);
    }
}
?>
