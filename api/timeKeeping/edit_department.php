<?php
header("Content-Type: application/json");
include '../../database/conn.php';

try {
    // Get POST data
    $deptId = $_POST['dept_id'] ?? null;
    $deptName = $_POST['dept_name'] ?? '';
    $amTimeIn = $_POST['dept_amtime_in'] ?? '';
    $amTimeOut = $_POST['dept_amtime_out'] ?? '';
    $pmTimeIn = $_POST['dept_pmtime_in'] ?? '';
    $pmTimeOut = $_POST['dept_pmtime_out'] ?? '';
    $breakDuration = $_POST['dept_break_duration'] ?? 0;

    // Validate required fields
    if (!$deptId || !$deptName || !$amTimeIn || !$amTimeOut || !$pmTimeIn || !$pmTimeOut) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields.'
        ]);
        exit;
    }

    // Update query using your actual database columns
    $stmt = $pdo->prepare("UPDATE departments 
        SET dept_name = :dept_name, 
            dept_amtime_in = :am_in, 
            dept_amtime_out = :am_out, 
            dept_pmtime_in = :pm_in, 
            dept_pmtime_out = :pm_out, 
            dept_break_time = :break_duration 
        WHERE dept_id = :dept_id");

    $stmt->execute([
        ':dept_name' => $deptName,
        ':am_in' => $amTimeIn,
        ':am_out' => $amTimeOut,
        ':pm_in' => $pmTimeIn,
        ':pm_out' => $pmTimeOut,
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
