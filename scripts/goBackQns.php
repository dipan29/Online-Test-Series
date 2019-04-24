<?php
session_start();
include_once 'dbconnect.php';

if($_SESSION['temp_q_id']) {
	$currentQ_code = $_SESSION['temp_q_id'];
	
	$q_no = substr($currentQ_code, -3);
	if($q_no != '001') {
	$back = $q_no - 1;
	$back = str_pad($back, 3, '0', STR_PAD_LEFT);
	
	$url = "../test.php?q_id=".$_COOKIE['test_code']."_".$back;
	header("Location: $url");
	} else {
		?>
        <script>
			window.history.go(-1);
		</script>	
        <?php
	}
}

?>