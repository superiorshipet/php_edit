<?php
// admin/inc/session.php
session_start();

// Check if user is logged in
if(!isset($_SESSION['login_user'])){
    header("Location: ../login.php");
    exit();
}

// Include database connection
require_once('conn.php');

// Get admin details
$username = $_SESSION['login_user'];
$query = "SELECT * FROM admin WHERE username = '$username'";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_assoc($result);

// Verify admin exists
if(!$row){
    session_destroy();
    header("Location: ../login.php");
    exit();
}
?>