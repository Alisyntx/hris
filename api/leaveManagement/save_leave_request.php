<?php
include '../../database/conn.php'; // Make sure this returns a $pdo variable

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $employee_name = $_POST['employee_id'];
        $leave_type = $_POST['leave_type'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $status = "pending";
        // Prepare and execute
        $stmt = $pdo->prepare("INSERT INTO leave_request (employee_id, leave_type, start_date, end_date, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$employee_name, $leave_type, $start_date, $end_date, $status]);

        echo json_encode("Leave request saved successfully!");
    } catch (PDOException $e) {
        echo json_encode("Error: " . $e->getMessage());
    }
} else {
    echo json_encode("Invalid request method.");
}
