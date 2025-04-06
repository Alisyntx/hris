<?php
include '../../database/conn.php';

$searchTerm = $_GET['query'] ?? '';

$sql = "SELECT DISTINCT time_empName FROM timekeeping WHERE time_empName LIKE :searchTerm LIMIT 10";
$stmt = $pdo->prepare($sql);
$stmt->execute([":searchTerm" => "%$searchTerm%"]);
$names = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode($names);
