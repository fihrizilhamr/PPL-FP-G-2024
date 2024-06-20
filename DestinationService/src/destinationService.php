<?php

require_once 'Database.php';
require __DIR__ . '/../vendor/autoload.php';
use Ramsey\Uuid\Uuid;

class DestinationService
{
    private $id;
    private $name;
    private $description;
    private $picture;

    private $db;

    public function __construct($dbConfig)
    {
        $database = new Database($dbConfig);
        $this->db = $database->getConnection();
    }

    // Create a new destination
    public function create($ownerId, $name, $description, $picture)
    {
        $id = Uuid::uuid4();
        $stmt = $this->db->prepare("INSERT INTO destinations (id, name, description, picture, owner_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$id, $name, $description, $picture, $ownerId]);
        return ['ownerId' => $ownerId, 'id' => $id, 'name' => $name, 'description' => $description, 'picture' => $picture];
    }

    // Read all destinations
    public function readAll()
    {
        $stmt = $this->db->query("SELECT * FROM destinations");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Read a single destination by ID
    public function read($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM destinations WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            http_response_code(404);
            return ['error' => 'Not Found'];
        }
        return $result;
    }

    // Update a destination
    public function update($id, $name, $description, $picture)
    {
       // Check if the destination exists
       $stmt = $this->db->prepare("SELECT * FROM destinations WHERE id = ?");
       $stmt->execute([$id]);
       if ($stmt->rowCount() == 0) {
           http_response_code(404);
           return ['error' => 'Not Found'];
       }

       // Update the destination
       $stmt = $this->db->prepare("UPDATE destinations SET name = ?, description = ?, picture = ? WHERE id = ?");
       $stmt->execute([$name, $description, $picture, $id]);
       return ['id' => $id, 'name' => $name, 'description' => $description, 'picture' => $picture];
    }

    // Delete a destination
    public function delete($id)
    {
        // Check if the destination exists
        $stmt = $this->db->prepare("SELECT * FROM destinations WHERE id = ?");
        $stmt->execute([$id]);
        if ($stmt->rowCount() == 0) {
            http_response_code(404);
            return ['error' => 'Not Found'];
        }

        // Delete the destination
        $stmt = $this->db->prepare("DELETE FROM destinations WHERE id = ?");
        $stmt->execute([$id]);
        return ['id' => $id];
    }

     // Search for destinations by name
     public function searchDestination($name)
     {
        $stmt = $this->db->prepare("SELECT * FROM destinations WHERE name LIKE ?");
        $stmt->execute(['%' . $name . '%']);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($results)) {
            return ['message' => 'No destinations found'];
        }
        return $results;
     }

    
}
