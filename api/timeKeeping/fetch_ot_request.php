<?php
require_once '../../database/conn.php';

try {
    $today = date('Y-m-d');

    $stmt = $pdo->prepare("SELECT * FROM overtime_request WHERE ot_date = :today ORDER BY ot_date ASC");
    $stmt->bindParam(':today', $today);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['status' => 'success', 'data' => $data]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Fetch error: ' . $e->getMessage()]);
}
