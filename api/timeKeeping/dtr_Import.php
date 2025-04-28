<?php
header("Content-Type: application/json");
include '../../database/conn.php';

date_default_timezone_set('Asia/Manila');

if (!$pdo) {
    http_response_code(500);
    die(json_encode(["success" => false, "message" => "Database connection failed"]));
}

$data = json_decode($_POST['data'], true);

if (!empty($data)) {
    try {
        foreach ($data as $index => $row) {
            if ($index === 0) continue; // Skip headers

            if (count($row) >= 7 && !empty($row[0]) && !empty($row[1]) && !empty($row[2])) {
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
                $remarks = isset($row[6]) ? trim($row[6]) : '';
                $lateDtrRemark = ''; // Placeholder for late DTR remark

                // Get today's date
                $today = date('Y-m-d');

                // Flag for late DTR upload
                if ($dateAdded < $today) {
                    $lateDtrRemark = "Late DTR Upload";
                }

                // Parse timeIn and timeOut safely
                $parsedTimeIn = $timeIn ? strtotime($timeIn) : false;
                $parsedTimeOut = $timeOut ? strtotime($timeOut) : false;

                // Default working start time
                $defaultTimeIn = strtotime('08:00:00');

                // Determine remarks and time values
                if ($parsedTimeIn === false) {
                    $remarks = 'Absent';
                    $timeIn24 = null;
                } else {
                    $timeIn24 = date("H:i:s", $parsedTimeIn);
                    $remarks = ($parsedTimeIn <= $defaultTimeIn) ? 'On Time' : 'Late';
                }

                $timeOut24 = $parsedTimeOut ? date("H:i:s", $parsedTimeOut) : null;

                // Check if the record already exists
                $checkStmt = $pdo->prepare("SELECT time_id, time_out FROM timekeeping WHERE time_empId = ? AND time_dateAdd = ?");
                $checkStmt->execute([$empId, $dateAdded]);
                $existing = $checkStmt->fetch();

                if ($existing) {
                    // Update record if time_out is not set
                    if (!$existing['time_out'] && $timeOut24) {
                        $updateStmt = $pdo->prepare("
                            UPDATE timekeeping 
                            SET time_out = ?, time_remarks = ?, time_dtr_remark = ? 
                            WHERE time_empId = ? AND time_dateAdd = ?
                        ");
                        $updateStmt->execute([$timeOut24, $remarks, $lateDtrRemark, $empId, $dateAdded]);
                    } else {
                        // Update remarks and late remark
                        $updateStmt = $pdo->prepare("
                            UPDATE timekeeping 
                            SET time_remarks = ?, time_dtr_remark = ? 
                            WHERE time_empId = ? AND time_dateAdd = ?
                        ");
                        $updateStmt->execute([$remarks, $lateDtrRemark, $empId, $dateAdded]);
                    }
                } else {
                    // Insert new record
                    $insertStmt = $pdo->prepare("
                        INSERT INTO timekeeping (time_empId, time_empName, time_in, time_out, time_remarks, time_dtr_remark, time_dateAdd) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)
                    ");
                    $insertStmt->execute([
                        $empId,
                        $empName,
                        $timeIn24,
                        $timeOut24,
                        $remarks,
                        $lateDtrRemark,
                        $dateAdded
                    ]);
                }
            }
        }

        // Fetch all records after import
        $fetchStmt = $pdo->query("SELECT * FROM timekeeping ORDER BY time_dateAdd DESC, time_id DESC");
        $allData = $fetchStmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "success" => true,
            "message" => "Data imported successfully!",
            "data" => $allData
        ]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Error importing data: " . $e->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "No data received"]);
}
