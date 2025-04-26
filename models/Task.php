<?php
class Task {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll($userId) {
        $stmt = $this->conn->prepare('SELECT * FROM tasks WHERE user_id = ?');
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id, $userId) {
        $stmt = $this->conn->prepare('SELECT * FROM tasks WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($userId, $title, $description, $status) {
        $stmt = $this->conn->prepare('INSERT INTO tasks (user_id, title, description, status) VALUES (?, ?, ?, ?)');
        return $stmt->execute([$userId, $title, $description, $status]);
    }

    public function update($id, $userId, $title, $description, $status) {
        $stmt = $this->conn->prepare('UPDATE tasks SET title = ?, description = ?, status = ? WHERE id = ? AND user_id = ?');
        return $stmt->execute([$title, $description, $status, $id, $userId]);
    }

    public function delete($id, $userId) {
        $stmt = $this->conn->prepare('DELETE FROM tasks WHERE id = ? AND user_id = ?');
        return $stmt->execute([$id, $userId]);
    }
}
