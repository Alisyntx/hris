<?php
header("Content-Type: application/json"); // Set JSON response header
include '../../database/conn.php'; // Database connection

// Check if emp_id is provided via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $empId = $_POST['emp_id'] ?? null;

    if ($empId) {
        try {
            // Prepare DELETE statement
            $stmt = $pdo->prepare("DELETE FROM employee WHERE emp_id = ?");
            $stmt->execute([$empId]);

            // Check if any row was deleted
            if ($stmt->rowCount() > 0) {
                echo json_encode(["success" => true, "message" => "Employee deleted successfully."]);
            } else {
                echo json_encode(["success" => false, "message" => "Employee not found or already deleted."]);
            }
        } catch (PDOException $e) {
            echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid employee ID."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
