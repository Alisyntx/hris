<?php
require_once '../../database/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otId = $_POST['ot_id'];
    $newStatus = $_POST['status'];

    try {
        $stmt = $pdo->prepare("UPDATE overtime_request SET ot_status = :status WHERE ot_id = :otId");
        $stmt->bindParam(':status', $newStatus);
        $stmt->bindParam(':otId', $otId);
        $stmt->execute();

        echo json_encode(['status' => 'success', 'message' => "Request marked as $newStatus."]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Update failed: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
