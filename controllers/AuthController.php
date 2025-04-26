<?php
require_once '../config/database.php';
include_once '../models/User.php';
require_once '../helpers/Token.php';

class AuthController {
    private $user;

    public function __construct($db) {
        $this->user = new User($db);
    }

    public function register($data) {
        if ($this->user->register($data['username'], $data['password'])) {
            echo json_encode(['message' => 'User registered successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Registration failed']);
        }
    }

    public function login($data) {
        $userId = $this->user->login($data['username'], $data['password']);
        if ($userId) {
            echo json_encode(['token' => Token::generate($userId)]);
        } else {
            http_response_code(401);
            echo json_encode(['message' => 'Invalid credentials']);
        }
    }
}
