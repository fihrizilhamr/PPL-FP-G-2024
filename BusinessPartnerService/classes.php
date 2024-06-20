<?php
require '../DatabaseService/db.php';

class BusinessPartnerFactory {
    public static function createBusinessPartner($username, $password, $email, $name, $phonenumber) {
        return new BusinessPartnerService($username, $password, $email, $name, $phonenumber);
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

// Concrete Observer for Business Partner
class BusinessPartnerObserver implements Observer {
    public function update($data) {
        echo "Business Partner data has been updated: " . json_encode($data) . "\n";
    }
}

// BusinessPartnerService class
class BusinessPartnerService extends Subject {
    private $username;
    private $password;
    private $email;
    private $name;
    private $phonenumber;

    public function __construct($username, $password, $email, $name, $phonenumber) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->name = $name;
        $this->phonenumber = $phonenumber;
    }

    public function save() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO business_partner (bp_username, bp_password, bp_email, bp_name, bp_phonenumber) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $this->username, $this->password, $this->email, $this->name, $this->phonenumber);
        $stmt->execute();
        $stmt->close();

        $this->notify(['action' => 'save', 'username' => $this->username]);
    }

    public function login($username, $password) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM business_partner WHERE bp_username = ? AND bp_password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows > 0;
    }

    public function editProfile($username, $password, $email, $name, $phonenumber) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE business_partner SET bp_password = ?, bp_email = ?, bp_name = ?, bp_phonenumber = ? WHERE bp_username = ? AND bp_password = ?");
        $stmt->bind_param("ssssss", $password, $email, $name, $phonenumber, $username, $password);
        $stmt->execute();
        $stmt->close();

        $this->notify(['action' => 'editProfile', 'username' => $username]);
    }

    public function getUserId($username) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT bp_id FROM business_partner WHERE bp_username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user['bp_id'];
    }
}


