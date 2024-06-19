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
    private static $instance = null; // Menyimpan instance tunggal dari kelas Database
    private $connection; // Menyimpan koneksi database

    private function __construct() {
       // Membuat koneksi ke database
        $this->connection = new mysqli('localhost', 'user', 'password', 'database');
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error); // Memastikan koneksi berhasil
        }
    }

    public static function getInstance() {
        // Mengembalikan instance yang ada atau membuat yang baru jika belum ada
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        // Mengembalikan koneksi database
        return $this->connection;
    }
}

class Ticket {
    private $id; // ID dari tiket
    private $name; // Nama tiket
    private $price; // Harga tiket
    private $status; // Status tiket (misalnya tersedia atau tidak)
    private $description; // Deskripsi tiket

    public function __construct($name, $price, $status, $description) {
        // Menginisialisasi atribut-atribut tiket
        $this->name = $name;
        $this->price = $price;
        $this->status = $status;
        $this->description = $description;
    }

    // Getter: Mengembalikan nilai dari atribut yang bersangkutan
    public function getName() { 
        return $this->name; 
    }
    
    public function getPrice() { 
        return $this->price; 
    }
    
    public function getStatus() { 
        return $this->status; 
    }
    
    public function getDescription() { 
        return $this->description; 
    }

    // Setter: Mengatur nilai dari atribut yang bersangkutan
    public function setName($name) {
        $this->name = $name;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
    
    // Metode untuk menyimpan tiket ke database
    public function save() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO tickets (name, price, status, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdss", $this->name, $this->price, $this->status, $this->description);
        $stmt->execute();
        $stmt->close();
    }
}

class TicketFactory {
    public static function createTicket($name, $price, $status, $description) {
        // Membuat dan mengembalikan objek Ticket baru
        return new Ticket($name, $price, $status, $description);
    }
}

class TicketService {
    public function getTicket($ticketId) {
        // Mengambil detail tiket dari database berdasarkan ID tiket
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM tickets WHERE id = ?");
        $stmt->bind_param("i", $ticketId);
        $stmt->execute();
        $result = $stmt->get_result();
        $ticket = $result->fetch_assoc();
        $stmt->close();
        return $ticket;
    }

    public function purchaseTicket($ticketId, $userId, $amount) {
        // Menangani logika pembelian tiket
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO ticket_purchases (ticket_id, user_id, amount) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $ticketId, $userId, $amount);
        $stmt->execute();
        $stmt->close();
    }

    public function createTicket($name, $price, $status, $description) {
        // Membuat tiket baru menggunakan Factory Pattern dan menyimpannya ke database
        $ticket = TicketFactory::createTicket($name, $price, $status, $description);
        $ticket->save();
    }

    // Metode lain terkait tiket bisa ditambahkan di sini
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

