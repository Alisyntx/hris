<?php
include '../../database/conn.php';

$startDate = $_POST['startDate'] ?? '';
$endDate = $_POST['endDate'] ?? '';
$department = $_POST['department'] ?? '';
$searchTerm = $_POST['searchTerm'] ?? '';

// Build base SQL
$sql = "SELECT t.time_empName, e.emp_department, e.emp_id,
               t.am_time_in, t.am_time_out, 
               t.pm_time_in, t.pm_time_out, 
               t.time_total, 
               t.am_time_remarks, t.pm_time_remarks, 
               t.time_dtr_remark, t.time_dateAdd 
        FROM timekeeping t 
        INNER JOIN employee e ON t.time_empId = e.emp_id
        WHERE 1";

$params = [];

if (!empty($startDate) && !empty($endDate)) {
    $sql .= " AND t.time_dateAdd BETWEEN :startDate AND :endDate";
    $params[':startDate'] = $startDate;
    $params[':endDate'] = $endDate;
}

if (!empty($department)) {
    $sql .= " AND e.emp_department = :department";
    $params[':department'] = $department;
}

if (!empty($searchTerm)) {
    $sql .= " AND t.time_empName LIKE :searchTerm";
    $params[':searchTerm'] = "%$searchTerm%";
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll();

if ($results) {
    foreach ($results as $row) {
        // Fetch department schedule
        $deptStmt = $pdo->prepare("SELECT * FROM departments WHERE dept_name = :dept");
        $deptStmt->execute([':dept' => $row['emp_department']]);
        $dept = $deptStmt->fetch();

        $amDuration = 0;
        $pmDuration = 0;

        // Process AM time
        if ($row['am_time_in'] && $row['am_time_out']) {
            $actualIn = date("H:i", strtotime($row['am_time_in']));
            $actualOut = date("H:i", strtotime($row['am_time_out']));
            $deptIn = date("H:i", strtotime($dept['dept_amtime_in']));
            $deptOut = date("H:i", strtotime($dept['dept_amtime_out']));

            $start = strtotime(max($actualIn, $deptIn));
            $end = strtotime(min($actualOut, $deptOut));
            if ($end > $start) {
                $amDuration = $end - $start;
            }
        }

        // Process PM time (optional)
        if ($row['pm_time_in'] && $row['pm_time_out']) {
            $actualIn = date("H:i", strtotime($row['pm_time_in']));
            $actualOut = date("H:i", strtotime($row['pm_time_out']));
            $deptIn = date("H:i", strtotime($dept['dept_pmtime_in']));
            $deptOut = date("H:i", strtotime($dept['dept_pmtime_out']));

            $start = strtotime(max($actualIn, $deptIn));
            $end = strtotime(min($actualOut, $deptOut));
            if ($end > $start) {
                $pmDuration = $end - $start;
            }
        }

        // Combine AM and PM durations
        $totalSeconds = $amDuration + $pmDuration;

        // Convert to hours and minutes
        $hours = floor($totalSeconds / 3600);
        $minutes = round(($totalSeconds % 3600) / 60);

        // Handle edge case (e.g., 3 hrs 60 mins → 4 hrs)
        if ($minutes == 60) {
            $hours += 1;
            $minutes = 0;
        }

        $totalFormatted = "{$hours}:" . str_pad($minutes, 2, '0', STR_PAD_LEFT) . " hrs";

        // Output HTML
        echo "<tr>
                <td>{$row['time_empName']}</td>
                <td>{$row['emp_department']}</td>
                <td>" . ($row['am_time_in'] ? date("g:i A", strtotime($row['am_time_in'])) : '--') . "</td>
                <td>" . ($row['am_time_out'] ? date("g:i A", strtotime($row['am_time_out'])) : '--') . "</td>
                <td>" . ($row['pm_time_in'] ? date("g:i A", strtotime($row['pm_time_in'])) : '--') . "</td>
                <td>" . ($row['pm_time_out'] ? date("g:i A", strtotime($row['pm_time_out'])) : '--') . "</td>
                <td class='text-center font-semibold'>{$totalFormatted}</td>
                <td>{$row['am_time_remarks']}</td>
                <td>{$row['pm_time_remarks']}</td>
                <td>{$row['time_dateAdd']}</td>
              </tr>";
    }
} else {
    echo "<tr class='no-data-row'><td colspan='11' class='text-center'>No records found</td></tr>";
}
