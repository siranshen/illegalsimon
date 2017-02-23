<?php
	include("connection.php");

	function sendMail($email, $username, $password) {
		$to = $email;
		$subject = 'Password Reset';

		$bound_text = "----*%$!$%*";
		$bound = "--".$bound_text."\r\n";
		$bound_last = "--".$bound_text."--\r\n";

		$headers = "From: noreply@illegalsimon.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n" .
		"Content-Type: multipart/mixed; boundary=\"$bound_text\""."\r\n" ;

		$content = " you may wish to enable your email program to accept HTML \r\n".$bound;

		$content .=
		'Content-Type: text/html; charset=UTF-8'."\r\n".
		'Content-Transfer-Encoding: 7bit'."\r\n\r\n".
		'
		<body bgcolor="#FFFFFF" style="letter-spacing:0.2px;">
		</br>
		<div style="align:left">
			<font size="3" color="#000000" style="text-decoration:none;font-family:Arial, Helvetica, sans-serif">
				<div class="info" style="align:left; margin-bottom:4px;">
					<h4>Hi '.$username.',</h4>				
					<p>Your temporary password is: '.$password.'</p>
					<p>Please note that this password will expire in 24 hours.</p>
					<p>Follow <a href="https://illegalsimoncom.ipage.com/resetpwd.php?temp=1">this link</a> to reset your password. Put the above temporary password in the "old password" line.</p>
					<p>Thank you for joining me!</p>
				</div>

				</br>
				<hr>
				</br>
				<p style="margin-top:4px;">( This is an automated message, please do not reply to this message, if you have any queries please contact sshen@illegalsimon.com )</p>
			</font>
		</div>
		</body>
		'."\n\n".$bound_last;

		return mail($to, $subject, $content, $headers); // finally sending the email
	}


	function createRandomPassword() {
		$chars = "ABCDEFGHJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz0123456789";
		$i = 0;
		$pass = '';

		while ($i <= 8) {
			$num = mt_rand(0,61);
			$tmp = substr($chars, $num, 1);
			$pass .= $tmp;
			$i++;
		}
		return $pass;
	}

	$message = NULL;
	
	if ($_POST['sendEmail']) {
		$email = $_POST['email'];
		
		if ($email == '' OR !filter_var($email, FILTER_VALIDATE_EMAIL))
			$message = "<div class='alert alert-danger'>Please enter a valid email.</div>";
		else {			
			$query = "SELECT * FROM `users` WHERE `email` = '".mysqli_real_escape_string($link, $email)."'";
			
			if ($row = mysqli_fetch_array(mysqli_query($link, $query))) {
				$pwd = createRandomPassword();
				$expiration = time() + (24 * 60 * 60);
				$query = "UPDATE `users` SET `password` = '".md5($pwd).$expiration."' WHERE `email` = '".mysqli_real_escape_string($link, $email)."' LIMIT 1";
				
				if (mysqli_query($link, $query)) {
					if (sendMail($email, $row['username'], $pwd))
						$message = "<div class='alert alert-success'>Success! Please check your mailbox.</div>";
					else
						$message = "<div class='alert alert-danger'>Failed to deliver the email, sorry.</div>";
				} else
					$message = "<div class='alert alert-danger'>Failed to create a temporary password, sorry.</div>";
			} else
				$message = "<div class='alert alert-danger'>Unable to find this email.</div>";
		}
	}
?>