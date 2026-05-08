<?php 
require_once "inc/conn.php";
session_start();

if(isset($_SESSION['login_user'])) {
    header("location: index.php");
    exit();
}

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $myusername = mysqli_real_escape_string($connect, $_POST['username']);
    $mypassword = mysqli_real_escape_string($connect, $_POST['password']);
    
    $sql = "SELECT id, username, password FROM admin WHERE username = '$myusername'";
    $result = mysqli_query($connect, $sql);
    $count = mysqli_num_rows($result);
    
    if($count == 1) {
        $row = mysqli_fetch_assoc($result);
        $stored_password = $row['password'];
        
        if(password_verify($mypassword, $stored_password) || $mypassword === $stored_password) {
            $_SESSION['login_user'] = $myusername;
            header("location: index.php");
            exit();
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - FreshNest</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #E8DCCB 0%, #F6EEE8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-container h1 { color: #5C4338; margin-bottom: 10px; }
        .login-container img { width: 80px; margin-bottom: 20px; }
        .login-container input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }
        .login-container button {
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
        .login-container button:hover { background: #5C4338; }
        .error { color: red; margin-bottom: 15px; }
        .back-link { margin-top: 20px; display: block; }
        .back-link a { color: #8B6A5B; text-decoration: none; font-size: 12px; }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="../images/logo.png" alt="FreshNest">
        <h1>Admin Login</h1>
        <p style="color: #888; margin-bottom: 20px;">Enter your credentials</p>
        
        <?php if($error != ""): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required autofocus>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        
        <div class="back-link">
            <a href="../index.php">← Back to Website</a>
        </div>
    </div>
</body>
</html>