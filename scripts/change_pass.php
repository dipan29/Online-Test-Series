<?php

$message = '';

session_start();
include_once 'dbconnect.php';

if(isset($_SESSION['usr_id'])!="") {
	header("Location: ../index.php");
}

if(isset($_POST['changePass'])) {
	$email = $_SESSION['usr_email'];
	$old_pass = mysqli_real_escape_string($con, $_POST['old_password']);
	$new_pass = mysqli_real_escape_string($con, $_POST['new_password']);
	$cnew_pass = mysqli_real_escape_string($con, $_POST['cnew_password']);
	
	if($new_pass == $cnew_pass) {
		$testResult = mysqli_query($con, "SELECT * FROM users WHERE email = '".$email."' AND password = '". hash('sha512',$old_pass) ."' ");
		if($testResult->num_rows > 0) {
			$result = mysqli_query($con, "UPDATE users SET password = '". hash('sha512',$new_pass) ."' WHERE  email = '".$email."' ");
			$message = "Your Password Has Been Updated Successfully! Thank You!";
		} else {
			$message = "Please Check Your Entered Details, Your Old Password Didn't Match. You may ask for a new password! Could Not Update Password!";
		}
	} else {
		$message = "New And Old Password Did Not Match! Could Not Update Password!";
	}
	
	if($message) {
		setcookie("change_pass_msg", $message, time() + 25, '/');
		header("Location: ../settings.php");
	}
	
}

?>