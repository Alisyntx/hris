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

                // Time fields (AM and PM)
                $timeIn = trim($row[3]); // AM Time In
                $timeOut = trim($row[4]); // AM Time Out

                // PM times
                $pmTimeIn = trim($row[5]); // PM Time In
                $pmTimeOut = isset($row[6]) ? trim($row[6]) : ''; // PM Time Out

                // Get today's date
                $today = date('Y-m-d');

                // Flag for late DTR upload
                $lateDtrRemark = '';
                if ($dateAdded < $today) {
                    $lateDtrRemark = "Late DTR Upload";
                }

                // Parse AM timeIn and timeOut safely
                $parsedTimeIn = $timeIn ? strtotime($timeIn) : false;
                $parsedTimeOut = $timeOut ? strtotime($timeOut) : false;

                // Default working start time for AM (e.g., 8:00 AM)
                $defaultTimeIn = strtotime('08:00:00');

                // Determine AM remarks and time values
                if ($parsedTimeIn === false) {
                    $amRemarks = 'Absent';
                    $timeIn24 = null;
                } else {
                    $timeIn24 = date("H:i:s", $parsedTimeIn);
                    $amRemarks = ($parsedTimeIn <= $defaultTimeIn) ? 'On Time' : 'Late';
                }

                // Parse PM timeIn and timeOut safely
                $parsedPmTimeIn = $pmTimeIn ? strtotime($pmTimeIn) : false;
                $parsedPmTimeOut = $pmTimeOut ? strtotime($pmTimeOut) : false;

                // Default working start time for PM (e.g., 1:00 PM)
                $defaultPmTimeIn = strtotime('13:00:00');

                $pmRemarks = '';
                if ($parsedPmTimeIn === false) {
                    $pmRemarks = 'Absent';
                    $pmTimeIn24 = null;
                } else {
                    $pmTimeIn24 = date("H:i:s", $parsedPmTimeIn);
                    $pmRemarks = ($parsedPmTimeIn <= $defaultPmTimeIn) ? 'On Time' : 'Late';
                }

                $timeOut24 = $parsedTimeOut ? date("H:i:s", $parsedTimeOut) : null;
                $pmTimeOut24 = $parsedPmTimeOut ? date("H:i:s", $parsedPmTimeOut) : null;

                // Check if the record already exists
                $checkStmt = $pdo->prepare("SELECT time_id, am_time_out, pm_time_out FROM timekeeping WHERE time_empId = ? AND time_dateAdd = ?");
                $checkStmt->execute([$empId, $dateAdded]);
                $existing = $checkStmt->fetch();

                if ($existing) {
                    // Update record if PM time_out or AM time_out is not set
                    if ((!$existing['am_time_out'] && $timeOut24) || (!$existing['pm_time_out'] && $pmTimeOut24)) {
                        $updateStmt = $pdo->prepare("
                            UPDATE timekeeping 
                            SET am_time_out = ?, pm_time_in = ?, pm_time_out = ?, am_time_remarks = ?, pm_time_remarks = ?, time_dtr_remark = ? 
                            WHERE time_empId = ? AND time_dateAdd = ?
                        ");
                        $updateStmt->execute([$timeOut24, $pmTimeIn24, $pmTimeOut24, $amRemarks, $pmRemarks, $lateDtrRemark, $empId, $dateAdded]);
                    } else {
                        // Update remarks and late remark if time_out is already set
                        $updateStmt = $pdo->prepare("
                            UPDATE timekeeping 
                            SET am_time_remarks = ?, pm_time_remarks = ?, time_dtr_remark = ? 
                            WHERE time_empId = ? AND time_dateAdd = ?
                        ");
                        $updateStmt->execute([$amRemarks, $pmRemarks, $lateDtrRemark, $empId, $dateAdded]);
                    }
                } else {
                    // Insert new record
                    $insertStmt = $pdo->prepare("
                        INSERT INTO timekeeping (time_empId, time_empName, am_time_in, am_time_out, pm_time_in, pm_time_out, am_time_remarks, pm_time_remarks, time_dtr_remark, time_dateAdd) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                    ");
                    $insertStmt->execute([
                        $empId,
                        $empName,
                        $timeIn24,
                        $timeOut24,
                        $pmTimeIn24,
                        $pmTimeOut24,
                        $amRemarks,
                        $pmRemarks,
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
