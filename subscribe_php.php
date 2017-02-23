<?php
	include("connection.php");

	function sendMail($email, $username, $id) {
		$to = $email;
		$subject = 'Welcome to illegalsimon.com!';

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
					<p>I\'m Siran. You are receiving this email because you have subscribed to illegalsimon.com.</p>
					<p>If it turns out to be a mistake, click <a href="http://www.illegalsimon.com/unsubscribe.php?value='.md5($id.md5('illegal')).'">this link</a> to unsubscribe.</p>
					<p>Okay, I made this website out of fun and the wish to make more friends. So if you ever want to reach out to me, do not hesitate!</p>
					<p>If this email looks a bit crappy, yeah, I mean, sorry, I will definitely try to improve. Any comment is welcome!</p>
					<p>And, thank you for joining me!</p>
					<p>Best,<br>Siran</p>
				</div>

				</br>
				<hr>
				</br>
				<p style="margin-top:4px;">( This is an automated message, please do not reply to this message, please instead contact sshen@illegalsimon.com )</p>
			</font>
		</div>
		</body>
		'."\n\n".$bound_last;

		return mail($to, $subject, $content, $headers); // finally sending the email
	}

	if ($email = $_GET['email']) {
		$name = $_GET['name'];
		$comment = $_GET['comment'];
		
		if ($email == '' OR !filter_var($email, FILTER_VALIDATE_EMAIL))
			echo "2"; // No good email
		else {			
			$query = "SELECT * FROM `subscribers` WHERE `email` = '".mysqli_real_escape_string($link, $email)."'";
			
			if (mysqli_num_rows(mysqli_query($link, $query)))
				echo "3"; // Already subscribed
			else {
				$query = "INSERT INTO `subscribers` (`name`, `email`, `comment`) VALUES ('".mysqli_real_escape_string($link, $name)."', '".mysqli_real_escape_string($link, $email)."', '".mysqli_real_escape_string($link, $comment)."')";
				
				if (mysqli_query($link, $query)) {
					if (sendMail($email, $name, mysqli_insert_id($link)))
						echo "1"; // Success
					else
						echo "4"; // Failed to send email
				} else
					echo "5"; // Database error
			}
		}
	}
?>