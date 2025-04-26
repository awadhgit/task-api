<?php
header('Content-Type: application/json');
require_once '../config/database.php';

$db = (new Database())->connect();
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

require_once '../controllers/AuthController.php';
require_once '../controllers/TaskController.php';
require_once '../helpers/Token.php';        // path should match location
require_once '../helpers/authenticate.php'; // <-- Make sure this is the correct path

$data = json_decode(file_get_contents("php://input"), true);

// Clean the URI (remove /task-api/public)
$uri = str_replace('/task-api/public', '', $uri);

// Routing
if ($uri === '/api/register' && $method === 'POST') {
    (new AuthController($db))->register($data);

} elseif ($uri === '/api/login' && $method === 'POST') {
    (new AuthController($db))->login($data);

} elseif ($uri === '/api/tasks' && $method === 'GET') {
    $userId = authenticate(); // <-- Calling the helper function directly
    (new TaskController($db))->index($userId);

} elseif ($uri === '/api/tasks' && $method === 'POST') {
    $userId = authenticate(); // <-- Calling the helper function directly
    (new TaskController($db))->create($userId, $data);

} elseif (preg_match('/^\/api\/tasks\/(\d+)$/', $uri, $matches) && $method === 'GET') {
    $userId = authenticate(); // <-- Calling the helper function directly
    (new TaskController($db))->show($matches[1], $userId);

} elseif (preg_match('/^\/api\/tasks\/(\d+)$/', $uri, $matches) && $method === 'PUT') {
    $userId = authenticate(); // <-- Calling the helper function directly
    (new TaskController($db))->update($matches[1], $userId, $data);

} elseif (preg_match('/^\/api\/tasks\/(\d+)$/', $uri, $matches) && $method === 'DELETE') {
    $userId = authenticate(); // <-- Calling the helper function directly
    (new TaskController($db))->delete($matches[1], $userId);

} else {
    // 404 Not Found
    http_response_code(404);
    echo json_encode(['message' => 'Endpoint not found']);
}
