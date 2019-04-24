<?php
session_start();

include_once 'dbconnect.php';

if($_SESSION['usr_type'] != 'W') {
	if($_SESSION['usr_type'] != 'A') {
		header("Location:index.php");
	}
}

if(isset($_GET['id'])) {
	$id = $_GET['id'];
}else{
	?>
    <script>
	window.history.go(-1);
	</script>
<?php    
}

if(mysqli_query($con,"UPDATE tests SET end_date = NULL , enabled = 'N' , start_date = NULL WHERE p_code = '".$id."' ")) {
	?>
    <script>
	window.history.go(-1);
	</script>
<?php    
}
?>