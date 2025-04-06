<?php
include '../../database/conn.php';

$sql = "SELECT DISTINCT emp_department FROM employee ORDER BY emp_department ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$departments = $stmt->fetchAll(PDO::FETCH_COLUMN);

header('Content-Type: application/json');
echo json_encode($departments);
