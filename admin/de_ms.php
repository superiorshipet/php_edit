<?php
   include('inc/session.php');
?>
<?php
   include('inc/conn.php');
?>
<?php
 $id = $_GET['id'];


mysqli_query($connect,"DELETE FROM contact_messages WHERE message_id='$id'");


header("Location:masge.php");
exit();
 
?>
