<?php
header("Content-Type: application/json");
include '../../database/conn.php';

$dateToday = date('Y-m-d');

$query = "
    SELECT 
        SUM(CASE WHEN am_time_remarks LIKE '%On Time%' THEN 1 ELSE 0 END) AS present_am,
        SUM(CASE WHEN pm_time_remarks LIKE '%On Time%' THEN 1 ELSE 0 END) AS present_pm,
        SUM(CASE WHEN am_time_remarks LIKE '%absent%' THEN 1 ELSE 0 END) AS absent_am,
        SUM(CASE WHEN pm_time_remarks LIKE '%absent%' THEN 1 ELSE 0 END) AS absent_pm,
        SUM(CASE WHEN am_time_remarks LIKE '%late%' THEN 1 ELSE 0 END) AS late_am,
        SUM(CASE WHEN pm_time_remarks LIKE '%late%' THEN 1 ELSE 0 END) AS late_pm
    FROM timekeeping
    WHERE time_dateAdd = :dateToday
";


$stmt = $pdo->prepare($query);
$stmt->bindParam(':dateToday', $dateToday);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode([
    "success" => true,
    "message" => "Attendance summary retrieved successfully",
    "data" => [
        "present_am" => $result['present_am'] ?? 0,
        "present_pm" => $result['present_pm'] ?? 0,
        "absent_am" => $result['absent_am'] ?? 0,
        "absent_pm" => $result['absent_pm'] ?? 0,
        "late_am" => $result['late_am'] ?? 0,
        "late_pm" => $result['late_pm'] ?? 0
    ]
]);
