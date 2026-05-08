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
  <a href="ord.php" class="active">Orders</a>
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
    <h1>order Management</h1>
     </header>

  <section class="card">
    <table>
      <thead>
        <tr>
		<th>ID</th>
          <th>Number Product</th>
          <th>Number order</th>
          <th>price</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr><?php
		$i=1;
$count=1;
$sel_querys="Select * from  order_items ORDER BY order_item_id desc;";
$result3 = mysqli_query($connect,$sel_querys);
while($row3 = mysqli_fetch_assoc($result3)) { ?>			 
                            <tr>
							<td><?php echo $i++ ?></td>
							<td><?php echo $row3["product_id"]; ?></td>
							<td><?php echo $row3["order_id"]; ?></td>
         	 <td><?php echo $row3["price"]; ?></td>
                                <td>
								  <a href="de_ord.php?id=<?php echo $row3['order_item_id']; ?>"  title="Delete"><img src="img/de.png" style="width: 33px;" /></a>
                                  
                                </td>
                            </tr>
                          
     	 					<?php $count--; } ?>	 
      </tbody>
    </table>
  </section>
</div>
<script src="js/script.js"></script>
</body>
</html>