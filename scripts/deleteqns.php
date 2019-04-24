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

if(mysqli_query($con,"DELETE FROM qnskey WHERE id = '".$id."' ")) {
	?>
    <script>
	window.history.go(-1);
	</script>
<?php    
}
?>