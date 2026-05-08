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
  <a href="#" class="active">Dashboard</a>
    
    <button class="menu-btn" onclick="toggleSidebarsk()"></button>
  
         <div class="profile-wrap">
       <a href="#"  onclick="toggleMenuk()">Categories </a>
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
  <section class="hero">
    <h1>Welcome Back, <?php echo $row["username"]; ?></h1>
    <p>Track your business performance in real time.</p>
  </section>

  <section class="cards">
  		<?php
$count=1;
$sel_query="Select  count(*) AS  user_id from  users ";
$result1 = mysqli_query($connect,$sel_query);
while($row1 = mysqli_fetch_assoc($result1)) { ?>	
    <div class="card"><h3>Users</h3><span><?php echo $row1['user_id']; ?></span></div>
	<?php $count--; } ?>	
	<?php
$count=1;
$sel_query="Select  count(*) AS  order_id from  orders ";
$result1 = mysqli_query($connect,$sel_query);
while($row1 = mysqli_fetch_assoc($result1)) { ?>	
    <div class="card"><h3>Orders</h3><span><?php echo $row1['order_id']; ?></span></div>
	<?php $count--; } ?>	
	<?php
$count=1;
$sel_query="Select  count(*) AS  category_id from  category ";
$result1 = mysqli_query($connect,$sel_query);
while($row1 = mysqli_fetch_assoc($result1)) { ?>	
    <div class="card"><h3>category</h3><span><?php echo $row1['category_id']; ?></span></div>
	<?php $count--; } ?>	
    <?php
$count=1;
$sel_query="Select  count(*) AS  message_id from  contact_messages ";
$result1 = mysqli_query($connect,$sel_query);
while($row1 = mysqli_fetch_assoc($result1)) { ?>	
    <div class="card"><h3>Messages</h3><span><?php echo $row1['message_id']; ?></span></div>
	<?php $count--; } ?>	
    
  </section>

  
</div>

<script src="js/script.js"></script>
</body>
</html>