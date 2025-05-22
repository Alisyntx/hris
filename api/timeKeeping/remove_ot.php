<?php
include '../../database/conn.php'; // $pdo assumed
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ot_id = $_POST['ot_id'] ?? null;

    if ($ot_id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM overtime_request WHERE ot_id = :ot_id");
            $stmt->bindParam(':ot_id', $ot_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to delete record."]);
            }
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Missing OT ID."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
