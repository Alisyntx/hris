<?php
header("Content-Type: application/json");
include '../../database/conn.php';

try {
    $deptId = $_POST['dept_id'] ?? null;

    if (!$deptId) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing department ID.'
        ]);
        exit;
    }

    $stmt = $pdo->prepare("DELETE FROM departments WHERE dept_id = :dept_id");
    $stmt->execute([':dept_id' => $deptId]);

    echo json_encode([
        'status' => 'success',
        'message' => 'Department deleted successfully.'
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error deleting department: ' . $e->getMessage()
    ]);
}
