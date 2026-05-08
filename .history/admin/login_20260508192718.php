<?php
session_start();
require_once('inc/conn.php');

// Redirect if already logged in
if(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit();
}

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM admin WHERE username = '$username'";
    $result = mysqli_query($connect, $sql);
    
    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Check password (plain text or hashed)
        if($password === $row['password'] || password_verify($password, $row['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_name'] = $row['username'];
            $_SESSION['admin_id'] = $row['id'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Username not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - FreshNest</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #E8DCCB 0%, #F6EEE8 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-box {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            width: 400px;
            text-align: center;
        }
        .login-box h1 {
            color: #5C4338;
            margin-bottom: 10px;
        }
        .login-box img {
            width: 80px;
            margin-bottom: 20px;
        }
        .login-box input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }
        .login-box button {
            width: 100%;
            padding: 12px;
            background: #8B6A5B;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        .login-box button:hover {
            background: #5C4338;
        }
        .error {
            color: red;
            margin-bottom: 15px;
            padding: 10px;
            background: #fee;
            border-radius: 8px;
        }
        .success {
            color: green;
            margin-bottom: 15px;
            padding: 10px;
            background: #efe;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <img src="../images/logo.png" alt="FreshNest">
        <h1>Admin Login</h1>
        <p style="color: #888; margin-bottom: 20px;">Access the dashboard</p>
        
        <?php if($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required autofocus>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        
        <p style="margin-top: 20px;">
            <a href="../index.php" style="color: #8B6A5B;">← Back to Website</a>
        </p>
    </div>
</body>
</html>