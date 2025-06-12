<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../../database/conn.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$id = $_POST['id'] ?? null;
$status = $_POST['status'] ?? null;

if (!$id || !$status) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE leave_request SET status = :status WHERE id = :id");
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Status updated to ' . $status]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'DB Error: ' . $e->getMessage()]);
}
