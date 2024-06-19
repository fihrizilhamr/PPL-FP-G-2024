<?php
require '../DatabaseService/db.php';

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
        echo "Customer data has been updated: " . json_encode($data) . "\n";
    }
}

class TicketObserver implements Observer {
    public function update($data) {
        echo "Ticket data has been updated: " . json_encode($data) . "\n";
    }
}

class CartObserver implements Observer {
    public function update($data) {
        echo "Cart data has been updated: " . json_encode($data) . "\n";
    }
}

class ReviewObserver implements Observer {
    public function update($data) {
        echo "Review data has been updated: " . json_encode($data) . "\n";
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

    public function editProfile($username, $password, $email, $name, $birthdate, $gender, $phonenumber) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE registered_customer SET password = ?, email = ?, name = ?, birthdate = ?, gender = ?, phonenumber = ? WHERE username = ? AND password = ?");
        $stmt->bind_param("ssssssss", $password, $email, $name, $birthdate, $gender, $phonenumber, $username, $password);
        $stmt->execute();
        $stmt->close();

        $this->notify(['action' => 'editProfile', 'username' => $username]);
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
        $stmt = $db->prepare("INSERT INTO cart (c_ticketid, c_userid, c_ticketamount, c_datetime) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siis", $ticket_id, $user_id, $amount, $datetime);
        $stmt->execute();
        $stmt->close();

        $this->notify(['action' => 'addTicketToCart', 'ticket_id' => $ticket_id, 'user_id' => $user_id]);
    }

    public function deleteTicketFromCart($purchase_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM cart WHERE c_id = ?");
        $stmt->bind_param("i", $purchase_id);
        $stmt->execute();
        $stmt->close();

        $this->notify(['action' => 'deleteTicketFromCart', 'purchase_id' => $purchase_id]);
    }

    public function editTicketInCart($purchase_id, $ticket_id, $amount, $datetime) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE cart SET c_ticketid = ?, c_ticketamount = ?, c_datetime = ? WHERE c_id = ?");
        $stmt->bind_param("iisi", $ticket_id, $amount, $datetime, $purchase_id);
        $stmt->execute();
        $stmt->close();

        $this->notify(['action' => 'editTicketInCart', 'purchase_id' => $purchase_id, 'ticket_id' => $ticket_id]);
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

    public function viewReview($review_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM review WHERE id = ?");
        $stmt->bind_param("i", $review_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $review = $result->fetch_assoc();
        $stmt->close();
        
        $this->notify(['action' => 'viewReview', 'review' => $review]);
        return $review;
    }

    public function editReview($review_id, $rating, $description, $image_path, $datetime) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE review SET rating = ?, description = ?, image_path = ?, datetime = ? WHERE id = ?");
        $stmt->bind_param("isssi", $rating, $description, $image_path, $datetime, $review_id);
        $stmt->execute();
        $stmt->close();

        $this->notify(['action' => 'editReview', 'review_id' => $review_id]);
    }
}
?>
