<?php
session_start();
include_once 'dbconnect.php';

if(isset($_POST['sendEmail'])) {
	$email = mysqli_real_escape_string($con,$_POST['emailto']);
	$sender = $_SESSION['usr_email'];
	$subject = mysqli_real_escape_string($con,$_POST['subject']);
	$content = mysqli_real_escape_string($con,$_POST['content']);
	
	$result = mysqli_query($con, "INSERT INTO notifications(type,target,sent_from,subject,content,time) VALUES('M','".$email."','".$sender."','".$subject."','".$content."','".$timeNow."')");
	if($result) {
		?>
        <script>
			window.history.go(-1);
		</script>
        <?php
	} else {
		echo "Message Not Sent";	
	}
	
}

?>