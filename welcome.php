<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Welcome - FreshNest</title>
<link href="css/style.css" rel="stylesheet"/>
<style>
/* تنسيق إضافي للصفحة */
.welcome-body {
    background: linear-gradient(135deg, #E8DCCB 0%, #F6EEE8 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
.welcome-page {
    width: 100%;
    padding: 20px;
}
.welcome-card {
    background: white;
    border-radius: 30px;
    padding: 50px 40px;
    text-align: center;
    max-width: 500px;
    margin: 0 auto;
    box-shadow: 0 25px 50px rgba(0,0,0,0.1);
}
.welcome-logo {
    width: 100px;
    margin-bottom: 20px;
}
.welcome-title {
    font-family: 'Playfair Display', serif;
    font-size: 32px;
    color: #5C4338;
    margin-bottom: 15px;
}
.welcome-text {
    color: #888;
    margin-bottom: 30px;
}
.welcome-actions {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.welcome-btn {
    padding: 14px 32px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
    display: inline-block;
}
.admin-btn {
    background: #8B6A5B;
    color: white;
    border: 2px solid #8B6A5B;
}
.admin-btn:hover {
    background: #5C4338;
    transform: translateY(-3px);
}
.user-btn {
    background: transparent;
    color: #8B6A5B;
    border: 2px solid #8B6A5B;
}
.user-btn:hover {
    background: #8B6A5B;
    color: white;
    transform: translateY(-3px);
}
.guest-link {
    display: inline-block;
    color: #aaa;
    text-decoration: none;
    font-size: 14px;
    margin-top: 10px;
}
.guest-link:hover {
    color: #8B6A5B;
}
</style>
</head>
<body class="welcome-body">

<div class="welcome-page">
    <div class="welcome-card">
        <img src="images/logo.png" alt="FreshNest Logo" class="welcome-logo"/>
        <h1 class="welcome-title">Welcome to FreshNest</h1>
        <p class="welcome-text">Please choose how you would like to continue.</p>
        
        <div class="welcome-actions">
            <a href="admin/login.php" class="welcome-btn admin-btn">👑 Admin Login</a>
            <a href="login.php" class="welcome-btn user-btn">👤 User Login</a>
        </div>
        
        <a href="index.php" class="guest-link">Continue as Guest →</a>
    </div>
</div>

</body>
</html>
