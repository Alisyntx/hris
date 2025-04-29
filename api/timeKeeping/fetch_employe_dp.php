<?php
include '../../../database/conn.php';


try {
    // Prepare and execute query
    $stmt = $pdo->prepare("SELECT emp_id, emp_fname, emp_mname, emp_lname, emp_suffix FROM employee ORDER BY emp_fname ASC");
    $stmt->execute();
    $employees = $stmt->fetchAll();

    // Output each employee name inside an <option>
    foreach ($employees as $row) {
        $fullName = $row['emp_fname'] . ' ' . $row['emp_mname'] . ' ' . $row['emp_lname'];
        if (!empty($row['emp_suffix'])) {
            $fullName .= ', ' . $row['emp_suffix'];
        }
        echo '<option value="' . htmlspecialchars(trim($fullName)) . '"></option>';
    }
} catch (PDOException $e) {
    // Handle exception properly
    error_log($e->getMessage());
    echo '<option value="">Error loading employees</option>';
}
