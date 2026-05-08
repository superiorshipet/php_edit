 <?php
   include('inc/session.php');
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
 <?php 
  
$user_id=$_GET['id'];  
$query = "SELECT * from users where user_id='".$user_id."'";
$result = mysqli_query($connect, $query) or die ( mysqli_error($connect));
$row = mysqli_fetch_assoc($result);
?>

   <?php
$status = "";
if(isset($_POST['new']))
{
	$id=$_GET['id'];
 
  $full_name=@$_POST['full_name'];
 $password=@$_POST['password']; 
  $phone=@$_POST['phone'];  
    $email=@$_POST['email'];  
$update="update users set 
full_name='".$full_name."',
password='".$password."',
email='".$email."',
phone='".$phone."' 
  where user_id='".$id."'";
$result = mysqli_query($connect,$update) or die ( mysqli_error($connect));
  echo"<script>window.open('user.php','_self')</script>";
}else {
	?>
  <section class="card">
 <form action="" method="post" class="form-horizontal" id="block-validate" enctype="multipart/form-data">
							<input type="hidden" name="new" value="1" />
<input name="new" type="hidden" value="<?php echo $row['user_id'];?>" />
        <label>Full Name</label>
        <input type="text" name="full_name" value="<?php echo $row["full_name"]; ?> "  >

        <label>Email</label>
        <input name="email" value="<?php echo $row["email"]; ?> "  >

        <label>Password</label>
        <input type="text" name="password" value="<?php echo $row["password"]; ?> " >
<label>phone</label>
        <input type="text" name="phone" value="<?php echo $row["phone"]; ?> " >

       
  </section>
    <button type="submit" name="new"  class="btn btn-danger">حفظ البيانات</button>
  <a href="user.php" style="text-decoration: none; color:white"><button type="submit" name="addemp"  class="btn btn-danger">Cancel</a></button>
   </form>
   
							<?php } ?>
<script src="js/script.js"></script>
</body>
</html>