<?php
session_start();
date_default_timezone_set('Asia/Kolkata');

include_once 'dbconnect.php';

if(isset($_SESSION['usr_type'])!="W") {
	if(isset($_SESSION['usr_type'])!="S") {
		header("Location: ../index.php");
		
	}
}

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

$pass_new = randomPassword();

//PHP IMAGE and DATA VALIDATION

if (isset($_POST['upload_image'])) {
	
	$img_name = "img_";
	$img_name .= $pass_new;
	
	$image = $_FILES['image']['name'];
	
	$temp = explode(".", $_FILES["image"]["name"]);
	$newfilename = round(microtime(true)) . '.' . end($temp);
	
	$target2 = "../uploads/".basename($_FILES['image']['name']);
	$target = "../uploads/".$newfilename;
	
	
	
		if(move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $newfilename)) {
		
			$contentAct = $image." Renamed As <span style=\"color:blue\"> ".$newfilename."</span>  Uploaded Successfully ";
			$successmsg = "Image (".$image.") Uploaded Successfully!!!";
			
			$_SESSION['tmp_img'] = $contentAct;	
			$_SESSION['tmp_img_script'] = "<br><img src=".$link . $newfilename." alt=\"Image\" class=\"img-responsive\" width=\"100%\"><br>" ;
			?>
            <script>
				window.history.go(-1);
			</script>
            <?php			
		} else {
			$errormsg = "Could not upload file...";
		}			

	

}


?>


<html>
<head>
<title>Image Upload</title>
</head>

<body>
<center><h1>Image Upload</h1></center>

</body>
</html>