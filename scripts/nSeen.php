<?php

session_start();
include_once 'dbconnect.php';

$id = $_GET['id'];

$result = mysqli_query($con, "UPDATE notifications SET seen = 'Y' WHERE id = '".$id."' ");

?>
<script>
	window.history.go(-1);
</script>

<?
?>