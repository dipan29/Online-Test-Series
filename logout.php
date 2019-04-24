<?php
session_start();

include_once 'dbconnect.php';



if(isset($_SESSION['usr_id'])) {
	session_destroy();	
	setcookie ("hash", '',time()-3600, '/');
	unset($_SESSION['usr_id']);
	unset($_SESSION['usr_name']);
	unset($_SESSION['usr_class']);
	unset($_SESSION['usr_time']);
	unset($_SESSION['usr_email']);
	unset($_SESSION['usr_phone']);
	unset($_SESSION['usr_gender']);
	unset($_SESSION['usr_dob']);
	unset($_SESSION['usr_type']);
	header("Location: index.php");
} 
?>