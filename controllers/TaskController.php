<?php
require_once '../models/Task.php';

class TaskController {
    private $task;

    public function __construct($db) {
        $this->task = new Task($db);
    }

    public function index($userId) {
        echo json_encode($this->task->getAll($userId));
    }

    public function show($id, $userId) {
        $task = $this->task->getById($id, $userId);
        if ($task) echo json_encode($task);
        else http_response_code(404);
    }

    public function create($userId, $data) {
        if ($this->task->create($userId, $data['title'], $data['description'], $data['status'])) {
            echo json_encode(['message' => 'Task created']);
        } else {
            http_response_code(400);
        }
    }

    public function update($id, $userId, $data) {
        if ($this->task->update($id, $userId, $data['title'], $data['description'], $data['status'])) {
            echo json_encode(['message' => 'Task updated']);
        } else {
            http_response_code(400);
        }
    }

    public function delete($id, $userId) {
        if ($this->task->delete($id, $userId)) {
            echo json_encode(['message' => 'Task deleted']);
        } else {
            http_response_code(400);
        }
    }
}
