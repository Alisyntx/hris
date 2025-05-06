<?php
require_once '../../database/conn.php';
header("Content-Type: application/json");

try {
    $time_id = $_POST['time_id'] ?? null;
    $am_timein = $_POST['am_timein'] ?? null;
    $am_timeout = $_POST['am_timeout'] ?? null;
    $am_remarks = $_POST['am_remarks'] ?? null;

    $pm_timein = $_POST['pm_timein'] ?? null;
    $pm_timeout = $_POST['pm_timeout'] ?? null;
    $pm_remarks = $_POST['pm_remarks'] ?? null;

    if (!$time_id) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing time ID.'
        ]);
        exit;
    }

    $stmt = $pdo->prepare("UPDATE timekeeping 
        SET am_time_in = ?, am_time_out = ?, am_time_remarks = ?, 
            pm_time_in = ?, pm_time_out = ?, pm_time_remarks = ?
        WHERE time_id = ?");

    $stmt->execute([
        $am_timein,
        $am_timeout,
        $am_remarks,
        $pm_timein,
        $pm_timeout,
        $pm_remarks,
        $time_id
    ]);

    echo json_encode([
        'status' => 'success',
        'message' => 'DTR updated successfully.'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Something went wrong: ' . $e->getMessage()
    ]);
}
