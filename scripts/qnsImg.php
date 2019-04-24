<?php
session_start();

$errors = "";

if(!isset($_SESSION['count'])) {
$_SESSION['count'] = 1;
$_SESSION['count'] = str_pad($_SESSION['count'], 3, '0', STR_PAD_LEFT);
}

/*
$qnsImageVariable = 'N';
$ansImageVariable = 'N';
*/

$test_set = false;

include_once 'dbconnect.php';

if(!isset($_SESSION['usr_id'])) {
	header("Location:index.php");
}


function randomKey() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 6; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
$time = date("Y-m-d H:i:s");
$t=time();

	//ADD QNS TO DB


if(isset($_POST['sendQns'])) {
	
	if(!empty($_POST["qnsCheck"])) {
		$qnsImageVariable = 'Y';
	} else {
		$qnsImageVariable = 'N';
	}
	
	if(!empty($_POST["ansCheck"])) {
		$ansImageVariable = 'Y';
	} else {
		$ansImageVariable = 'N';
	}
	
/*	
	//IMAGE SECTION
	if(!empty($_POST["qnsCheck"])) { //For Image Option - Question
		$img_name = "qns_";
		$qnsImageName = randomKey();
		$img_name .= $qnsImageName;
	
		$image = $_FILES['qnsImageFile']['name'];
	
		$temp = explode(".", $_FILES["qnsImageFile"]["name"]);
		$newfilename = round(microtime(true)) . '.' . end($temp);
	
		$target = "../uploads/".basename($_FILES['qnsImageFile']['name']);
		
		if(move_uploaded_file($_FILES["qnsImageFile"]["tmp_name"], "../uploads/" . $newfilename)) {
			$question = $newfilename;
			$qnsImageVariable = 'Y';
		} else {
			$errors = "Question Couldnot be uploaded ";
		}
		
	} else {
		$question = mysqli_real_escape_string($con,$_POST['question']);
		$qnsImageVariable = 'N';
	}
	
	if(!empty($_POST["ansCheck"])) { //For Image Option - Answer
		$ansImageVariable = 'Y';
		
		//Option 1
		
			$img_name1 = "ans1_";
			$ansImageName1 = randomKey();
			$img_name1 .= $ansImageName1;
		
			$image1 = $_FILES['ansImageFile1']['name'];
		
			$temp = explode(".", $_FILES["ansImageFile1"]["name"]);
			$newfilename1 = round(microtime(true)) . '.' . end($temp);
			
			if(move_uploaded_file($_FILES["ansImageFile1"]["tmp_name"], "../uploads/" . $newfilename1)) {
				$target1 = "../uploads/".basename($_FILES['ansImageFile1']['name']);
				$opt1 = $newfilename1;
			} else {
			$errors .= "Ans 1 Couldnot be uploaded ";
			}
			
		
		//Option 2
		
			$img_name2 = "ans2_";
			$ansImageName2 = randomKey();
			$img_name2 .= $ansImageName2;
		
			$image2 = $_FILES['ansImageFile2']['name'];
		
			$temp = explode(".", $_FILES["ansImageFile2"]["name"]);
			$newfilename2 = round(microtime(true)) . '.' . end($temp);
		
			if(move_uploaded_file($_FILES["ansImageFile2"]["tmp_name"], "../uploads/" . $newfilename2)) {
				$target2 = "uploads/".basename($_FILES['ansImageFile2']['name']);
				$opt2 = $newfilename2;
			}else {
			$errors .= "Ans 2 Couldnot be uploaded ";
			}
		
		
		//Option 3
		
			$img_name3 = "ans3_";
			$ansImageName3 = randomKey();
			$img_name3 .= $ansImageName3;
		
			$image3 = $_FILES['ansImageFile3']['name'];
		
			$temp = explode(".", $_FILES["ansImageFile3"]["name"]);
			$newfilename3 = round(microtime(true)) . '.' . end($temp);
		
			if(move_uploaded_file($_FILES["ansImageFile3"]["tmp_name"], "../uploads/" . $newfilename3)) {
				$target3 = "uploads/".basename($_FILES['ansImageFile3']['name']);
				$opt3 = $newfilename3;
			}else {
			$errors .= "Ans 3 Couldnot be uploaded ";
			}
		

		//Option 3
		
			$img_name4 = "ans4_";
			$ansImageName4 = randomKey();
			$img_name4 .= $ansImageName4;
		
			$image4 = $_FILES['ansImageFile4']['name'];
		
			$temp = explode(".", $_FILES["ansImageFile4"]["name"]);
			$newfilename4 = round(microtime(true)) . '.' . end($temp);
		
			if(move_uploaded_file($_FILES["ansImageFile4"]["tmp_name"], "../uploads/" . $newfilename4)) {
				$target4 = "uploads/".basename($_FILES['ansImageFile4']['name']);
				$opt4 = $newfilename4;
			}else {
			$errors .= "Ans 4 Couldnot be uploaded ";
			}
		
		
		//End of Answer Upload Section
	
	} else {
		$opt1 = mysqli_real_escape_string($con,$_POST['opt1']);
		$opt2 = mysqli_real_escape_string($con,$_POST['opt2']);
		$opt3 = mysqli_real_escape_string($con,$_POST['opt3']);
		$opt4 = mysqli_real_escape_string($con,$_POST['opt4']);
		$ansImageVariable = 'N';
	} 
*/	
	$qno = mysqli_real_escape_string($con,$_POST['q_code']);
	$question = mysqli_real_escape_string($con,$_POST['question']);
	$opt1 = mysqli_real_escape_string($con,$_POST['opt1']);
	$opt2 = mysqli_real_escape_string($con,$_POST['opt2']);
	$opt3 = mysqli_real_escape_string($con,$_POST['opt3']);
	$opt4 = mysqli_real_escape_string($con,$_POST['opt4']);
	
	$ans = mysqli_real_escape_string($con,$_POST['ans']);
	
	$sendRes = mysqli_query($con, "INSERT INTO qnskey (p_code,q_code,question,opt1,opt2,opt3,opt4,ans,qnsImage,ansImage) VALUES('".$_COOKIE['paperCode']."', '".$qno."', '".$question."', '".$opt1."', '".$opt2."', '".$opt3."', '".$opt4."', '".$ans."', '".$qnsImageVariable."', '".$ansImageVariable."') ");
	
	$_SESSION['count'] = $_SESSION['count'] + 1;
	$_SESSION['count'] = str_pad($_SESSION['count'], 3, '0', STR_PAD_LEFT);
	
	if(isset($_SESSION['tmp_opt1'])) { unset($_SESSION['tmp_opt1']); }
	if(isset($_SESSION['tmp_opt2'])) { unset($_SESSION['tmp_opt2']); }
	if(isset($_SESSION['tmp_opt3'])) { unset($_SESSION['tmp_opt3']); }
	if(isset($_SESSION['tmp_opt4'])) { unset($_SESSION['tmp_opt4']); }

	if(!$errors) {	
	/*
	?>
	<script>
	window.history.go(-1);
	</script>
	<?php
	*/
	//echo "<p><a href=\"../create_test.php\">Question ADDED!!! GO BACK </p>";
	header("Location: ../create_test.php");
	} else {
		echo $errors;
	}
}
?>	