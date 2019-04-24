<?php
session_start();

include_once 'dbconnect.php';

if(!isset($_SESSION['usr_id'])) {
	header("Location:index.php");
}

if($_SESSION['usr_type'] == 'S') {
	header("Location:index.php");
}

if(isset($_GET['id'])) {
	$id = $_GET['id'];
} else {
	header('Location:users.php');
}

$query = mysqli_query($con, "SELECT * FROM users WHERE id = '".$id."' ");
$qRow = $query->fetch_assoc();
if($query->num_rows > 0) {

} else {
	header('Location:users.php');
}

$error = false;
$email_address = $myEmail;

//check if form is submitted 
if (isset($_POST['register'])) {
	
	$name = mysqli_real_escape_string($con, $_POST['name']);
	$email = $qRow['email'];
	$password = mysqli_real_escape_string($con, $_POST['password']);
	$cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
	$dob = mysqli_real_escape_string($con, $_POST['dob']);
	$phone = mysqli_real_escape_string($con, $_POST['phone']);
	$gender = mysqli_real_escape_string($con, $_POST['gender']);
	$type = mysqli_real_escape_string($con, $_POST['type']);
	$class = mysqli_real_escape_string($con, $_POST['class']);
	
	
	if(!$password) {
		if(mysqli_query($con, "UPDATE users SET name = '".$name."', dob = '".$dob."', phone = '".$phone."', gender = '".$gender."', type = '".$type."', class = '".$class."' WHERE email = '".$email."' " )) {

			$successmsg = "Successfully Updated!!!";
		}
	} else {

	
		if($password != $cpassword) {
			$error = true;
		}
		
		if (!$error) {
			
			if(mysqli_query($con, "UPDATE users SET name = '".$name."', password = '".hash('sha512',$password)."', dob = '".$dob."', phone = '".$phone."', gender = '".$gender."', type = '".$type."', class = '".$class."', login_hash = NULL WHERE email = '".$email."' " )) {
	
				$successmsg = "Successfully Updated!!!";
				
				//Mailing Part
			$to = $email;
			$subject = 'Security - Password Reset At '.$siteName;
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
			$message .= '<p style="font-size:18px;">This is an automated mail, done on generation of the Admin</p>';
			$message .= '<p>Your Account is still secure and safe! Your Current Password is : '.$password.' , Please Change it As Soon As Possible</p>';
			$message .= '<br><p style="font-size:14px;">Please Click on this link, and complete the rest of the procedure after Login!</p>';
			$message .= '<p style="font-size:14px;"><a href="'.$siteUrl.'">Open Your Panel</a></p><br>';
			$message .= '<br><hr><p><a href="'.$siteUrl.'">'.$siteNameFull.'</a></p><p style="font-size:10px;"> | MinD Webs Team</p>';
			$message .= '<p style="font-size: 10px;">For any queries or request, please mail to administrator@mindwebs.org</p>';
			$message .= '</body></html>';
			 
			// Sending email
			mail($to, $subject, $message, $headers);
	
			} else {
				$errormsg = "Error in Updating ...Please try again later! (Quote: DATABASE Error)";
			}
		}
	}
}


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $siteNameShort; ?> | Admin Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="theme-color" content="#3498db">
  <link rel="icon" href="favicon.png">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><?php echo $sNameShortMenu; ?></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><?php echo $sNameMenu; ?></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

     <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <?php 
		  {
				$query = mysqli_query($con, "SELECT * FROM notifications WHERE type = 'M' AND target IN ('".$_SESSION['usr_email']."', 'ADMIN', 'ALL') ");		
				$count = 0;
				
				if($query->num_rows > 0) {
					while ( $tempRow = $query->fetch_assoc()){
						if($tempRow['seen']=='N' && $tempRow['expired'] == 'N')
							$count++;
					}
				}
				
		  ?>
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success"><?php echo $count; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <?php echo $count; ?> new messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">


              <?php 
			  $query = mysqli_query($con, "SELECT * FROM notifications WHERE type = 'M' AND target IN ('".$_SESSION['usr_email']."', 'ADMIN', 'ALL') ");
			  $countR = $query->num_rows;
			  if($countR > 0) {
					while($row = $query->fetch_assoc()){
						if($row['seen']=='N' && $row['expired'] == 'N'){
              ?>
                  <li><!-- start message -->
                    <a href="<?php if( ($row['target'] == 'ADMIN') || ($row['target'] == 'ALL') ) echo '#'; else echo 'scripts/nSeen.php?id='.$row['id']; ?>">
                      <div class="pull-left">
                        <img src="dist/img/mail.png" class="img-circle" alt="User Image">
                        <!---<i class="fa fa-mail-forward"></i>-->
                      </div>
                      <h4>
                        <?php echo $row['subject']; ?>
                        <small><i class="fa fa-clock-o"></i> <?php echo $row['time']; ?></small>
                      </h4>
                      <p><?php echo $row['content']; ?></p>
                    </a>
                  </li>
                  <!-- end message -->
                  </a>
              <?php
						}
					}
			  }
			  ?>
              </ul>
              </li>
              <li class="footer"><a href="notifications.php">See All Messages</a></li>
            </ul>
          </li>
          <?php 
		  }
		  ?>
          <!-- Notifications: style can be found in dropdown.less -->
          <?php 
		  {
				$query = mysqli_query($con, "SELECT * FROM notifications WHERE type = 'N' AND target IN ('".$_SESSION['usr_email']."', 'ADMIN', 'ALL') ");		
				$count = 0;
				
				if($query->num_rows > 0) {
					while ( $tempRow = $query->fetch_assoc()){
						if($tempRow['seen']=='N' && $tempRow['expired'] == 'N')
							$count++;
					}
				}
				
		  ?>          
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"><?php echo $count; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <?php echo $count; ?> notifications</li>
              <li>
                <ul class="menu">


              <?php 
			  $query = mysqli_query($con, "SELECT * FROM notifications WHERE type = 'N' AND target IN ('".$_SESSION['usr_email']."', 'ADMIN', 'ALL') ");
			  $countR = $query->num_rows;
			  if($countR > 0) {
					while($row = $query->fetch_assoc()){
						if($row['seen']=='N' && $row['expired'] == 'N'){
              ?>
                  <li><!-- start message -->
                    <a href="<?php if( ($row['target'] == 'ADMIN') || ($row['target'] == 'ALL') ) echo '#'; else echo 'scripts/nSeen.php?id='.$row['id']; ?>">

                      <h4>
                        <?php echo $row['subject']; ?>
                        <small><i class="fa fa-clock-o"></i> <?php echo $row['time']; ?></small>
                      </h4>
                      <p><?php echo $row['content']; ?></p>
                    </a>
                  </li>
                  <!-- end message -->
                  </a>
              <?php
						}
					}
			  }
			  ?>
              </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <?php 
		  }
		  ?>          
          <!-- Tasks: style can be found in dropdown.less -->
          <?php 
		  {
				$query = mysqli_query($con, "SELECT * FROM notifications WHERE type = 'T' AND target IN ('".$_SESSION['usr_email']."', 'ADMIN', 'ALL') ");		
				$count = 0;
				
				if($query->num_rows > 0) {
					while ( $tempRow = $query->fetch_assoc()){
						if($tempRow['seen']=='N' && $tempRow['expired'] == 'N')
							$count++;
					}
				}
				
		  ?>    
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger"><?php echo $count; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <?php echo $count; ?> tasks</li>
              <li>
                <ul class="menu">


              <?php 
			  $query = mysqli_query($con, "SELECT * FROM notifications WHERE type = 'T' AND target IN ('".$_SESSION['usr_email']."', 'ADMIN', 'ALL') ");
			  $countR = $query->num_rows;
			  if($countR > 0) {
					while($row = $query->fetch_assoc()){
						if($row['seen']=='N' && $row['expired'] == 'N'){
              ?>
                  <li><!-- start message -->
                    <a href="<?php if( ($row['target'] == 'ADMIN') || ($row['target'] == 'ALL') ) echo '#'; else echo 'scripts/nSeen.php?id='.$row['id']; ?>">

                      <h4>
                        <?php echo $row['subject']; ?>
                        <small><i class="fa fa-clock-o"></i> <?php echo $row['time']; ?></small>
                      </h4>
                      <p><?php echo $row['content']; ?></p>
                    </a>
                  </li>
                  <!-- end message -->
                  </a>
              <?php
						}
					}
			  }
			  ?>
              </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li>
          <?php 
		  }
		  ?> 
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php if($_SESSION['usr_type'] == 'W') { ?>
              	<img src="dist/img/W.png" class="user-image" alt="Webmaster">
              <?php } else if($_SESSION['usr_type'] == 'A') { ?>
              	<img src="dist/img/A.jpg" class="user-image" alt="Administrator">
              <?php } else { ?>
              	<img src="dist/img/S.jpg" class="user-image" alt="Student">
              <?php } ?>
              <span class="hidden-xs"><?php echo $_SESSION['usr_name'] ; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <?php if($_SESSION['usr_type'] == 'W') { ?>
            <img src="dist/img/W.png" class="img-circle" alt="Webmaster">
          <?php } else if($_SESSION['usr_type'] == 'A') { ?>
            <img src="dist/img/A.jpg" class="img-circle" alt="Administrator">
          <?php } else { ?>
            <img src="dist/img/S.jpg" class="img-circle" alt="Student">
          <?php } ?>

                <p>
                  <?php echo $_SESSION['usr_name'] ; ?>
                  <small>Last Login - <?php echo $_SESSION['usr_time'];?></small>
                </p>
              </li>
              <!-- Menu Body -->

              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <?php if($_SESSION['usr_type'] == 'W') { ?>
            <img src="dist/img/W.png" class="img-circle" alt="Webmaster">
          <?php } else if($_SESSION['usr_type'] == 'A') { ?>
            <img src="dist/img/A.jpg" class="img-circle" alt="Administrator">
          <?php } else { ?>
            <img src="dist/img/S.jpg" class="img-circle" alt="Student">
          <?php } ?>
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['usr_name'] ; ?></p>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="">
          <a href="index">
            <i class="fa fa-dashboard"></i> <span>HOME</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>USERS</span>
			<span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="users.php"><i class="fa fa-eye"></i> View Users</a></li>                      
            <li class=""><a href="register.php"><i class="fa fa-plus"></i> Register New User</a></li>
          </ul>
        </li>
       	<li class="treeview">
          <a href="#">
            <i class="fa fa-question"></i>
            <span>TESTS</span>
			<span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="view_tests.php"><i class="fa fa-eye"></i> View Tests</a></li>                      
            <li><a href="create_test.php"><i class="fa fa-plus"></i> Create Test</a></li>
          </ul>
        </li>
        <li>
          <a href="resultsAdmin.php">
            <i class="fa fa-pie-chart"></i>
            <span>VIEW RESULTS</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
          <a href="topics">
            <i class="fa fa-edit"></i> <span>TOPICS</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
          <a href="notices.php">
            <i class="fa fa-table"></i> <span>NOTICES</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
        <!--Make Separate For Admin and Students Nill-->
          <a href="notificationsAdmin.php">
            <i class="fa fa-bell"></i> <span>NOTIFICATIONS</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
          <a href="settings.php">
            <i class="fa fa-wrench"></i> <span>SETTINGS</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
          <a href="aboutUs.php">
            <i class="fa fa-info"></i> <span>ABOUT US</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-users"></i>Dashboard</a></li>
        <li>Update User</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Main row -->
      <div class="row">
      <?php
	  $queryEdit = mysqli_query($con, "SELECT * FROM users WHERE id = '".$id."' ");
	  $rowEdit = $queryEdit->fetch_assoc();
	  ?>
      	<section class="col-lg-12 connectedSortable">
           
          <div class="box box-primary">
            <div class="box-header">            

              <i class="fa fa-user"></i>

              <h3 class="box-title">
                Update User - <strong><?php echo $rowEdit['name']; ?></strong>
              </h3>
            </div>
            <div class="box-body">
            
            	<div class="row">
                <div class="col-lg-12">
                <form role="form" name="registerform" action="<?php echo $_SERVER['PHP_SELF'];  ?>?id=<?php echo $id; ?>" method="post">
                	<div class="input-group">
                		<span class="input-group-addon"><i class="fa fa-user"></i></span>
                		<input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo $rowEdit['name']; ?>">
              		</div> 
                    <br>
					<div class="input-group">
                		<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                		<input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $rowEdit['email']; ?>" disabled>
              		</div> 
                    <br>
					<div class="input-group">
                		<span class="input-group-addon"><i class="fa fa-lock"></i></span>
                		<input type="password" name="password" class="form-control" placeholder="Generate New Password, leave Blank for No Change">
              		</div>
                    <br>
					<div class="input-group">
                		<span class="input-group-addon"><i class="fa fa-lock"></i></span>
                		<input type="password" name="cpassword" class="form-control" placeholder="Confirm New Password, leave Blank for No Change">
              		</div> 
                    <br>
					<div class="input-group">
                		<span class="input-group-addon"><i class="fa fa-phone"></i></span>
                		<input type="text" name="phone" class="form-control" placeholder="Phone" value="<?php echo $rowEdit['phone']; ?>">
              		</div> 
                    <br>
					<div class="input-group">
                		<span class="input-group-addon"><i class="fa fa-archive"></i></span>
                		<input type="text" name="class" class="form-control" placeholder="Class" value="<?php echo $rowEdit['class']; ?>">
              		</div> 
                    <br>
                    <div class="input-group">
                		<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                		<input type="text" name="dob" class="form-control" placeholder="DOB (dd/mm/yyyy)" maxlength="10" value="<?php echo $rowEdit['dob']; ?>">
              		</div>                    
                    <br>
                    <div class="row">
                    	<div class="col-lg-6">
                            <div class="input-group">
        
                                <label>Gender : </label> &nbsp;
                                <select name="gender">
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                    <option value="OR">Others</option>	
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group">
                                <label>User Type : </label> &nbsp;
                                <select name="type">
                                <?php if(($_SESSION['usr_type'] == 'W') && ($_SESSION['usr_email'] == "dipanroy12@gmail.com")) { ?>
                                    <option value="W">Web-Master</option>
                                <?php } ?>
                                    <option value="A">Administrator</option>
                                    <option value="S" selected>Student</option>	
                                </select>
                            </div>
                        </div>
                    </div>
  					<br>
                    <div class="box-footer">
                    <div class="col-lg-6 col-xs-6 text-center">
                		<button type="submit" name="register" class="btn btn-success">Update</button>
                    </div>
                    <div class="col-lg-6 col-xs-6 text-center">
                		<button type="reset" class="btn btn-primary">Reset</button>
                    </div>
              		</div>
                </form>
                <?php if(isset($successmsg)) { echo $successmsg; }else if(isset($errormsg)) { echo $errormsg; } ?>
                </div>
            	</div>
                
            </div>

          </div>

        </section>

      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
    <strong><?php echo $footer; ?></strong>
  </div>
</div>
</div>
  </footer>

  <!-- Control Sidebar -->
  
  <aside class="control-sidebar control-sidebar-dark">
    
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    
    <div class="tab-content">
      
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <!--<li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          -->
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
       

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <!--<li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>-->
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        

      </div>
      
      
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
         

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
            
        </form>
      </div>
      
    </div>
  </aside>

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="bower_components/raphael/raphael.min.js"></script>
<script src="bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>
