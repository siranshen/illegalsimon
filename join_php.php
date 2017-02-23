<?php
	session_start();
	session_regenerate_id(true);
	
	include "connection.php";
	
	$errors = array();
	$message = NULL;
	$signedUp = "false";

	if ($_POST['signUp']) {
		$username = $_POST['username'];
		$email = $_POST['email'];
		$pwd = $_POST['password'];
		$cfm_pwd = $_POST['cfmpassword'];
		
		if ($username == '')
			$errors[] = "Please pick a username.";
		if ($email == '' OR !filter_var($email, FILTER_VALIDATE_EMAIL))
			$errors[] = "Please enter a valid email.";
		if (strlen($pwd) < 8 OR strlen($pwd) > 25)
			$errors[] = "Password should have at least 8 and at most 25 characters.";
		else if (!preg_match('/.*^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/', $pwd))
			$errors[] = "Password must contain at least an uppercase, a lowercase, and a digit.";
		else if ($pwd != $cfm_pwd)
			$errors[] = "The passwords you entered do not match.";
		
		if (!$errors) {
			$query = "SELECT * FROM `users` WHERE `username` = '".mysqli_real_escape_string($link, $username)."'";
			
			$result1 = mysqli_query($link, $query);
			
			$query = "SELECT * FROM `users` WHERE `email` = '".mysqli_real_escape_string($link, $email)."'";
			
			$result2 = mysqli_query($link, $query);
			
			if (mysqli_num_rows($result1))
				$errors[] = "This username has already been registered. Do you want to <a href='session.php'>log in</a>?";
			else if (mysqli_num_rows($result2))
				$errors[] = "This email has already been registered. Do you want to <a href='session.php'>log in</a>?";
			else {			
				$query = "INSERT INTO `users` (`username`, `email`, `password`) VALUES ('".mysqli_real_escape_string($link, $username)."', '".mysqli_real_escape_string($link, $email)."', '".md5(md5('illegal').$pwd)."')";
				
				if (!mysqli_query($link, $query))
					$errors[] = "Failed to add, sorry...";
				else {
					$message = "<div class='alert alert-success'>Success! You've been signed up!</div>";
					$_SESSION['username'] = $username;
					$_SESSION['highest'] = 0;
					// Redirect
					$signedUp = "true";
					// Mail
				}				
			}
		}
		
		if ($errors) {
			$message = "<div class='alert alert-danger'>".$errors[0];
			for($i = 1; $i < count($errors); $i++)
				$message .= "<br>".$errors[$i];
			$message .= "</div>";
		}
	}
?>

<script>
	if (<?php echo $signedUp; ?>) {
		setInterval(function() {
			window.location.replace("curveball/");
		}, 1250);
	}
</script>