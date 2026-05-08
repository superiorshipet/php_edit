<?php
// Admin session handling
session_start();

// Check if admin is logged in
if(!isset($_SESSION['login_user'])){
    header("location: ../login.php");
    die();
}

// Dummy row for compatibility with existing code
$row = array(
    'username' => $_SESSION['login_user'] ?? 'Admin',
    'id' => 1
);
?>