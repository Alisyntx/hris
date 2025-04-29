<?php
require_once '../../database/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get all form data
    $otEmpName = $_POST['otEmpName'];
    $otStartTime = $_POST['ot_start_time'];
    $otEndTime = $_POST['ot_end_time'];
    $otDate = $_POST['otDate'];
    $otReason = $_POST['otReason'];

    try {
        // Prepare SQL
        $stmt = $pdo->prepare("INSERT INTO overtime_request (ot_emp_name, ot_start_time, ot_end_time, ot_reason, ot_date) 
                               VALUES (:otEmpName, :otStartTime, :otEndTime, :otReason, :otDate)");

        // Bind parameters
        $stmt->bindParam(':otEmpName', $otEmpName);
        $stmt->bindParam(':otStartTime', $otStartTime);
        $stmt->bindParam(':otEndTime', $otEndTime);
        $stmt->bindParam(':otReason', $otReason);
        $stmt->bindParam(':otDate', $otDate);

        // Execute
        $stmt->execute();

        // Return success
        echo json_encode(['status' => 'success', 'message' => 'Overtime request added successfully.']);
    } catch (PDOException $e) {
        // Error handling
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
