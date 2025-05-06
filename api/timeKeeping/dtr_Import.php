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

                // Default expected times
                // Get department ID based on employee
                $deptStmt = $pdo->prepare("SELECT emp_department FROM employee WHERE emp_id = ?");
                $deptStmt->execute([$empId]);
                $deptId = $deptStmt->fetchColumn();

                // Get department schedule
                $schedStmt = $pdo->prepare("SELECT dept_amtime_in, dept_amtime_out, dept_pmtime_in, dept_pmtime_out FROM departments WHERE dept_id = ?");
                $schedStmt->execute([$deptId]);
                $schedule = $schedStmt->fetch(PDO::FETCH_ASSOC);

                // Department-based expected times
                $expectedAmIn = isset($schedule['dept_amtime_in']) ? strtotime($schedule['dept_amtime_in']) : strtotime("08:00:00");
                $expectedAmOut = isset($schedule['dept_amtime_out']) ? strtotime($schedule['dept_amtime_out']) : strtotime("12:00:00");
                $expectedPmIn = isset($schedule['dept_pmtime_in']) ? strtotime($schedule['dept_pmtime_in']) : strtotime("13:00:00");
                $expectedPmOut = isset($schedule['dept_pmtime_out']) ? strtotime($schedule['dept_pmtime_out']) : strtotime("17:00:00");


                // PARSE times
                $parsedAmIn = $timeIn ? strtotime($timeIn) : false;
                $parsedAmOut = $timeOut ? strtotime($timeOut) : false;
                $parsedPmIn = $pmTimeIn ? strtotime($pmTimeIn) : false;
                $parsedPmOut = $pmTimeOut ? strtotime($pmTimeOut) : false;

                // Initialize remarks
                $amRemarks = "Absent";
                $pmRemarks = "Absent";

                // AM Session
                if ($parsedAmIn) {
                    $timeIn24 = date("H:i:s", $parsedAmIn);
                    $amRemarks = ($parsedAmIn <= $expectedAmIn) ? "On Time" : "Late";
                    $timeOut24 = $parsedAmOut ? date("H:i:s", $parsedAmOut) : null;

                    // If no AM time out, set it to expected AM out time
                    if (!$parsedAmOut) {
                        $parsedAmOut = $expectedAmOut;
                    }

                    // Early out case for AM (employee leaves earlier than expected AM time out)
                    if ($parsedAmOut < $expectedAmOut) {
                        $amRemarks .= " (Early Out)";
                    }
                } else {
                    $timeIn24 = null;
                    $timeOut24 = null;
                    $amRemarks = "Absent";
                }




                $pmTimeIn24 = null;
                $pmTimeOut24 = null;

                // PM Session
                if ($parsedPmIn) {
                    $pmTimeIn24 = date("H:i:s", $parsedPmIn);
                    $pmRemarks = ($parsedPmIn <= $expectedPmIn) ? "On Time" : "Late";

                    if (!$parsedPmOut) {
                        $parsedPmOut = $expectedPmOut;
                        $pmRemarks .= " (Auto Timeout)";
                    }

                    if ($parsedPmOut < $expectedPmOut) {
                        $pmRemarks .= " (Early Out)";
                    }

                    $pmTimeOut24 = date("H:i:s", $parsedPmOut);
                } else {
                    $currentHour = date("H");

                    if ($parsedAmIn && $currentHour >= 17) {
                        $pmRemarks = "Half Day (No PM In)";
                    } elseif (!$parsedAmIn) {
                        $pmRemarks = "Absent";
                    } else {
                        $pmRemarks = null; // Just leave it empty for now
                    }
                }

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
