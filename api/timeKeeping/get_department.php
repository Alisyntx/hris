<?php
header("Content-Type: application/json");
include '../../database/conn.php';

try {
    $stmt = $pdo->query("SELECT dept_id, dept_name, dept_time_in, dept_time_out, dept_break_time FROM departments");
    $departments = $stmt->fetchAll();

    // Convert break time from hours (decimal) to a readable format
    foreach ($departments as &$department) {
        // Convert dept_break_time from decimal hours to hours and minutes
        $decimalTime = $department['dept_break_time'];
        $hours = floor($decimalTime);  // Get whole hours
        $minutes = round(($decimalTime - $hours) * 60);  // Get remaining minutes from decimal part

        // Format the time as "X hours Y minutes"
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
