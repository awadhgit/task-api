<?php
require_once 'Token.php';

function authenticate() {
    $headers = getallheaders();
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(['message' => 'Authorization header missing']);
        exit;
    }

    $token = str_replace('Bearer ', '', $headers['Authorization']);
    $userId = Token::validate($token);
    if (!$userId) {
        http_response_code(401);
        echo json_encode(['message' => 'Invalid or expired token']);
        exit;
    }

    return $userId;
}
