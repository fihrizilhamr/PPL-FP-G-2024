<?php

class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $this->connection = new mysqli('localhost', 'user', 'password', 'database');
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

class Payment {
    public $pm_id;
    public $pm_datetime;
    public $pm_totalprice;

    public function __construct($id, $datetime, $totalprice) {
        $this->pm_id = $id;
        $this->pm_datetime = $datetime;
        $this->pm_totalprice = $totalprice;
    }
}

class PaymentService {
    private $connection;

    public function __construct() {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function createPayment($datetime, $totalPrice) {
        $id = uniqid();
        $stmt = $this->connection->prepare("INSERT INTO payments (pm_id, pm_datetime, pm_totalprice) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $id, $datetime, $totalPrice);
        if ($stmt->execute()) {
            return new Payment($id, $datetime, $totalPrice);
        } else {
            throw new Exception("Failed to create payment");
        }
    }

    public function getPayment($id) {
        $stmt = $this->connection->prepare("SELECT * FROM payments WHERE pm_id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $payment = $result->fetch_assoc();
            return new Payment($payment['pm_id'], $payment['pm_datetime'], $payment['pm_totalprice']);
        } else {
            throw new Exception("Payment not found");
        }
    }

    public function updatePayment($id, $datetime, $totalPrice) {
        $stmt = $this->connection->prepare("UPDATE payments SET pm_datetime = ?, pm_totalprice = ? WHERE pm_id = ?");
        $stmt->bind_param("sds", $datetime, $totalPrice, $id);
        if ($stmt->execute()) {
            return $this->getPayment($id);
        } else {
            throw new Exception("Failed to update payment");
        }
    }

    public function deletePayment($id) {
        $stmt = $this->connection->prepare("DELETE FROM payments WHERE pm_id = ?");
        $stmt->bind_param("s", $id);
        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("Failed to delete payment");
        }
    }

    public function getAllPayments() {
        $result = $this->connection->query("SELECT * FROM payments");
        $payments = [];
        while ($row = $result->fetch_assoc()) {
            $payments[] = new Payment($row['pm_id'], $row['pm_datetime'], $row['pm_totalprice']);
        }
        return $payments;
    }
}

class TicketPurchase {
    public $id;
    public $ticket_id;
    public $user_id;
    public $ticket_amount;
    public $datetime;

    public function __construct($id, $ticket_id, $user_id, $ticket_amount, $datetime) {
        $this->id = $id;
        $this->ticket_id = $ticket_id;
        $this->user_id = $user_id;
        $this->ticket_amount = $ticket_amount;
        $this->datetime = $datetime;
    }
}

class TicketPurchaseService {
    private $connection;

    public function __construct() {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function createPurchase($ticket_id, $user_id, $ticket_amount, $datetime) {
        $stmt = $this->connection->prepare("INSERT INTO ticket_purchase (ticket_id, user_id, ticket_amount, datetime) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $ticket_id, $user_id, $ticket_amount, $datetime);
        if ($stmt->execute()) {
            $id = $stmt->insert_id;
            return new TicketPurchase($id, $ticket_id, $user_id, $ticket_amount, $datetime);
        } else {
            throw new Exception("Failed to create ticket purchase");
        }
    }

    public function getPurchase($id) {
        $stmt = $this->connection->prepare("SELECT * FROM ticket_purchase WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $purchase = $result->fetch_assoc();
            return new TicketPurchase($purchase['id'], $purchase['ticket_id'], $purchase['user_id'], $purchase['ticket_amount'], $purchase['datetime']);
        } else {
            throw new Exception("Ticket purchase not found");
        }
    }

    public function updatePurchase($id, $ticket_id, $user_id, $ticket_amount, $datetime) {
        $stmt = $this->connection->prepare("UPDATE ticket_purchase SET ticket_id = ?, user_id = ?, ticket_amount = ?, datetime = ? WHERE id = ?");
        $stmt->bind_param("iiisi", $ticket_id, $user_id, $ticket_amount, $datetime, $id);
        if ($stmt->execute()) {
            return $this->getPurchase($id);
        } else {
            throw new Exception("Failed to update ticket purchase");
        }
    }

    public function deletePurchase($id) {
        $stmt = $this->connection->prepare("DELETE FROM ticket_purchase WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("Failed to delete ticket purchase");
        }
    }

    public function getAllPurchases() {
        $result = $this->connection->query("SELECT * FROM ticket_purchase");
        $purchases = [];
        while ($row = $result->fetch_assoc()) {
            $purchases[] = new TicketPurchase($row['id'], $row['ticket_id'], $row['user_id'], $row['ticket_amount'], $row['datetime']);
        }
        return $purchases;
    }
}

?>
