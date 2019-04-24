<?php
session_start();
include_once 'dbconnect.php'; 

if(isset($_SESSION['usr_id'])!="") {
	header("Location: index");
}

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 32; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
$time = date("Y-m-d H:i:s");
$t=time();
$hash = randomPassword();
$key = $hash;
$key.=$t;

//check if form is submitted
if (isset($_POST['login'])) {

	$email = mysqli_real_escape_string($con, $_POST['email']);
	$password = mysqli_real_escape_string($con, $_POST['password']);
	
	$result = mysqli_query($con, "SELECT * FROM users WHERE email = '" . $email. "' and password = '" . hash('sha512', $password) . "'");

	if ($row = mysqli_fetch_array($result)) {
		$_SESSION['usr_id'] = $row['id'];
		$_SESSION['usr_name'] = $row['name'];
		$_SESSION['usr_email'] = $row['email'];
		$_SESSION['usr_time'] = $row['last_login'];
		$_SESSION['usr_phone'] = $row['phone'];
		$_SESSION['usr_gender'] = $row['gender'];
		$_SESSION['usr_dob'] = $row['dob'];
		$_SESSION['usr_type'] = $row['type'];
		$_SESSION['usr_class'] = $row['class'];
		$temp_key = $row['login_hash'];

		
		if(!empty($_POST["remember"])) {
			if($temp_key == NULL){
				if(mysqli_query($con, "UPDATE users SET last_login = '" .$timeNow. "' , login_hash = '" .$key."' WHERE email = '" . $email. "' and password = '" . hash('sha512', $password) . "' ")){
					setcookie ("hash",$key,time()+ 15552000, '/');	
					}
			
			} else {
				if(mysqli_query($con, "UPDATE users SET last_login = '" .$timeNow. "' WHERE email = '" . $email. "' and password = '" . hash('sha512', $password) . "' ")){
					setcookie ("hash",$temp_key,time()+ 15552000, '/');	
				}
			} 
		} else {
				if(mysqli_query($con, "UPDATE users SET last_login = '" .$timeNow. "' WHERE email = '" . $email. "' and password = '" . hash('sha512', $password) . "' ")){		
					echo "Login Success!!! Redirecting in A Moment...";			
				}
			}
		
		header("Location: index.php");
		
		} else {
		$errormsg = "Incorrect Email or Password!!!";
		?>
        <script>
			alert("You Have Entered An Incorrect Password! Please Try Again") ;
			document.getElementById("loginform").reset();
		</script>
        
        <?php
		
		}
}  // END OF if (isset($_POST['login']))

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
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="<?php echo $_SERVER['PHP_SELF'];  ?>" name="loginform" id="loginform" method="post">
      <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input name="remember" type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  <a href="forget_pass.php">I forgot my password!</a><br>
 <br>
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
