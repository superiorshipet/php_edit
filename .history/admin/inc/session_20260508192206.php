<?php
session_start();
include('conn.php');

if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}

$admin_name = $_SESSION['admin_name'] ?? 'Admin';
?>
