<?php
include '../../database/conn.php';

try {
    $stmt = $pdo->query("SELECT ot_id, ot_emp_name, ot_start_time, ot_end_time, ot_reason, ot_date FROM overtime_request ORDER BY ot_id DESC");
    $requests = $stmt->fetchAll();

    echo json_encode([
        'status' => 'success',
        'data' => $requests
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch overtime requests.'
    ]);
}
