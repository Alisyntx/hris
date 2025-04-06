<?php
include '../../database/conn.php'; // Your PDO connection file

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emp_id = $_POST['emp_id'] ?? ''; // Get Employee ID for update
    $fname = $_POST['fname'] ?? '';
    $mname = $_POST['mname'] ?? '';
    $lname = $_POST['lname'] ?? '';
    $suffix = $_POST['suffix'] ?? '';
    $age = $_POST['age'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $address = $_POST['address'] ?? '';
    $position = $_POST['position'] ?? '';
    $department = $_POST['department'] ?? '';
    $promotion = $_POST['promotion'] ?? 'Not Promoted';
    $date_hire = $_POST['hireDate'] ?? '';

    if (empty($emp_id) || empty($fname) || empty($lname) || empty($position) || empty($department) || empty($date_hire)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields!']);
        exit;
    }

    // Fetch current image path from the database
    $query = "SELECT emp_profPic FROM employee WHERE emp_id = :emp_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':emp_id' => $emp_id]);
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);
    $currentImage = $employee['emp_profPic'] ?? null;

    // Handle new image upload (if provided)
    $imagePath = $currentImage;
    if (!empty($_FILES['profileImage']['name'])) {
        $targetDir = realpath(__DIR__ . '/../../storage/employee') . '/';
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileInfo = pathinfo($_FILES["profileImage"]["name"]);
        $fileExt = strtolower($fileInfo['extension']);
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($fileExt, $allowedExts)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid file format. Only JPG, PNG, and GIF allowed.']);
            exit;
        }

        $fileName = time() . "_" . uniqid() . "." . $fileExt;
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetFile)) {
            $imagePath = "storage/employee/" . $fileName;

            // Delete old image if it exists
            if ($currentImage && file_exists('../../' . $currentImage)) {
                unlink('../../' . $currentImage);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload image.']);
            exit;
        }
    }

    try {
        $sql = "UPDATE employee SET 
                emp_fname = :fname,
                emp_mname = :mname,
                emp_lname = :lname,
                emp_suffix = :suffix,
                emp_age = :age,
                emp_gender = :gender,
                emp_address = :address,
                emp_position = :position,
                emp_department = :department,
                emp_promotion = :promotion,
                emp_dateHire = :date_hire,
                emp_profPic = :profileImage
                WHERE emp_id = :emp_id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':emp_id' => $emp_id,
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

        echo json_encode([
            'status' => 'success',
            'message' => 'Employee updated successfully!'
            // 'profileImage' => $imagePath
        ]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method!']);
}
