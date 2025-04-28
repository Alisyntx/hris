<?php
header("Content-Type: application/json");
include '../../database/conn.php';
// ✅ Get today's date
$dateToday = date('Y-m-d'); // Get today's date

// ✅ Adjust query to filter by today's date
$query = "
    SELECT 
        SUM(CASE WHEN time_remarks LIKE '%absent%' THEN 1 ELSE 0 END) AS total_absent,
        SUM(CASE WHEN time_remarks LIKE '%late%' THEN 1 ELSE 0 END) AS total_late,
        SUM(CASE WHEN time_remarks LIKE '%On Time%' THEN 1 ELSE 0 END) AS total_present
    FROM timekeeping
    WHERE time_dateAdd = :dateToday
";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':dateToday', $dateToday);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

// ✅ Send JSON response
echo json_encode([
    "success" => true,
    "message" => "Attendance summary retrieved successfully",
    "data" => [
        "total_absent" => $result['total_absent'] ?? 0,
        "total_late" => $result['total_late'] ?? 0,
        "total_present" => $result['total_present'] ?? 0
    ]
]);
