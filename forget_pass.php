<?php
session_start();
include_once 'dbconnect.php'; 

if(isset($_SESSION['usr_id'])!="") {
	header("Location: index");
}

$message = '';
$resetID = false;

if(isset($_GET['key'])) {
	$reset_key_get = $_GET['key'];
	$resetID = true;	
}

function randomNo1() {
    $alphabet = '0123456789';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 1; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
function randomNo2() {
    $alphabet = '0123456789';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 2; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 64; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

if(isset($_POST['forgetPass'])) {

		$emailF = mysqli_real_escape_string($con, $_POST['emailF']);
		$reset_key = randomPassword();
		$result = mysqli_query($con, "UPDATE users SET reset_key = '".$reset_key."' WHERE email = '".$emailF."' ");
		if($result) {
			//Mailing Part
			$to = $emailF;
			$subject = 'Password Reset Request At '.$siteName;
			$from = 'administrator@mindwebs.org';
			 
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			 
			// Create email headers
			$headers .= 'From: M W OTS <'.$from. '>'."\r\n".
				'Reply-To: '.$from."\r\n" .
				'X-Mailer: PHP/' . phpversion();
			 
			// Compose a simple HTML email message
			$message = '<html><body>';
			$message .= '<h1>Password Reset!</h1>';
			$message .= '<p style="font-size:18px;">This is an automated mail, delivered on your request of password reset</p>';
			$message .= '<br><p style="font-size:14px;">Please Click on this link, and complete the rest of the procedure!</p>';
			$message .= '<p style="font-size:14px;"><a href="'.$siteUrl.'/forget_pass.php?key='.$reset_key.'">Reset Your Password</a></p><br>';
			$message .= '<p>If You did not make this request, ignore this email, Your Account is still secure and safe!</p>';
			$message .= '<br><hr><p><a href="'.$siteUrl.'">'.$siteNameFull.'</a></p><p style="font-size:10px;"> | MinD Webs Team</p>';
			$message .= '<p style="font-size: 10px;">For any queries or request, please mail to administrator@mindwebs.org</p>';
			$message .= '</body></html>';
			 
			// Sending email
			mail($to, $subject, $message, $headers);
			//Come_Back
			$message = "Please Check Your Email, And Follow The Procedures Over There!";
		} else {
			$message = "Please Retry Again!";
		}

}


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> <?php echo $siteNameFull; ?> | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><?php echo $siteName; ?></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    

		<?php if(!$resetID) { ?>
            <div class="col-lg-12">
                <p class="login-box-msg">Fill Up To Reset</p>
                <br>
                <form name="forgetPassForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <label>Email : </label>
                        <input type="email" class="form-control" name="emailF" placeholder="Enter Your Email"  required>
                        &nbsp;
                    </div>
                   
                    </div>
                    <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <center><input type="submit" name="forgetPass" class="btn btn-lg btn-success" value="Submit"></center>
                    </div>
                    </div>
                    <?php
                    if(isset($message)) {
                        echo $message;
                    }
                    
                    ?>
                </form> 
            </div>                
        <?php } else { ?>
            <div class="col-lg-12">
                <p class="login-box-msg">Change Your Password</p>
                <br>
                <form name="changePassForm" action="<?php echo "scripts/fc_pass.php?key=".$reset_key_get; ?>" method="post">
                    <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <label>Email : </label>
                        <input type="email" class="form-control" name="email" placeholder="Enter Your Email"  required>
                        &nbsp;
                    </div>
                    <div class="col-md-12 col-xs-12">
                        <label>Enter New Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter Your Password" required>
                        &nbsp;
                    </div>
                    <div class="col-md-12 col-xs-12">
                        <label>Confirm You Password</label>
                        <input type="password" class="form-control" name="cpassword" placeholder="Confirm Your Password" required>
                        &nbsp;
                    </div>                                    
                    </div>
                    <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <center><input type="submit" name="changePass" class="btn btn-lg btn-success" value="Change"></center>
                    </div>
                    </div>
                    <?php
                    if(isset($message)) {
                        echo $message;
                    }
                    
                    ?>
                </form> 
            </div>
        <?php } ?>
                    <?php
                    if(isset($_COOKIE['change_pass_msg'])) {
                        ?>
                        <script>
                            alert("<?php echo $_COOKIE['change_pass_msg']; ?>");
                        </script>
                        <?php
                    }
                    
                    ?>
   

	<i class="fa fa-backward"></i> <a href="login">Back To Login</a>
 <br><br>
    <center><span class="fa fa-info"> Powered By <a href="http://mindwebs.org">MinD Webs</a></span></center> 

  </div>
  <!-- /.login-box-body -->  
</div>
<!-- /.login-box -->
<center><?php echo $footer; ?></center>

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
