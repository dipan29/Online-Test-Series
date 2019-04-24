<?php
session_start();
date_default_timezone_set('Asia/Kolkata');

include_once 'dbconnect.php';


if(isset($_GET['id'])){
	$id = $_GET['id'];
	
	if(mysqli_query($con, "DELETE from users WHERE id = '" .$id. "'")) {
	?>
    	<script>
		window.history.go(-1);
		</script>
    <?php
	} else {
	?>
		<script>
			alert("Could Not Delete The Same.. Please Try Again!!!");
		</script>	
    <?php
	}
}
?>

<a href="../register.php">GO BACK</a>