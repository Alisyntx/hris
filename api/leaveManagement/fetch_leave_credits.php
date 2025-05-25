<?php
include '../../database/conn.php';
 $sql = "SELECT emp_fname, emp_mname, emp_lname, emp_position, emp_department, emp_profPic, emp_total_leave, emp_used_leave FROM employee";
 $stmt = $pdo->query($sql);
 $results = [];

 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $remaining = $row['emp_total_leave'] - $row['emp_used_leave'];
    $row['remaining'] = $remaining;
    $results[] = $row; 
 }

 echo json_encode($results);
?>