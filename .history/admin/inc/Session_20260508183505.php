<?php
require_once "conn.php";

session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Get admin info
$admin_username = $_SESSION['admin_username'] ?? 'Admin';

// For compatibility with existing code that expects $row['username']
$row = array('username' => $admin_username, 'id' => $_SESSION['admin_id'] ?? 1);
?>