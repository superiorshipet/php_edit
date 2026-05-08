<?php 
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "project_data1";

// Create connection
$connect = new mysqli($servername, $username, $password, $db_name);

// Check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

mysqli_set_charset($connect, 'utf8');
?>
