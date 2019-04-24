<?php
session_start();
include_once 'dbconnect.php';

$errors = '';

if(isset($_GET['id'])) {
	$p_code = $_GET['id'] ;
}
$email = $_SESSION['usr_email'];

$result1 = mysqli_query($con,"SELECT * FROM tests WHERE p_code = '".$p_code."' ");
$row1 = $result1->fetch_assoc();

//VALIDATION

if(($row1['class'] == 0) || ($row1['class'] == $_SESSION['usr_class'])) {
	// DO NOTHING MUCH HERE
} else {
	$errors = "NOT FOR YOUR CLASS";
}

if($row1['enabled'] == 'N') {
	$errors = "This Test Is Yet Not Enabled!!!";
}

//INSERT TEST TO STUDENT GIVEN TEST

if(mysqli_query($con, "INSERT INTO s_tests(p_code,email,start_time) VALUES('" . $p_code . "', '" . $email . "', '" . $timeNow . "')" )) {
	//Test Inserted Successfully
}else {
	$errors = "Test Not Inserted";
}

//GET TIME LIMIT AND SET COOKIE

$timeLimit = $row1['time']; //IN MINUTES
$timeSec = $timeLimit * 60;
$addTime = "+".$timeLimit." minutes";
$currentTime = $timeNow;
$startTime = date("Y-m-d h:i:s");

$endTime = strtotime($addTime,strtotime($currentTime));

setcookie("test_et",$endTime,time()+ $timeSec, '/');  //TIME COOKIE
setcookie("test_st",$startTime,time()+ $timeSec, '/');  //TIME COOKIE
setcookie("test_code",$p_code,time()+ $timeSec+15, '/'); //TEST CODE COOKIE



//TRANSFER TO TEST PAGE
if(!$errors) {
	$url = "../test.php?p_code=".$p_code;
	header("Location: $url");
} else {
	echo nl2br("Could Not Start Test!!! Some Error Occoured\n\n");
	echo nl2br("Error Details ----------------\n");
	echo $errors;
	echo nl2br("\n\n");
}

?>
<a href="javascript:history.back()">GO BACK</a>