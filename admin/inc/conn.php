<?php 
// Database connection for admin panel
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "project_data1";

$connect = new mysqli($servername, $username, $password, $db_name);

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

mysqli_set_charset($connect, 'utf8');
?>