<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "project_data1";

$connect = mysqli_connect($host, $user, $pass, $db);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
?>