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

// Payment class
class Payment {
    private $id;
    private $datetime;
    private $totalprice;
    private $paymentMethod;

    public function __construct($id, $datetime, $totalprice, $paymentMethod) {
        $this->id = $id;
        $this->datetime = $datetime;
        $this->totalprice = $totalprice;
        $this->paymentMethod = $paymentMethod;
    }

    public function save() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO payments (id, datetime, totalprice) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $this->id, $this->datetime, $this->totalprice);
        $stmt->execute();
        $stmt->close();
    }

    public function update() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE payments SET datetime = ?, totalprice = ? WHERE id = ?");
        $stmt->bind_param("sss", $this->datetime, $this->totalprice, $this->id);
        $stmt->execute();
        $stmt->close();
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setDatetime($datetime) {
        $this->datetime = $datetime;
    }

    public function getDatetime() {
        return $this->datetime;
    }

    public function setTotalprice($totalprice) {
        $this->totalprice = $totalprice;
    }

    public function getTotalprice() {
        return $this->totalprice;
    }

    public function makePayment() {
        if (empty($this->id) || empty($this->datetime) || empty($this->totalprice)) {
            throw new Exception("Invalid payment details");
        }

        $paymentSuccessful = $this->paymentMethod->processPayment($this->totalprice);

        if ($paymentSuccessful) {
            $this->save();
            echo "Payment made successfully and saved to the database.\n";
        } else {
            echo "Payment failed.\n";
        }
    }

    public function confirmPayment() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE payments SET status = 'confirmed' WHERE id = ?");
        $stmt->bind_param("s", $this->id);
        $stmt->execute();
        $stmt->close();

        echo "Payment with ID: {$this->id} has been confirmed.\n";
    }
}

interface PaymentMethod {
    public function processPayment($amount);
}

class CreditCardPayment implements PaymentMethod {
    public function processPayment($amount) {
        // Simulate credit card payment processing
        echo "Processing credit card payment of $amount.\n";
        return true;
    }
}

class PayPalPayment implements PaymentMethod {
    public function processPayment($amount) {
        // Simulate PayPal payment processing
        echo "Processing PayPal payment of $amount.\n";
        return true;
    }
}

// PaymentFactory
class PaymentFactory {
    public static function createPayment($id, $datetime, $totalprice) {
        return new Payment($id, $datetime, $totalprice);
    }
}

class PaymentService {

    public function createPayment($id, $datetime, $totalprice) {
        $payment = PaymentFactory::createPayment($id, $datetime, $totalprice);
        $payment->save();
        return $payment;
    }

    public function getPaymentById($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM payments WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $paymentMethod = $this->getPaymentMethod($row['payment_method']);
            return new Payment(
                $row['id'], 
                $row['datetime'], 
                $row['totalprice'], 
                $paymentMethod);
        }

        return null;
    }

    private function getPaymentMethod($method) {
        switch ($method) {
            case 'credit_card':
                return new CreditCardPayment();
            case 'paypal':
                return new PayPalPayment();
            default:
                throw new Exception("Invalid payment method");
        }
    }

    public function getAllPayments() {
        $payments = [];
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM payments");
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $payment = new Payment(
                $row['id'],
                $row['datetime'],
                $row['totalprice']
            );

            $payments[] = $payment;
        }

        return $payments;
    }

    public function updatePayment(Payment $payment) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE payments SET datetime = ?, totalprice = ? WHERE id = ?");
        $stmt->bind_param("sss", $payment->getDatetime(), $payment->getTotalprice(), $payment->getId());
        $stmt->execute();
        $stmt->close();
    }

    public function deletePayment(Payment $payment) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM payments WHERE id = ?");
        $stmt->bind_param("s", $payment->getId());
        $stmt->execute();
        $stmt->close();
    }
}

?>