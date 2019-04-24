<?php
session_start();
include_once 'dbconnect.php';

if(isset($_POST['ansNext'])) {
	$currentQ_code = $_SESSION['temp_q_id'];
	
	$q_no = substr($currentQ_code, -3);
	$next = $q_no + 1;
	$next = str_pad($next, 3, '0', STR_PAD_LEFT);
	
	$ans = $_POST['ans'];
	
	$result = mysqli_query($con, "SELECT * FROM qnskey WHERE q_code = '".$currentQ_code."' ");	
	if ($row = mysqli_fetch_array($result)) {
		$ansKey = $row['ans'];
	}
	
	if($ans != '') {
		//SELECT * FROM S_ANS SUCH THAT NO QUERY EXISTS THEN START THE FOLLOWING IF..ELSE
		$tempRes = mysqli_query($con, "SELECT * FROM s_ans WHERE q_code = '".$currentQ_code."' AND email = '".$_SESSION['usr_email']."' ");
		if($tempRes->num_rows > 0) {
			//IGNORE
		}else{
		if($ans == $ansKey){
			$currentVal = $_COOKIE['temp_correct'];
			$newVal =  $currentVal + 1;
			setcookie("temp_correct",$newVal,time() + 28000 ,'/');	
		} else {
			$currentVal = $_COOKIE['temp_incorrect'];
			$newVal =  $currentVal + 1;
			setcookie("temp_incorrect",$newVal,time() + 28000 ,'/');
		}
		}
		
		$newQuery = mysqli_query($con, "INSERT INTO s_ans(q_code,email,time,answer) VALUES('".$currentQ_code."', '".$_SESSION['usr_email']."', '".$timeNow."', '".$ans."') ON DUPLICATE KEY UPDATE answer = '".$ans."' ");
		if($newQuery) {
			$url = "../test.php?q_id=".$_COOKIE['test_code']."_".$next;
			header("Location: $url");
		}else{
			echo "SOME ERROR OCCURED! PLEASE GO BACK";
		}
	} else {
		$url = "../test.php?q_id=".$_COOKIE['test_code']."_".$next;
		header("Location: $url");
	}
}

?>