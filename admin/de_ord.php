<?php
   include('inc/session.php');
?>
<?php
   include('inc/conn.php');
?>
<?php
 $id = $_GET['id'];


mysqli_query($connect,"DELETE FROM order_items WHERE order_item_id='$id'");


header("Location:ord.php");
exit();
 
?>
