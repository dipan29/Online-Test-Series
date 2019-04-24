<?php
include_once 'dbconnect.php';
session_start();

$email0 = 'mindwebsteam@gmail.com';
$email1 = $ourMail;

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

$pass = "123456";

$id = $_GET['id'];

			$result = mysqli_query($con, "SELECT * FROM users WHERE id = '".$id."' ");
			$row = $result->fetch_assoc();
			$email = $row['email'];
			
			$reset_key = randomPassword();
			$result = mysqli_query($con, "UPDATE users SET reset_key = '".$reset_key."', password = '".hash('sha512', $pass)."' WHERE email = '".$email."' ");	
		
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
			$message .= '<p>Your Account is still secure and safe! Your Current Password is : 123456 , Please Change it As Soon As Possible</p>';
			$message .= '<br><p style="font-size:14px;">Please Click on this link, and complete the rest of the procedure!</p>';
			$message .= '<p style="font-size:14px;"><a href="'.$siteUrl.'/forget_pass.php?key='.$reset_key.'">Reset Your Password</a></p><br>';
			$message .= '<br><hr><p><a href="'.$siteUrl.'">'.$siteNameFull.'</a></p><p style="font-size:10px;"> | MinD Webs Team</p>';
			$message .= '<p style="font-size: 10px;">For any queries or request, please mail to administrator@mindwebs.org</p>';
			$message .= '</body></html>';
			 
			// Sending email
			mail($to, $subject, $message, $headers);
		?>
        <script>
			window.history.go(-1);
		</script>
        <?php
	
	

?>