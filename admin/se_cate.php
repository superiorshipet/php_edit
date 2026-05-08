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
       <a href="#"  class="active" onclick="toggleMenuk()">Categories </a>
        <div class="dropdown" id="dropdownn">
          <a href="cate.php">View Categories</a>
        </div>
      </div>
<a href="product.php">Products</a>
  <a href="ord.php">Orders</a>
  <button class="menu-btn" onclick="toggleSidebarsss()"></button>
  
         <div class="profile-wrap">
       <a href="#"  onclick="toggleMenusss()">Users </a>
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
    <h1>Add New Category</h1>
    </header>
 <?php 
  
$category_id=$_GET['id'];  
$query = "SELECT * from category where category_id='".$category_id."'";
$result = mysqli_query($connect, $query) or die ( mysqli_error($connect));
$row = mysqli_fetch_assoc($result);
?>


  <section class="card">
 <form action="" method="post" class="form-horizontal" id="block-validate" enctype="multipart/form-data">
<input type="hidden" name="category_id" value="1" />
<input name="category_id" type="hidden" value="<?php echo $row['category_id'];?>" />
        <label>category name </label>
        <input type="text" name="category_name" value="<?php echo $row["category_name"]; ?> "  >
 

       
  </section><a href="cate.php" style="text-decoration: none; color:white"><button type="submit" name="addemp"  class="btn btn-danger">Cancel</a></button>
   </form>
<script src="js/script.js"></script>
</body>
</html>