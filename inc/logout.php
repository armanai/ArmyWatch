<?php 
	session_start();
	include_once('LIB_project1.php'); 

	$_SESSION['loggedin'] = null;
	redirect_to("../login.php");


?>