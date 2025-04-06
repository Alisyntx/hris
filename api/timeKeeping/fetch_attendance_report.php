<?php
include '../../database/conn.php';

$startDate = $_POST['startDate'] ?? '';
$endDate = $_POST['endDate'] ?? '';
$department = $_POST['department'] ?? '';
$searchTerm = $_POST['searchTerm'] ?? '';

// Base Query
$sql = "SELECT t.time_empName, e.emp_department, t.time_in, t.time_out, t.time_total, t.time_remarks, t.time_dateAdd 
        FROM timekeeping t 
        INNER JOIN employee e ON t.time_empId = e.emp_id
        WHERE 1";

// Parameters for prepared statements
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
        echo "<tr>
                <td>{$row['time_empName']}</td>
                <td>{$row['emp_department']}</td>
                <td>" . ($row['time_in'] ? date("g:i A", strtotime($row['time_in'])) : '--') . "</td>
                <td>" . ($row['time_out'] ? date("g:i A", strtotime($row['time_out'])) : '--') . "</td>
                <td class='text-center font-semibold'>";

        // Calculate Total Hours
        if (!empty($row['time_in']) && !empty($row['time_out'])) {
            $timeIn = strtotime($row['time_in']);
            $timeOut = strtotime($row['time_out']);

            // Ensure time_out is after time_in
            if ($timeOut > $timeIn) {
                $totalHours = (($timeOut - $timeIn) / 3600) - 1; // Convert seconds to hours and subtract 1-hour break
                echo number_format($totalHours, 2); // Format to 2 decimal places
            } else {
                echo '--'; // Invalid time range
            }
        } else {
            echo '--'; // If either time_in or time_out is missing
        }
        echo "</td>
                <td>{$row['time_remarks']}</td>
                <td>{$row['time_dateAdd']}</td>
            </tr>";
    }
} else {
    echo "<tr class='no-data-row'><td colspan='7' class='text-center'>No records found</td></tr>";
}
