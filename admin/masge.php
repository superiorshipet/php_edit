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
       <a href="#"  onclick="toggleMenusss()" >Users </a>
        <div class="dropdown"  id="dropdown1">
          <a href="user.php" >View Users</a>
        </div>
      </div>
  <a href="masge.php"class="active">Messages</a>
   
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
    <h1>Messages Management</h1>
  </header>

  <section class="card">
    <table>
      <thead>
        <tr>
		<th>ID</th>
          <th>Name</th>
          <th>Massage</th>
          <th>date sent</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr><?php
		$i=1;
$count=1;
$sel_querys="Select * from  contact_messages ORDER BY message_id  desc;";
$result3 = mysqli_query($connect,$sel_querys);
while($row3 = mysqli_fetch_assoc($result3)) { ?>			 
                            <tr>
							<td><?php echo $i++ ?></td>
							<td><?php echo $row3["name"]; ?></td>
							<td><?php echo $row3["message"]; ?></td>
         	 <td><?php echo $row3["date_sent"]; ?></td>
                                <td>
								<a href="de_ms.php?id=<?php echo $row3['message_id']; ?>"  title="Delete"><img src="img/de.png" style="width: 33px;" /></a>
                                  
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