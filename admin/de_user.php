<?php
   include('inc/session.php');
?>
<?php
   include('inc/conn.php');
?>
<?php
 $id = $_GET['id'];


mysqli_query($connect,"DELETE FROM orders WHERE user_id='$id'");

mysqli_query($connect,"DELETE FROM users WHERE user_id='$id'");


header("Location:user.php");
exit();
 
?>
