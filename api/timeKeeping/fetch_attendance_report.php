<?php
include '../../database/conn.php';

$startDate = $_POST['startDate'] ?? '';
$endDate = $_POST['endDate'] ?? '';
$department = $_POST['department'] ?? '';
$searchTerm = $_POST['searchTerm'] ?? '';

// Updated SQL query
$sql = "SELECT t.time_empName, e.emp_department, 
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
        echo "<tr>
                <td>{$row['time_empName']}</td>
                <td>{$row['emp_department']}</td>
                <td>" . ($row['am_time_in'] ? date("g:i A", strtotime($row['am_time_in'])) : '--') . "</td>
                <td>" . ($row['am_time_out'] ? date("g:i A", strtotime($row['am_time_out'])) : '--') . "</td>
                <td>" . ($row['pm_time_in'] ? date("g:i A", strtotime($row['pm_time_in'])) : '--') . "</td>
                <td>" . ($row['pm_time_out'] ? date("g:i A", strtotime($row['pm_time_out'])) : '--') . "</td>
                <td class='text-center font-semibold'>";

        // Optional: you can recalculate total hours here if needed
        echo $row['time_total'] ?? '--';

        echo "</td>
                <td>{$row['am_time_remarks']}</td>
                <td>{$row['pm_time_remarks']}</td>
                <td>{$row['time_dtr_remark']}</td>
                <td>{$row['time_dateAdd']}</td>
            </tr>";
    }
} else {
    echo "<tr class='no-data-row'><td colspan='11' class='text-center'>No records found</td></tr>";
}
