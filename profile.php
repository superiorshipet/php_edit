<?php
session_start();
require_once __DIR__ . '/config.php';
// 1. Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch favorites count for the header section
$fav_count = 0;
$fav_count_query = "SELECT COUNT(*) AS total FROM favorites WHERE user_id = $user_id";
$fav_count_result = mysqli_query($conn, $fav_count_query);
if ($fav_count_result) {
    $fav_count_row = mysqli_fetch_assoc($fav_count_result);
    $fav_count = $fav_count_row['total'];
}

// 2. Handle Delete Account Logic (Deletes user from DB and destroys session)
if (isset($_GET['delete_account'])) {
    mysqli_query($conn, "DELETE FROM `users` WHERE user_id = '$user_id'");
    session_destroy();
    header("Location: signup.php"); 
    exit();
}

// 3. Handle Logout Logic (Destroys session and redirects to login)
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// 4. Handle AJAX Update for profile information
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajax_update'])) {
    $name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']); 
    $new_pass = $_POST['password'];
    $conf_pass = $_POST['confirm_password'];

    // Update basic user information in the database
    $update_basic = mysqli_query($conn, "UPDATE `users` SET full_name = '$name', phone = '$phone', email = '$email' WHERE user_id = '$user_id'");

    if (!empty($new_pass)) {
        if ($new_pass === $conf_pass) {
            mysqli_query($conn, "UPDATE `users` SET password = '$new_pass' WHERE user_id = '$user_id'");
            echo "success";
        } else { 
            echo "pass_mismatch"; 
        }
    } else {
        echo ($update_basic) ? "success" : "error";
    }
    exit();
}

// 5. Fetch current user data from database for display
$query = mysqli_query($conn, "SELECT * FROM `users` WHERE user_id = '$user_id'");
if (mysqli_num_rows($query) > 0) {
    $fetch = mysqli_fetch_assoc($query);
} else {
    session_destroy();
    header("Location: signup.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FreshNest - Profile Settings</title>
    <link href="css/style.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary-olive: #6b7a5f; --soft-bg: #f3ece4; --white: #ffffff; --text-main: #4a3a30; }
        body { background-color: var(--soft-bg); font-family: 'Poppins', sans-serif; margin: 0; color: var(--text-main); }
        
        .profile-wrapper { padding: 140px 20px 50px; display: flex; justify-content: center; }
        .profile-card { background: var(--white); width: 950px; border-radius: 30px; display: flex; box-shadow: 0 20px 40px rgba(0,0,0,0.05); overflow: hidden; }
        
        .profile-sidebar { width: 35%; background: #fdfbf9; padding: 50px 20px; display: flex; flex-direction: column; align-items: center; border-right: 1px solid #eee; }
        .avatar-circle { width: 120px; height: 120px; background: var(--primary-olive); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 45px; color: white; margin-bottom: 20px; }
        
        .sidebar-links { width: 100%; margin-top: 30px; text-align: center; }
        .link-logout { display: inline-block; padding: 10px 25px; text-decoration: none; font-size: 14px; border-radius: 8px; color: #d9534f; background: #fff5f5; transition: 0.3s; }
        .link-logout:hover { background: #fee2e2; }
        .link-delete { display: block; margin-top: 20px; color: #999; font-size: 12px; text-decoration: none; }
        .link-delete:hover { color: #ff0000; text-decoration: underline; }

        .profile-content { width: 65%; padding: 50px 60px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
        .input-box { position: relative; } 
        .input-box input { width: 100%; padding: 14px; border: 1px solid #ddd; border-radius: 12px; outline: none; box-sizing: border-box; background: #fafafa; margin-top: 8px; }
        .input-box label { font-size: 13px; font-weight: 600; color: #666; }
        
        /* Fixed Styling for Eye Icon to be centered inside the input field */
        .toggle-password { position: absolute; right: 15px; bottom: 14px; cursor: pointer; color: #aaa; font-size: 16px; transition: color 0.3s; }
        .toggle-password:hover { color: var(--primary-olive); }

        .btn-save { grid-column: span 2; background: var(--primary-olive); color: white; border: none; padding: 16px; border-radius: 12px; font-weight: bold; cursor: pointer; margin-top: 10px; font-size: 16px; }
        #status-msg { display: none; padding: 15px; border-radius: 12px; margin-bottom: 25px; text-align: center; font-size: 14px; }
        
        .header-right { display: flex; align-items: center; gap: 15px; }
        .user-avatar { width: 35px; height: 35px; background: #4a5441; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px; }
    </style>
</head>
<body>

<div class="header">
    <div class="container row">
        <a class="brand" href="index.php">
            <img alt="FreshNest Logo" src="images/logo.png"/>
            <span class="name"><span class="fresh">Frsh</span><span class="nest">Nest</span></span>
        </a>
        <div class="nav">
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="contact.php">Contacts</a>
            <a href="orders.php">My Orders</a>
        </div>
        <div class="header-right">
            <a class="header-fav" href="favorites.php">♥<?php if ($fav_count > 0) { ?><span class="fav-count"><?php echo $fav_count; ?></span><?php } ?></a>
            <a class="icon-btn" href="cart.php"><img alt="Cart" class="cart-icon" src="images/icon-cart.png"/></a>
            <a href="profile.php" class="user-avatar" style="text-decoration: none;">
                <?php echo strtoupper(substr($fetch['full_name'], 0, 1)); ?>
            </a>
        </div>
    </div>
</div>

<div class="profile-wrapper">
    <div class="profile-card">
        <aside class="profile-sidebar">
            <div class="avatar-circle">
                <?php echo strtoupper(substr($fetch['full_name'], 0, 1)); ?>
            </div>
            <h3><?php echo htmlspecialchars($fetch['full_name']); ?></h3>
            <p style="color: #999; font-size: 13px;">User Account</p>
            
            <div class="sidebar-links">
                <a href="profile.php?logout=1" class="link-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                <a href="profile.php?delete_account=1" class="link-delete" onclick="return confirm('Are you sure?')">Delete Account</a>
            </div>
        </aside>

        <section class="profile-content">
            <h2 style="font-family: 'Playfair Display', serif; margin-bottom: 30px;">Account Settings</h2>
            <div id="status-msg"></div>
            
            <form id="profileUpdateForm" class="form-grid">
                <input type="hidden" name="ajax_update" value="1">
                <div class="input-box" style="grid-column: span 2;">
                    <label>Full Name</label>
                    <input type="text" name="full_name" value="<?php echo htmlspecialchars($fetch['full_name']); ?>" required>
                </div>
                <div class="input-box">
                    <label>Mobile Number</label>
                    <input type="text" name="phone" value="<?php echo htmlspecialchars($fetch['phone']); ?>">
                </div>
                <div class="input-box">
                    <label>Email Address</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($fetch['email']); ?>" required>
                </div>
                
                <div class="input-box">
                    <label>New Password</label>
                    <input type="password" id="p1" name="password" placeholder="Type new password">
                    <i class="fas fa-eye-slash toggle-password" onclick="toggleVisibility('p1', this)"></i>
                </div>
                <div class="input-box">
                    <label>Confirm Password</label>
                    <input type="password" id="p2" name="confirm_password" placeholder="Confirm password">
                    <i class="fas fa-eye-slash toggle-password" onclick="toggleVisibility('p2', this)"></i>
                </div>
                
                <button type="submit" id="saveBtn" class="btn-save">Save Changes</button>
            </form>
        </section>
    </div>
</div>

<script>
/**
 * Toggles the visibility of the password input field.
 * Changes input type between 'password' and 'text'.
 */
function toggleVisibility(inputId, icon) {
    const inputField = document.getElementById(inputId);
    if (inputField.type === "password") {
        inputField.type = "text";
        icon.classList.replace('fa-eye-slash', 'fa-eye'); // Show eye when text is visible
    } else {
        inputField.type = "password";
        icon.classList.replace('fa-eye', 'fa-eye-slash'); // Show slashed eye when hidden
    }
}

/**
 * Handles the profile update via AJAX to prevent page reload.
 */
document.getElementById('profileUpdateForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('saveBtn');
    const p1 = document.getElementById('p1').value;
    const p2 = document.getElementById('p2').value;

    // Check if passwords match if user tried to change it
    if (p1 !== "" && p1 !== p2) {
        showStatus("Passwords don't match!", "#f8d7da", "#721c24");
        return;
    }

    btn.innerHTML = "Updating...";
    btn.disabled = true;

    fetch('profile.php', {
        method: 'POST',
        body: new FormData(this)
    })
    .then(response => response.text())
    .then(result => {
        btn.innerHTML = "Save Changes";
        btn.disabled = false;
        if (result.trim() === "success") {
            showStatus("Success! Profile updated.", "#d4edda", "#155724");
            setTimeout(() => location.reload(), 1000);
        } else {
            showStatus("Update failed.", "#f8d7da", "#721c24");
        }
    });
});

/**
 * Displays a status message to the user.
 */
function showStatus(text, bg, color) {
    const msgBox = document.getElementById('status-msg');
    msgBox.innerHTML = text;
    msgBox.style.display = "block";
    msgBox.style.backgroundColor = bg;
    msgBox.style.color = color;
}
</script>
</body>
</html>