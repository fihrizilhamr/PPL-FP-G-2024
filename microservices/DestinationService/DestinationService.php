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




// Destination class
class Destination {
    private $id;
    private $name;
    private $description;
    private $picture;
    private $address;


    public function __construct($id, $name, $description, $picture, $address) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->picture = $picture;
        $this->address = $address;
 
   

    }

    public function save() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO destinations (id, name, description, picture, address) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $this->id, $this->name, $this->description, $this->picture, $this->address);
        $stmt->execute();
        $stmt->close();

        $result = $stmt->get_result();
        return $result;
    }

    public function setId($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE destinations SET id = ? WHERE id = ?");
        $stmt->bind_param("ii", $id, $this->id);
        $stmt->execute();

        $result = $stmt->get_result();
        $this->id = $id;

        return $result;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setName($name) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE destinations SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $name, $this->id);
        $stmt->execute();

        $result = $stmt->get_result();
        $this->name = $name;

        return $result;
    }
    
    public function getName() {
        return $this->name;
    }
    
      
     public function setDescription($description) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE destinations SET description = ? WHERE id = ?");
        $stmt->bind_param("si", $description, $this->id);
        $stmt->execute();

        $result = $stmt->get_result();
        $this->description = $description;

        return $result;
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function setPicture($picture) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE destinations SET pictures = ? WHERE id = ?");
        $stmt->bind_param("si", $picture, $this->id);
        $stmt->execute();

        $result = $stmt->get_result();
        $this->picture = $picture;

        return $result;
    }
    
    public function getPicture() {
        return $this->picture;
    }
    
    
    public function setAddress($address) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE destinations SET address = ? WHERE id = ?");
        $stmt->bind_param("si", $address, $this->id);
        $stmt->execute();

        $result = $stmt->get_result();
        $this->address = $address;

        return $result;
    }
    
    public function getAddress() {
        return $this->address;
    }
    

}


// Factory Method for creating destinations
class DestinationFactory {
    public static function createDestination($id, $name, $description, $picture, $address) {
        return new Destination($id, $name, $description, $picture, $address);
    }
}

class DestinationService {

    public function createDestination($id, $name, $description, $picture, $address) {
        $destination = new Destination($id, $name, $description, $picture, $address);

        return $destination;
    }   

    public function getDestinationById($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM destinations WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $destination = new Destination(
                $row['id'],
                $row['name'],
                $row['description'],
                $row['picture'],
                $row['address'],
            );
            return $destination;
        }

        return null;
    }

    public function getAllDestinations() {
        $destinations = [];
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM destinations");
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $destination = new Destination(
                $row['id'],
                $row['name'],
                $row['description'],
                $row['picture'],
                $row['address'],
            );

            $destinations[] = $destination;
        }

        return $destinations;
    }

    public function updateDestination(Destination $destination) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE destinations SET name = ?, description = ?, picture = ?, address = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $destination->getName(), $destination->getDescription(), $destination->getPicture(), $destination->getAddress(), $destination->getId());
        $stmt->execute();

        $result = $stmt->get_result();
        return $result;
    }

    public function deleteDestination(Destination $destination) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM destinations WHERE id = ?");
        $stmt->bind_param("i", $destination->getId());
        $stmt->execute();
    }

}

?>