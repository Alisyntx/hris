<?php
// Database configuration
$host    = 'localhost';
$db      = 'db_hellberg';
$user    = 'root';
$pass    = '';
$charset = 'utf8mb4';

// DSN (Data Source Name)
$dsn = "mysql:host={$host};dbname={$db};charset={$charset}";

// PDO options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Enable exceptions for errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Return associative arrays by default
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Use native prepared statements
];

try {
    // Create a new PDO instance
    $pdo = new PDO($dsn, $user, $pass, $options);
    // Connection is successful if no exception is thrown
} catch (PDOException $e) {
    // Log error and handle it appropriately (do not display sensitive info in production)
    error_log($e->getMessage());
    die('Database connection failed.');
}
