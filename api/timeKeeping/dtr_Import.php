<?php
header("Content-Type: application/json");
include '../../database/conn.php';

// ✅ Set correct timezone
date_default_timezone_set('Asia/Manila');

// Check database connection
if (!$pdo) {
    die(json_encode(["success" => false, "message" => "Database connection failed"]));
}

// Retrieve JSON data from the request
$data = json_decode($_POST['data'], true);

if (!empty($data)) {
    try {
        foreach ($data as $index => $row) {
            if ($index === 0) continue;

            if (count($row) >= 7 && !empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[3])) {
                $empId = intval($row[0]);
                $empName = trim($row[1]);
                $dateAdded = trim($row[2]);

                // Convert Excel date to Y-m-d
                if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $dateAdded)) {
                    $dateAdded = date('Y-m-d', strtotime($dateAdded));
                } elseif (is_numeric($dateAdded)) {
                    $dateAdded = date('Y-m-d', strtotime("1899-12-30 +$dateAdded days"));
                }

                $timeIn = trim($row[3]);
                $timeOut = trim($row[4]);
                $remarks = trim($row[6]);

                $timeIn24 = date("H:i:s", strtotime($timeIn));
                $timeOut24 = $timeOut ? date("H:i:s", strtotime($timeOut)) : null;

                $checkStmt = $pdo->prepare("SELECT time_id, time_out FROM timekeeping WHERE time_empId = ? AND time_dateAdd = ?");
                $checkStmt->execute([$empId, $dateAdded]);
                $existing = $checkStmt->fetch();

                if ($existing) {
                    // Only update time_out if it was not set before and now we have a valid value
                    if (!$existing['time_out'] && $timeOut24) {
                        $updateStmt = $pdo->prepare("
                            UPDATE timekeeping 
                            SET time_out = ?, time_remarks = ? 
                            WHERE time_empId = ? AND time_dateAdd = ?
                        ");
                        $updateStmt->execute([$timeOut24, $remarks, $empId, $dateAdded]);
                    }
                } else {
                    // Insert time-in and optionally time-out
                    $insertStmt = $pdo->prepare("
                        INSERT INTO timekeeping (time_empId, time_empName, time_in, time_out, time_remarks, time_dateAdd) 
                        VALUES (?, ?, ?, ?, ?, ?)
                    ");
                    $insertStmt->execute([
                        $empId,
                        $empName,
                        $timeIn24,
                        $timeOut24,
                        $remarks,
                        $dateAdded
                    ]);
                }
            }
        }
        echo json_encode(["success" => true, "message" => "Data imported successfully!"]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error importing data: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "No data received"]);
}
