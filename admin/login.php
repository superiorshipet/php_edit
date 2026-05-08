<?php 
include "inc/conn.php";
session_start();

if(isset($_SESSION['login_user'])){
    header("location: index.php");
    exit();
}

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $myusername = mysqli_real_escape_string($connect, $_POST['username']);
    $mypassword = mysqli_real_escape_string($connect, $_POST['password']);
    
    $sql = "SELECT id, username FROM admin WHERE username = '$myusername' AND password = '$mypassword'";
    $result = mysqli_query($connect, $sql);
    $count = mysqli_num_rows($result);
    
    if($count == 1) {
        $_SESSION['login_user'] = $myusername;
        header("location: index.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - FreshNest</title>
    <link href="../css/style.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #E8DCCB 0%, #F6EEE8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }
        .login-card {
            background: white;
            border-radius: 30px;
            padding: 45px 35px;
            text-align: center;
            box-shadow: 0 25px 50px rgba(0,0,0,0.1);
        }
        .login-logo {
            width: 90px;
            margin-bottom: 20px;
        }
        .login-card h1 {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            color: #5C4338;
            margin-bottom: 8px;
        }
        .login-card .subtitle {
            color: #888;
            font-size: 14px;
            margin-bottom: 30px;
        }
        .field {
            text-align: left;
            margin-bottom: 20px;
        }
        .field label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            color: #5C4338;
            margin-bottom: 8px;
        }
        .field input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s;
        }
        .field input:focus {
            outline: none;
            border-color: #8B6A5B;
            box-shadow: 0 0 0 3px rgba(139,106,91,0.1);
        }
        .btn-login {
            width: 100%;
            padding: 14px;
            background: #8B6A5B;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background: #5C4338;
            transform: translateY(-2px);
        }
        .error-message {
            background: #fee2e2;
            color: #dc2626;
            padding: 12px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
        }
        .back-link {
            margin-top: 20px;
            display: block;
        }
        .back-link a {
            color: #8B6A5B;
            text-decoration: none;
            font-size: 14px;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <img src="../images/logo.png" alt="FreshNest" class="login-logo">
            <h1>Admin Login</h1>
            <p class="subtitle">Enter your credentials to access dashboard</p>
            
            <?php if($error): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="field">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Enter username" required autofocus>
                </div>
                <div class="field">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter password" required>
                </div>
                <button type="submit" class="btn-login">Sign In</button>
            </form>
            
            <div class="back-link">
                <a href="../welcome.php">← Back to Welcome</a>
            </div>
        </div>
    </div>
</body>
</html>
