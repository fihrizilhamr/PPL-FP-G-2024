<?php

require 'Database.php';
require __DIR__ . '/../vendor/autoload.php';

use Ramsey\Uuid\Uuid;

class BusinessPartnerService
{
    private $db;

    public function __construct($dbConfig)
    {
        $database = new Database($dbConfig);
        $this->db = $database->getConnection();
    }

    function sendPostRequest($url, $data)
    {
        $ch = curl_init();

        // Set the URL and other options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($data))
        ));

        // Execute the request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

        // Close the cURL session
        curl_close($ch);

        return $response;
    }

    public function register($name, $email, $password)
    {
        $id = Uuid::uuid4();
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO users (id, name, email, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$id, $name, $email, $hashedPassword]);
        return ['id' => $id, 'name' => $name, 'email' => $email];
    }

    public function login($email, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $token = base64_encode(random_bytes(64));
            // Store the token in a session or database
            return ['token' => $token];
        }

        return ['error' => 'Invalid credentials'];
    }

    public function profile($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createDestination($ownerId, $name, $description, $picture)
    {
        $url = "http://localhost:8000/destinations";
        $data = array("ownerId" => $ownerId, "name" => $name, "description" => $description, "picture" => $picture);
        $response = $this->sendPostRequest($url, $data);
        return $response;
    }
}
