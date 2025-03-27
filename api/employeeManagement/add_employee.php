<?php
include '../../database/conn.php'; // Your PDO connection file

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'] ?? '';
    $mname = $_POST['mname'] ?? '';
    $lname = $_POST['lname'] ?? '';
    $suffix = $_POST['suffix'] ?? '';
    $age = $_POST['age'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $address = $_POST['address'] ?? '';
    $position = $_POST['position'] ?? '';
    $department = $_POST['department'] ?? '';
    $promotion = 'Not Promoted';
    $date_hire = $_POST['hireDate'] ?? '';

    // Validate required fields
    if (empty($fname) || empty($lname) || empty($position) || empty($department) || empty($date_hire)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Please fill in all required fields!'
        ]);
        exit;
    }

    // Handle image upload
    $imagePath = null;
    if (!empty($_FILES['profileImage']['name'])) {
        $targetDir = "../../storage/employee/"; // Change to your storage path
        $fileName = time() . "_" . basename($_FILES["profileImage"]["name"]);
        $targetFile = $targetDir . $fileName;

        // Move file to storage folder
        if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetFile)) {
            $imagePath = "storage/employee/" . $fileName; // Save relative path
        }
    }

    try {
        $sql = "INSERT INTO employee (emp_fname, emp_mname, emp_lname, emp_suffix, emp_age, emp_gender, emp_address, emp_position, emp_department, emp_promotion, emp_dateHire, emp_profPic) 
                VALUES (:fname, :mname, :lname, :suffix, :age, :gender, :address, :position, :department, :promotion, :date_hire, :profileImage)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':fname' => $fname,
            ':mname' => $mname,
            ':lname' => $lname,
            ':suffix' => $suffix,
            ':age' => $age,
            ':gender' => $gender,
            ':address' => $address,
            ':position' => $position,
            ':department' => $department,
            ':promotion' => $promotion,
            ':date_hire' => $date_hire,
            ':profileImage' => $imagePath
        ]);

        $lastId = $pdo->lastInsertId();

        echo json_encode([
            'status' => 'success',
            'message' => 'Employee added successfully!',
            'emp_id' => $lastId,
            'profileImage' => $imagePath
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method!'
    ]);
}
