<?php 
// Database configuration for admin panel
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'project_data1');
define('DB_PORT', 3307);

// Create connection
$connect = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

// Set charset
mysqli_set_charset($connect, 'utf8mb4');
?>