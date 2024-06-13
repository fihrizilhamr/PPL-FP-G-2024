<?php

require 'Database.php';
require __DIR__ . '/../vendor/autoload.php';
use Ramsey\Uuid\Uuid;

class UserService
{
    private $db;

    public function __construct($dbConfig)
    {
        $database = new Database($dbConfig);
        $this->db = $database->getConnection();
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
}
