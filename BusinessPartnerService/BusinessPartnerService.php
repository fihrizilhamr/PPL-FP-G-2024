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

// Factory Method for creating business partners
class BusinessPartnerFactory {
    public static function createBusinessPartner($username, $password, $email, $name, $phonenumber) {
        return new BusinessPartner($username, $password, $email, $name, $phonenumber);
    }
}

// Business Partner class
class BusinessPartner {
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
        $stmt = $db->prepare("INSERT INTO business_partners (username, password, email, name, phonenumber) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $this->username, $this->password, $this->email, $this->name, $this->phonenumber);
        $stmt->execute();
        $stmt->close();
    }
}

class BusinessPartner {
    public $bp_id;
    public $bp_username;
    public $bp_password;
    public $bp_email;
    public $bp_name;
    public $bp_phonenumber;


    public function BusinessLogin ($bp_username, $bp_password) {
        $this->bp_username = $bp_username;
        $this->bp_password = $bp_password;
    
    }
    public function addPartner ($bp_username, $bp_password, $bp_email, $bp_name, $bp_phonenumber) {
        $this->bp_username = $bp_username;
        $this->bp_password = $bp_password;
        $this->bp_email = $bp_email;
        $this->bp_name = $bp_name;
        $this->bp_phonenumber = $bp_phonenumber;
    }
    public function deletePartner ($bp_id, $bp_username, $bp_password, $bp_email, $bp_name, $bp_phonenumber) {
        $this->bp_id = $bp_id;
        $this->bp_username = $bp_username;
        $this->bp_password = $bp_password;
        $this->bp_email = $bp_email;
        $this->bp_name = $bp_name;
        $this->bp_phonenumber = $bp_phonenumber;
    }
    public function updatePartner ($bp_id, $bp_username, $bp_password, $bp_email, $bp_name, $bp_phonenumber) {
        $this->bp_id = $bp_id;
        $this->bp_username = $bp_username;
        $this->bp_password = $bp_password;
        $this->bp_email = $bp_email;
        $this->bp_name = $bp_name;
        $this->bp_phonenumber = $bp_phonenumber;
    }
    public function getPartner ($bp_id, $bp_username, $bp_password, $bp_email, $bp_name, $bp_phonenumber) {
        $this->bp_id = $bp_id;
        $this->bp_username = $bp_username;
        $this->bp_password = $bp_password;
        $this->bp_email = $bp_email;
        $this->bp_name = $bp_name;
        $this->bp_phonenumber = $bp_phonenumber;
    }
    public function getPartners () {
        $this->bp_id = $bp_id;
        $this->bp_username = $bp_username;
        $this->bp_password = $bp_password;
        $this->bp_email = $bp_email;
        $this->bp_name = $bp_name;
        $this->bp_phonenumber = $bp_phonenumber;
    }
    public function addTicket ($bp_id, $ticket_id) {
        $this->bp_id = $bp_id;
        $this->ticket_id = $ticket_id;
    }
    public function deleteTicket ($bp_id, $ticket_id) {
        $this->bp_id = $bp_id;
        $this->ticket_id = $ticket_id;
    }
    public function addDestination ($bp_id, $destination_id) {
        $this->bp_id = $bp_id;
        $this->destination_id = $destination_id;
    }
    public function deleteDestination ($bp_id, $destination_id) {
        $this->bp_id = $bp_id;
        $this->destination_id = $destination_id;
    }
    public function makePurchase ($bp_id, $purchase_id) {
        $this->bp_id = $bp_id;
        $this->purchase_id = $purchase_id;
    }
    public function confirmPayment ($bp_id, $purchase_id) {
        $this->bp_id = $bp_id;
        $this->purchase_id = $purchase_id;
    }
    public function cancelPurchase ($bp_id, $purchase_id) {
        $this->bp_id = $bp_id;
        $this->purchase_id = $purchase_id;
    }
    public function makeReview ($bp_id, $review_id) {
        $this->bp_id = $bp_id;
        $this->review_id = $review_id;
    }
    public function removeReview ($bp_id, $review_id) {
        $this->bp_id = $bp_id;
        $this->review_id = $review_id;
    }
 
 
}

class BusinessPartnerService {
    async addPartner(data) {
        const bp = BusinessPartnerFactory.createBusinessPartner(data.username, data.password, data.email, data.name, data.phonenumber);
        bp.save();
    }
    async deletePartner(bp_id) {
        const db = Database.getInstance().getConnection();
        const stmt = db.prepare("DELETE FROM business_partners WHERE bp_id = ?");
        stmt.bind_param("i", bp_id);
        stmt.execute();
        stmt.close();
    }
    async updatePartner(bp_id, data) {
        const db = Database.getInstance().getConnection();
        const stmt = db.prepare("UPDATE business_partners SET username = ?, password = ?, email = ?, name = ?, phonenumber = ? WHERE bp_id = ?");
        stmt.bind_param("sssssi", data.username, data.password, data.email, data.name, data.phonenumber, bp_id);
        stmt.execute();
        stmt.close();
    }
    async getPartner(bp_id) {
        const db = Database.getInstance().getConnection();
        const stmt = db.prepare("SELECT * FROM business_partners WHERE bp_id = ?");
        stmt.bind_param("i", bp_id);
        stmt.execute();
        const result = stmt.get_result();
        stmt.close();
        return result.fetch_assoc();
    }
    async addTicket(bp_id, ticket_id) {
        const db = Database.getInstance().getConnection();
        const stmt = db.prepare("INSERT INTO business_partner_tickets (bp_id, ticket_id) VALUES (?, ?)");
        stmt.bind_param("ii", bp_id, ticket_id);
        stmt.execute();
        stmt.close();
    }
    async deleteTicket(bp_id, ticket_id) {
        const db = Database.getInstance().getConnection();
        const stmt = db.prepare("DELETE FROM business_partner_tickets WHERE bp_id = ? AND ticket_id = ?");
        stmt.bind_param("ii", bp_id, ticket_id);
        stmt.execute();
        stmt.close();
    }
    async addDestination(bp_id, destination_id) {
        const db = Database.getInstance().getConnection();
        const stmt = db.prepare("INSERT INTO business_partner_destinations (bp_id, destination_id) VALUES (?, ?)");
        stmt.bind_param("ii", bp_id, destination_id);
        stmt.execute();
        stmt.close();
    }
    async deleteDestination(bp_id, destination_id) {
        const db = Database.getInstance().getConnection();
        const stmt = db.prepare("DELETE FROM business_partner_destinations WHERE bp_id = ? AND destination_id = ?");
        stmt.bind_param("ii", bp_id, destination_id);
        stmt.execute();
        stmt.close();
    }
    async makePurchase(bp_id, purchase_id) {
        const db = Database.getInstance().getConnection();
        const stmt = db.prepare("INSERT INTO business_partner_purchases (bp_id, purchase_id) VALUES (?, ?)");
        stmt.bind_param("ii", bp_id, purchase_id);
        stmt.execute();
        stmt.close();
    }
    async confirmPayment(bp_id, purchase_id) {
        const db = Database.getInstance().getConnection();
        const stmt = db.prepare("UPDATE purchases SET status = 'paid' WHERE purchase_id = ?");
        stmt.bind_param("i", purchase_id);
        stmt.execute();
        stmt.close();
    }
    async cancelPurchase(bp_id, purchase_id) {
        const db = Database.getInstance().getConnection();
        const stmt = db.prepare("UPDATE purchases SET status = 'cancelled' WHERE purchase_id = ?");
        stmt.bind_param("i", purchase_id);
        stmt.execute();
        stmt.close();
    }
    async makeReview(bp_id, review_id) {
        const db = Database.getInstance().getConnection();
        const stmt = db.prepare("INSERT INTO business_partner_reviews (bp_id, review_id) VALUES (?, ?)");
        stmt.bind_param("ii", bp_id, review_id);
        stmt.execute();
        stmt.close();
    }
    async removeReview(bp_id, review_id) {
        const db = Database.getInstance().getConnection();
        const stmt = db.prepare("DELETE FROM business_partner_reviews WHERE bp_id = ? AND review_id = ?");
        stmt.bind_param("ii", bp_id, review_id);
        stmt.execute();
        stmt.close();
    }
}

class BusinessPartnerService {
    public function addPartner($username, $password, $email, $name, $phonenumber) {
        $bp = BusinessPartnerFactory::createBusinessPartner($username, $password, $email, $name, $phonenumber);
        $bp->save();
    }
    public function deletePartner($bp_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM business_partners WHERE bp_id = ?");
        $stmt->bind_param("i", $bp_id);
        $stmt->execute();
        $stmt->close();
    }
    public function updatePartner($bp_id, $data) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE business_partners SET username = ?, password = ?, email = ?, name = ?, phonenumber = ? WHERE bp_id = ?");
        $stmt->bind_param("sssssi", $data['username'], $data['password'], $data['email'], $data['name'], $data['phonenumber'], $bp_id);
        $stmt->execute();
        $stmt->close();
    }
    public function getPartner($bp_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM business_partners WHERE bp_id = ?");
        $stmt->bind_param("i", $bp_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }
    public function getPartners() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM business_partners");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function addTicket($bp_id, $ticket_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO business_partner_tickets (bp_id, ticket_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $bp_id, $ticket_id);
        $stmt->execute();
        $stmt->close();
    }
    public function deleteTicket($bp_id, $ticket_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM business_partner_tickets WHERE bp_id = ? AND ticket_id = ?");
        $stmt->bind_param("ii", $bp_id, $ticket_id);
        $stmt->execute();
        $stmt->close();
    }
    public function addDestination($bp_id, $destination_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO business_partner_destinations (bp_id, destination_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $bp_id, $destination_id);
        $stmt->execute();
        $stmt->close();
    }
    public function deleteDestination($bp_id, $destination_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM business_partner_destinations WHERE bp_id = ? AND destination_id = ?");
        $stmt->bind_param("ii", $bp_id, $destination_id);
        $stmt->execute();
        $stmt->close();
    }
    public function makePurchase($bp_id, $purchase_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO business_partner_purchases (bp_id, purchase_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $bp_id, $purchase_id);
        $stmt->execute();
        $stmt->close();
    }
    public function confirmPayment($bp_id, $purchase_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE purchases SET status = 'paid' WHERE purchase_id = ?");
        $stmt->bind_param("i", $purchase_id);
        $stmt->execute();
        $stmt->close();
    }
    public function cancelPurchase($bp_id, $purchase_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE purchases SET status = 'cancelled' WHERE purchase_id = ?");
        $stmt->bind_param("i", $purchase_id);
        $stmt->execute();
        $stmt->close();
    }
    public function makeReview($bp_id, $review_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO business_partner_reviews (bp_id, review_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $bp_id, $review_id);
        $stmt->execute();
        $stmt->close();
    }
    public function removeReview($bp_id, $review_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM business_partner_reviews WHERE bp_id = ? AND review_id = ?");
        $stmt->bind_param("ii", $bp_id, $review_id);
        $stmt->execute();
        $stmt->close();
    }
}