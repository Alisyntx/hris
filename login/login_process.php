<?php
session_start();
require_once '../database/conn.php'; // make sure this connects using PDO

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Prepare and execute query
        $stmt = $pdo->prepare("SELECT user_id, user_username, user_password FROM user WHERE user_username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['user_password'])) {
            // Login success
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_username'] = $user['user_username'];
            header("Location: ../index.php?login=success");
            exit;
        } else {
            // Invalid credentials
            header("Location: login.php?error=invalid");
            exit;
        }
    } catch (PDOException $e) {
        echo "Login failed: " . $e->getMessage();
        exit;
    }
} else {
    // Not a POST request
    header("Location: login.php");
    exit;
}
