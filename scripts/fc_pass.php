<?php
$message = '';
$resetID = false;

include_once 'dbconnect.php';
include_once 'checkLogin.php';

if(isset($_GET['key'])) {
	$reset_key_get = $_GET['key'];
	$resetID = true;	
}

if(isset($_POST['changePass'])) {
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$password = mysqli_real_escape_string($con, $_POST['password']);
	$cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);	
	
	if($password == $cpassword) {
		if(mysqli_query($con, "UPDATE users SET password = '". hash('sha512',$password) ."' WHERE email = '".$email."' AND reset_key = '".$reset_key_get."' ") ) {
			$message = "Password Updated Successfully!";
		} else {
			$message = "Could Not Update Password! Please Check Data Entered!";
		}
	} else { 
		$message = "Passwords Didn't Match!";
	}
}


setcookie("change_pass_msg", $message, time() + 25, '/');
header("Location: ../forget_pass.php");

?>