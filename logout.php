<?php require_once('includes/views/header.php');?>
<?php 

$session->logout(); 
redirect("login.php");

?>