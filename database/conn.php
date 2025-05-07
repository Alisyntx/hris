<?php
// Database configuration
$host    = 'localhost';
$db      = 'db_hellberg';
$user    = 'root';
$pass    = '';
$charset = 'utf8mb4';

// DSN (Data Source Name)
$dsn = "mysql:host={$host};dbname={$db};charset={$charset}";


/**
 * amu ni sha kun pano mag define global definitions sa imo project.
 * 
 * daw kun makita mo mga .env files na, du amu ni sha mag ubra pro PHP.
 * 
 * - UwU
 */
define('DEBUG', true);



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

    /**
     * di mo ni sha magamit kay wala kaman ga log errors
     * 
     * - UwU
     */
    // error_log($e->getMessage());


    /**
     * instead I added this. If ang sa DEBUG definition is true, ma echo sya actual message imbes na ma hambal lang sya connection failed..
     * 
     * - UwU
     */
    if (DEBUG) {
        echo "Connection failed: " . $e->getMessage();
    } else {
        die('Database connection failed.');
    }
}
