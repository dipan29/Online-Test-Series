<?php
session_start();
include_once 'dbconnect.php';

if(isset($_GET['key'])) {
	$timeUp = "<center><h1 style=\"color:red\">Your Time Is UP</h1></center><br>";
}

if(isset($_COOKIE['test_code'])) {
	$p_code = $_COOKIE['test_code'];
	$email = $_SESSION['usr_email'];
	$result = mysqli_query($con, "UPDATE s_tests SET end_time = '".$timeNow."', total_correct = '".$_COOKIE['temp_correct']."', total_incorrect = '".$_COOKIE['temp_incorrect']."'  WHERE p_code = '".$p_code."' AND email = '".$email."' ");
	
	if($result) {
		setcookie("test_et",'',time()-10800, '/');  //TIME COOKIE
		setcookie("test_st",'',time()-10800, '/');  //TIME COOKIE
		setcookie("test_code",'',time()-10800, '/'); //TEST CODE COOKIE	
	}
	
	if(isset($timeUp)) {
		echo $timeUp;
	}
	
	echo "<br><br><center><h1>Thank You For Giving The Test </h1></center><br><br>";
	
	echo "<center><h4>Total Correct Choices : ".$_COOKIE['temp_correct']." &nbsp; Total Incorrect Choices : ".$_COOKIE['temp_incorrect']."</h4></center>" ;
	echo "<center><h3>Positive Marks : +".(4*$_COOKIE['temp_correct'])." &nbsp; Negative Marks : -".($_COOKIE['temp_incorrect'])."</h3></center><br><br>";
	
	echo "<center><h2>Your Total Marks = ".(4*$_COOKIE['temp_correct'] - $_COOKIE['temp_incorrect'])."</h2></center><br><br>";
	
	setcookie("temp_correct",'',time()-10800, '/');  //Correct Qns COOKIE
	setcookie("temp_incorrect",'',time()-10800, '/');  //Incorrect COOKIE
	
}else {
	header("Location:../index.php");
}
?>

<center><h3><a href="../index.php">Go Home</a></h3></center>

<span style="bottom:5px"><center>This Test Was Created by <a href="http://mindwebs.org">MinD Webs Team</a></center></span>