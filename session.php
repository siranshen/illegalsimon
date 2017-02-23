<? include("session_php.php"); ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Sign In</title>
		<link rel="shortcut icon" href="images/favicon.ico" />

		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		
		<link href="styles.css" rel="stylesheet">
		<link href="sign-styles.css" rel="stylesheet">
		
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->		
	</head>
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container max-width-container">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php"></a>
					
					<button type="button" class="navbar-toggle collapsed" id="navbarBtn" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a href="" id="signInBtn" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-log-in"></span> Sign In</a>
						</li>
						
						<li><a href="index.php">
							<span class="glyphicon glyphicon-share-alt"></span> Home
						</a></li>
					</ul>
					
					<div class="navbar-form navbar-right">
						<a href="https://illegalsimoncom.ipage.com/join.php" id="signUpBtn" type="button" class="btn btn-success">Sign Up</a>
					</div>
				</div>	
			</div>
		</nav>
		
		<div id="#homeContainer" class="container-fluid">
			<div class="row row-1">
				<div class="col-md-6 col-md-offset-3">
					<div class="auth-form">
						<form method="post">
							<div class="auth-form-header">
								Sign In
							</div>
							<div class="auth-form-body">
							
								<?php if($message) echo $message; ?>
								
								<div class="form-group">
									<label for="username">Username or email</label>
									<input class="form-control" type="text" id="lguser" name="lguser" value="<?php echo addslashes($_POST['lguser']); ?>">			
								</div>
								
								<div class="form-group">
									<label for="password">Password (<a href="https://illegalsimoncom.ipage.com/forgotpwd.php">Forgot password?</a>)</label>
									<input class="form-control" type="password" id="lgpassword" name="lgpassword">
								</div>
								
								<input type="submit" id="logIn" name="logIn" class="btn btn-info text-capitalized" value="Log in">			
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>