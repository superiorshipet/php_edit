<?php
session_start();
include('conn.php');

// Check if admin is logged in
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}

// Set admin name from session or get from database
if(isset($_SESSION['admin_name'])) {
    $admin_name = $_SESSION['admin_name'];
} else {
    // Try to get from database
    $username = $_SESSION['admin_username'] ?? '';
    if($username) {
        $query = "SELECT username FROM admin WHERE username = '$username'";
        $result = mysqli_query($connect, $query);
        if($row = mysqli_fetch_assoc($result)) {
            $admin_name = $row['username'];
            $_SESSION['admin_name'] = $admin_name;
        } else {
            $admin_name = 'Admin';
        }
    } else {
        $admin_name = 'Admin';
    }
}
?>