<?php
header("Content-Type: application/json");
include '../../database/conn.php';

try {
    $stmt = $pdo->query("SELECT dept_id, dept_name, dept_amtime_in, dept_amtime_out, dept_pmtime_in, dept_pmtime_out, dept_break_time FROM departments");
    $departments = $stmt->fetchAll();

    // Convert break time from decimal to formatted string
    foreach ($departments as &$department) {
        $decimalTime = $department['dept_break_time'];
        $hours = floor($decimalTime);
        $minutes = round(($decimalTime - $hours) * 60);
        $department['dept_break_time_formatted'] = "{$hours} hour(s) {$minutes} minute(s)";
    }

    echo json_encode([
        'status' => 'success',
        'data' => $departments
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error fetching departments: ' . $e->getMessage()
    ]);
}
