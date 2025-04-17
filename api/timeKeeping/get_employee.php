<?php
require_once '../../database/conn.php'; // assuming this file has your PDO setup

try {
    $stmt = $pdo->query("SELECT emp_id, emp_fname, emp_mname, emp_lname, emp_suffix FROM employee");
    $employees = $stmt->fetchAll();

    echo json_encode($employees);
} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch employee data']);
}
