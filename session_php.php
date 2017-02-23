<?php
	session_start();
	session_regenerate_id(true);
	
	include "connection.php";
	
	$loggedIn = "false";
	$errors = array();
	$message = NULL;

	if ($_POST['logIn']) {
		$user = $_POST['lguser'];
		$pwd = $_POST['lgpassword'];
		
		if ($user == '')
			$errors[] = "Please enter your username or email.";
		if ($pwd == '')
			$errors[] = "Please enter your password.";
				
		if (!$errors) {
			$query = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($link, $user)."' OR username = '".mysqli_real_escape_string($link, $user)."' LIMIT 1";
			
			if ($row = mysqli_fetch_array(mysqli_query($link, $query))) {
				if ($row['password'] == md5(md5('illegal').$pwd)) {
					$message = "<div class='alert alert-success'>Success! You've logged in!</div>";
					$_SESSION['username'] = $row['username'];
					$_SESSION['highest'] = $row['score1'];
					// Redirect
					$loggedIn = "true";
					// Mail
				} else
					$errors[] = "Incorrect password.";
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
	if (<?php echo $loggedIn; ?>) {
		setInterval(function() {
			window.location.replace("curveball/");
		}, 1250);
	}
</script>