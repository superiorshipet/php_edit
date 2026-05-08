 <?php
   include('inc/session.php');
?>
<?php

 $full_name=@$_POST['full_name'];
$email=@$_POST['email'];
 $password=@$_POST['password'];
 $phone=@$_POST['phone'];

// insert users 
if(isset($_POST['addemp']))
 
	 {
	 if(empty($full_name)||empty($password)||empty($email)||empty($phone))
	 {
		 echo '<script> alert("اPlease fill in all the fields");</script>';
	 }
	else
	{
	 
			 $insert_pro=("INSERT INTO users(full_name,password ,email , phone)
	 VALUES('$full_name','$password','$email','$phone'
	 )");
	  if ($connect->query($insert_pro) === TRUE) {
	  
        header("Location: user.php");
		  
 }
	else
	{
		echo'<script> alert("Sorry, it was not saved !!!!! ")</script>';
		
	}
	}
 }

?>

 <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Modern Dashboard</title>
<link rel="stylesheet" href="../admin/csss/style.css">
</head>
<body>  
<div class="sidebar" id="sidebar">
  <div class="logo">Control Panel</div>
  <a href="index.php" >Dashboard</a>
    
    <button class="menu-btn" onclick="toggleSidebarsk()"></button>
  
         <div class="profile-wrap">
       <a href="#"   onclick="toggleMenuk()">Categories </a>
        <div class="dropdown" id="dropdownn">
          <a href="cate.php">View Categories</a>
        </div>
      </div>
<a href="product.php" >Products</a>
  <a href="ord.php" >Orders</a>
  <button class="menu-btn" onclick="toggleSidebarsss()"></button>
  
         <div class="profile-wrap">
       <a href="#"  onclick="toggleMenusss()" class="active">Users </a>
        <div class="dropdown"  id="dropdown1">
          <a href="user.php" >View Users</a>
        </div>
      </div>
  <a href="masge.php">Messages</a>
   
</div>

 <div class="main">
  <header class="topbar">
    <button class="menu-btn" onclick="toggleSidebar()"></button>
    <div class="top-actions">
     
     <a href="logout.php">   <button class="btn danger">Log Out</button></a>
    </div>
  </header>

    
<div class="main">
  <header>
    <h1>Add New User</h1>
    </header>

  <section class="card">
 
                         <form action="" method="post" class="form-horizontal" id="block-validate" enctype="multipart/form-data">
							
        <label>Full Name</label>
        <input type="text" name="full_name" placeholder="Enter full name" required>

        <label>Email</label>
        <input type="email"name="email" placeholder="Enter email" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter password" required>
<label>phone</label>
        <input type="text" name="phone" placeholder="Enter Number Phone" required>

      
  </section><button type="submit" name="addemp"  class="btn btn-danger">Save data</button>
  </section><button type="submit" name="addemp"  class="btn btn-danger">Cancel</button>
   </form>
<script src="js/script.js"></script>
</body>
</html>