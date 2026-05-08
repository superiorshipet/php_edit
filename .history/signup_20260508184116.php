<?php
// 1. Include database configuration and start user session
require_once __DIR__ . '/config.php';session_start();

// Initialize an array to store validation errors
$errors = array();

// 2. Handle form submission logic
if(isset($_POST['submit'])){
   
   // Sanitize user inputs to prevent SQL Injection
   $name = mysqli_real_escape_string($conn, $_POST['full_name']);
   $phone = mysqli_real_escape_string($conn, $_POST['phone']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, ($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, ($_POST['confirm_password']));

   // 3. Input Validation
   // Validate Saudi mobile format (Starts with 05 and followed by 8 digits)
   if(!preg_match("/^05[0-9]{8}$/", $phone)) {
       $errors['phone'] = "Phone must start with 05 and be 10 digits.";
   }
   
   // Check if email already exists in the database
   $select = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');
   if(mysqli_num_rows($select) > 0){
      $errors['email'] = "Email already registered.";
   }

   // Ensure the two password fields match
   if($pass != $cpass){
      $errors['pass'] = "Passwords do not match.";
   }

   // 4. Database Integration
   // If no validation errors, proceed to insert data into the users table
   if(count($errors) == 0){
      $insert = mysqli_query($conn, "INSERT INTO `users`(full_name, phone, email, password) VALUES('$name', '$phone', '$email', '$pass')") or die('query failed');
      
      if($insert){
         // Automatically log in the user by storing ID and name in session variables
         $_SESSION['user_id'] = mysqli_insert_id($conn);
         $_SESSION['user_name'] = $name;
         
         // Redirect to home page upon successful registration
         header('location:index.php');
         exit();
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>FreshNest | Sign Up</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <style>
      /* Page Styling and Layout Design */
      body { background-color: #f3ece4; font-family: 'Poppins', sans-serif; margin: 0; padding: 0; }
      
      .signup-wrapper { padding: 80px 20px; display: flex; justify-content: center; align-items: center; min-height: 100vh; box-sizing: border-box; }
      
      .form-container { display: flex; width: 950px; background: rgba(255,255,255,0.9); border-radius: 25px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.05); }
      
      .left-brand { width: 40%; background: #fff; padding: 40px; text-align: center; display: flex; flex-direction: column; justify-content: center; border-right: 1px solid #eee; }
      .left-brand img { width: 140px; margin: 0 auto 20px; }
      .left-brand h2 { color: #4a3a30; font-family: 'Playfair Display', serif; font-size: 28px; margin: 0; }

      .right-form { width: 60%; padding: 50px; }
      .right-form h2 { margin: 0 0 5px; color: #333; font-size: 26px; }
      .subtitle { color: #999; font-size: 14px; margin-bottom: 30px; }

      .input-box { margin-bottom: 20px; position: relative; }
      .input-box label { display: block; font-size: 13px; color: #555; margin-bottom: 8px; font-weight: 500; }
      
      /* Input field styling with icons */
      .input-field-container { position: relative; }
      .input-field-container input { 
          width: 100%; 
          padding: 14px 15px 14px 45px; 
          border: 1px solid #ddd; 
          border-radius: 10px; 
          box-sizing: border-box; 
          background: #fbfbfb; 
          font-size: 14px;
      }
      .input-field-container i.icon { position: absolute; left: 15px; top: 16px; color: #aaa; font-size: 16px; }
      .input-field-container i.toggle { position: absolute; right: 15px; top: 16px; cursor: pointer; color: #aaa; }

      .error-text { color: #b0413e; font-size: 12px; margin-top: 5px; display: block; }

      .signup-btn { 
          width: 100%; padding: 16px; background: #6b7a5f; color: white; border: none; 
          border-radius: 10px; font-weight: 600; font-size: 16px; cursor: pointer; margin-top: 10px; 
      }
      .signup-btn:hover { background: #5a6850; }

      .switch-link { text-align: center; margin-top: 25px; font-size: 14px; color: #777; }
      .switch-link a { color: #6b7a5f; font-weight: 600; text-decoration: none; }
   </style>
</head>
<body>

<?php 
// 5. Dynamic Header inclusion
if(file_exists('header.php')){
    include 'header.php'; 
}
?>

<div class="signup-wrapper">
   <div class="form-container">
      <div class="left-brand">
         <img src="images/logo.png" alt="Logo">
         <h2>FreshNest</h2>
         <p style="font-size: 14px; color: #8a7b6f; line-height: 1.6;">Giving furniture a second life with sustainable beauty and quality.</p>
      </div>

      <div class="right-form">
         <h2>Create New Account</h2>
         <p class="subtitle">Join the FreshNest community today</p>

         <form action="" method="post" novalidate>
            <div class="input-box">
               <label>Full Name</label>
               <div class="input-field-container">
                  <i class="fas fa-user icon"></i>
                  <input type="text" name="full_name" placeholder="Full Name" value="<?php echo isset($name)?$name:''; ?>">
               </div>
            </div>

            <div class="input-box">
               <label>Mobile Number</label>
               <div class="input-field-container">
                  <i class="fas fa-phone icon"></i>
                  <input type="text" name="phone" placeholder="05xxxxxxxx" value="<?php echo isset($phone)?$phone:''; ?>">
               </div>
               <?php if(isset($errors['phone'])) echo '<span class="error-text">'.$errors['phone'].'</span>'; ?>
            </div>

            <div class="input-box">
               <label>Email Address</label>
               <div class="input-field-container">
                  <i class="fas fa-envelope icon"></i>
                  <input type="email" name="email" placeholder="Email" value="<?php echo isset($email)?$email:''; ?>">
               </div>
               <?php if(isset($errors['email'])) echo '<span class="error-text">'.$errors['email'].'</span>'; ?>
            </div>

            <div class="input-box">
               <label>Password</label>
               <div class="input-field-container">
                  <i class="fas fa-lock icon"></i>
                  <input type="password" name="password" id="pass" placeholder="Password">
                  <i class="fas fa-eye-slash toggle" onclick="toggleVisibility('pass', this)"></i>
               </div>
            </div>

            <div class="input-box">
               <label>Confirm Password</label>
               <div class="input-field-container">
                  <i class="fas fa-lock icon"></i>
                  <input type="password" name="confirm_password" id="cpass" placeholder="Confirm Password">
                  <i class="fas fa-eye-slash toggle" onclick="toggleVisibility('cpass', this)"></i>
               </div>
               <?php if(isset($errors['pass'])) echo '<span class="error-text">'.$errors['pass'].'</span>'; ?>
            </div>

            <input type="submit" name="submit" value="Sign Up" class="signup-btn">
            <p class="switch-link">Already have an account? <a href="login.php">Sign In</a></p>
         </form>
      </div>
   </div>
</div>

<script>
function toggleVisibility(id, el) {
   let input = document.getElementById(id);
   if (input.type === "password") {
      input.type = "text";
      el.className = "fas fa-eye toggle";
   } else {
      input.type = "password";
      el.className = "fas fa-eye-slash toggle";
   }
}
</script>

</body>
</html>