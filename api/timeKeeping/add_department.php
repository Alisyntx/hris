<?php
header("Content-Type: application/json");
include '../../database/conn.php'; // assumes $pdo is initialized here

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['dept_name']) &&
        isset($_POST['dept_time_in']) &&
        isset($_POST['dept_time_out']) &&
        isset($_POST['dept_break_duration'])
    ) {
        try {
            $stmt = $pdo->prepare("INSERT INTO departments (dept_name, dept_time_in, dept_time_out, dept_break_time) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $_POST['dept_name'],
                $_POST['dept_time_in'],
                $_POST['dept_time_out'],
                floatval($_POST['dept_break_duration'])
            ]);
            $response = [
                'status' => 'success',
                'message' => 'Department added successfully.',
                'inserted_id' => $pdo->lastInsertId()
            ];
        } catch (PDOException $e) {
            $response = [
                'status' => 'error',
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Missing required fields.'
        ];
    }
} else {
    $response = [
        'status' => 'error',
        'message' => 'Invalid request method.'
    ];
}

echo json_encode($response);
