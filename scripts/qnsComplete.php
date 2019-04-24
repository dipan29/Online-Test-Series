<?php
session_start();

$id = $_COOKIE['paperCode'];

unset($_SESSION['count']);
setcookie("paperCode", "", time()-28800, '/');

if($id) {
header("Location:../view_questions.php?id=$id");
} else {
	header("Location:../create_test.php");
}
?>