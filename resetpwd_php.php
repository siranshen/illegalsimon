<?php
	session_start();
	session_regenerate_id(true);
	
	include "connection.php";
	
	$reset = "false";
	$errors = array();
	$message = NULL;

	if ($_POST['reset']) {
		$user = $_POST['resetUser'];
		$oldpwd = $_POST['oldPassword'];
		$pwd = $_POST['newPassword'];
		$cfm_pwd = $_POST['cfmpassword'];
		
		if ($user == '')
			$errors[] = "Please enter your username or email.";
		if ($oldpwd == '')
			$errors[] = "Please enter your temporary password.";
		if (strlen($pwd) < 8 OR strlen($pwd) > 25)
			$errors[] = "Password should have at least 8 and at most 25 characters.";
		else if (!preg_match('/.*^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/', $pwd))
			$errors[] = "Password must contain at least an uppercase, a lowercase, and a digit.";
		else if ($pwd != $cfm_pwd)
			$errors[] = "The passwords you entered do not match.";
				
		if (!$errors) {
			$query = "SELECT * FROM `users` WHERE `email` = '".mysqli_real_escape_string($link, $user)."' OR `username` = '".mysqli_real_escape_string($link, $user)."' LIMIT 1";
			
			if ($row = mysqli_fetch_array(mysqli_query($link, $query))) {
				$currentTime = time();
				if (($_GET['temp'] == '1' AND substr($row['password'], 0, 32) == md5($oldpwd) AND intval(substr($row['password'], 32)) >= $currentTime)
					OR ($_GET['temp'] != '1' AND $row['password'] == md5(md5('illegal').$oldpwd))) {
						
					$query = "UPDATE `users` SET `password` = '".md5(md5('illegal').$pwd)."' WHERE `email` = '".mysqli_real_escape_string($link, $user)."' OR `username` = '".mysqli_real_escape_string($link, $user)."' LIMIT 1";
				
					if (mysqli_query($link, $query)) {
						$message = "<div class='alert alert-success'>Success! You've reset your password!</div>";
						$_SESSION['username'] = $row['username'];
						$_SESSION['highest'] = $row['score1'];
						// Redirect
						$reset = "true";
						// Mail
					} else
						$errors[] = "Unable to update your password, sorry.";
				} else
					$errors[] = "The password is incorrect or has expired.";
			} else
				$errors[] = "Incorrect username or email.";
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
	if (<?php echo $reset; ?>) {
		setInterval(function() {
			window.location.replace("curveball/");
		}, 1250);
	}
</script>