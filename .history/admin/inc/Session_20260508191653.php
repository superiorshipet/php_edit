<?php
// Admin session handling
session_start();

// Check if admin is logged in
if(!isset($_SESSION['login_user'])){
    header("location: ../login.php");
    die();
}

// Get admin info from database
include('conn.php');

$login_session = $_SESSION['login_user'];
$sql = "SELECT * FROM admin WHERE username = '$login_session'";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);

// If no admin found, logout
if(!$row){
    session_destroy();
    header("location: ../login.php");
    die();
}
?>