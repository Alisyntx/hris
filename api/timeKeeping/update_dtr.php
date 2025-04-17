<?php
require_once '../../database/conn.php';
header("Content-Type: application/json");

$response = [];

try {
    $time_id = $_POST['time_id'] ?? null;
    $time_in = $_POST['time_in'] ?? null;
    $time_out = $_POST['time_out'] ?? null;
    $time_remarks = $_POST['time_remarks'] ?? null;

    if (!$time_id || !$time_in || !$time_out) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields.'
        ]);
        exit;
    }

    $stmt = $pdo->prepare("UPDATE timekeeping SET time_in = ?, time_out = ?, time_remarks = ? WHERE time_id = ?");
    $stmt->execute([$time_in, $time_out, $time_remarks, $time_id]);

    echo json_encode([
        'status' => 'success',
        'message' => 'DTR updated successfully.'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Something went wrong: ' . $e->getMessage()
    ]);
}
