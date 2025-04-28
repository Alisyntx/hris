<?php
header("Content-Type: application/json");
include '../../database/conn.php';

try {
    // Get POST data
    $deptId = $_POST['dept_id'] ?? null;
    $deptName = $_POST['dept_name'] ?? '';
    $timeIn = $_POST['dept_time_in'] ?? '';
    $timeOut = $_POST['dept_time_out'] ?? '';
    $breakDuration = $_POST['dept_break_duration'] ?? 0;

    // Validate required fields
    if (!$deptId || !$deptName || !$timeIn || !$timeOut) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields.'
        ]);
        exit;
    }

    // Update statement
    $stmt = $pdo->prepare("UPDATE departments 
        SET dept_name = :dept_name, 
            dept_time_in = :time_in, 
            dept_time_out = :time_out, 
            dept_break_time = :break_duration 
        WHERE dept_id = :dept_id");

    $stmt->execute([
        ':dept_name' => $deptName,
        ':time_in' => $timeIn,
        ':time_out' => $timeOut,
        ':break_duration' => $breakDuration,
        ':dept_id' => $deptId
    ]);

    echo json_encode([
        'status' => 'success',
        'message' => 'Department updated successfully!'
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
