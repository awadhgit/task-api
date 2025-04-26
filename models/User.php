<?php
class User {
    private $conn;
    public $id;
    public $username;
    public $password_hash;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($username, $password) {
        $stmt = $this->conn->prepare('INSERT INTO users (username, password ) VALUES (?, ?)');
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        return $stmt->execute([$username, $passwordHash]);
    }

    public function login($username, $password) {
        $stmt = $this->conn->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user['id'];
        }
        return false;
    }
}
