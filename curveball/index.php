<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<script id="vertex-shader" type="x-shader/x-vertex">

attribute vec4 vPosition;
attribute vec2 vTexCoord;
attribute vec4 vNormal;
attribute vec3 vTangent;

varying vec3 pos, lPos;
varying vec2 fTexCoord;
varying vec3 N;

varying vec3 L; /* light vector in texture-space coordinates */
varying vec3 V; /* view vector in texture-space coordinates */

uniform mat4 modelView;
uniform mat4 projection;
uniform mat4 cameraMove;
uniform vec4 lightPos;
uniform mat3 normalMatrix;

void main() {
	mat4 mvMatrix = cameraMove * modelView;
    gl_Position = projection * mvMatrix * vPosition;
	
	// pos is vertex position in eye coordinates		
	pos = (mvMatrix * vPosition).xyz;
	
	lPos = (mvMatrix * lightPos).xyz;

	//vec3 No = normalize(normalMatrix * vNormal.xyz);
    //vec3 T  = normalize(normalMatrix * vTangent);
	vec3 No = vNormal.xyz;
	vec3 T  = vTangent;
    vec3 B = cross(No, T);
	
	L.x = dot(T, lPos-pos);
    L.y = dot(B, lPos-pos);
    L.z = dot(No, lPos-pos);
	L = normalize(L);
	
	V.x = dot(T, -pos);
    V.y = dot(B, -pos);
    V.z = dot(No, -pos);

    V = normalize(V);

	// Transform vertex normal into eye coordinates, 
	// since there is only translation, we can skip 
	// the multiplication with model view matrix
	N = (vNormal.xyz);

	fTexCoord = vTexCoord;
}

</script>

<script id="frag-shader" type="x-shader/x-fragment">

precision mediump float;

varying vec3 pos, lPos;
varying vec2 fTexCoord;
varying vec3 N;
varying vec3 L;
varying vec3 V;
uniform sampler2D tsampler;
uniform sampler2D texMap;
uniform int texIndex;
uniform vec4 ambientProduct, diffuseProduct, specularProduct;
uniform float shininess;
uniform float opacity;
uniform int motion;
void
main()
{	
	if (texIndex == 1) {
	
		vec4 No = texture2D(texMap, fTexCoord);
		vec3 NN =  normalize(2.0*No.xyz-1.0);
		vec3 LL = normalize(L);
		vec3 VV = normalize(V);
		float Kd = max(dot(NN, LL), 0.0);
		//gl_FragColor = vec4(Kd*diffuseProduct.xyz, 1.0);
		
		 //point source		
		vec3 Li = normalize(lPos - pos);

		// Because the eye point is at the origin
		// the vector from the vertex position to the eye is			
		vec3 E = -normalize(pos);
		
		// halfway vector		
		vec3 H = normalize(Li + E);
		vec4 ambient = ambientProduct;		

		//float Kd = max(dot(L, N), 0.0);
		vec4 diffuse = Kd * diffuseProduct;

		float Ks = pow(max(dot(N, H), 0.0), shininess);
		vec4 specular = Ks * specularProduct;
		
		if(dot(Li, N) < 0.0) specular = vec4(0.0, 0.0, 0.0, 1.0);
		
		vec4 fColor = ambient + diffuse + specular;
		fColor.a = 1.0;
		
		gl_FragColor = fColor * texture2D(tsampler, fTexCoord);
	}
	else
	{
		gl_FragColor = texture2D(tsampler, fTexCoord);
		if(motion == 1)
		{
		 gl_FragColor.a = opacity*gl_FragColor.a;
		}
	}
}

</script>

<script type="text/javascript" src="webgl-utils.js"></script>
<script type="text/javascript" src="initShaders.js"></script>
<script type="text/javascript" src="MV.js"></script>
<script type="text/javascript" src="curveBall.js"></script>
<script type="text/javascript" src="paddle.js"></script>
<script type="text/javascript" src="walls.js"></script>
<script type="text/javascript" src="ball.js"></script>
<script type="text/javascript" src="game.js"></script>
<script type="text/javascript" src="text.js"></script>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>CurveBall</title>
	<link rel="shortcut icon" href="../images/favicon.ico" />

	<!-- Bootstrap -->
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	
	<link href="../styles.css" rel="stylesheet">
	<link type="text/css" href="curveball.css" rel="stylesheet">
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="../js/bootstrap.min.js"></script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->	
</head>

<body>
	<noscript>Your browser does not support JavaScript!</noscript>
	
	<div id="loader-wrapper">
		<div id="loader" class="xcenter ycenter"></div>
	</div>

	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container max-width-container">
			<div class="navbar-header">
				<a class="navbar-brand" href="http://www.illegalsimon.com"></a>
				
				<button type="button" class="navbar-toggle collapsed" id="navbarBtn" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			
			<div id="navbar" class="navbar-collapse collapse">				
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown" id="signInDropdown">
						<a id="signInBtn" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-log-in"></span> Sign In</a>
						
						<ul class="dropdown-menu dropdown-form" aria-labelledby="signInBtn">
							<form method="post" action="https://illegalsimoncom.ipage.com/session.php" id="signInForm">
								<li><div class="form-group">
									<label for="lguser">Username/Email</label>
									<input class="form-control" type="text" id="lguser" name="lguser">
								</div></li>
								<li><div class="form-group">
									<label for="lgpassword">Password</label>
									<input class="form-control" type="password" id="lgpassword" name="lgpassword">
								</div></li>
								<li role="separator" class="divider"></li>
								<li><input type="submit" id="logIn" name="logIn" class="btn btn-info text-capitalized" value="Log In"></li>
							</form>
						</ul>
					</li>
					
					<li class="greeting" style="display:none">
						<a id="userBtn" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Greetings, <span id="greetUser"></span>!</a>
						
						<ul class="dropdown-menu" aria-labelledby="userBtn">
							<li style="text-transform:none; letter-spacing:0.3px;">
								<a href="https://illegalsimoncom.ipage.com/resetpwd.php"><span class="glyphicon glyphicon-link"></span> Reset password</a>
							</li>
						</ul>
					</li>
					
					<li id="signOut" style="display:none"><a onclick="signOut()"><span class="glyphicon glyphicon-log-out"></span> Sign Out</a></li>
					
					<li><a href="../index.php">
						<span class="glyphicon glyphicon-share-alt"></span> Home
					</a></li>
				</ul>
				
				<div class="navbar-form navbar-right">
					<a href="https://illegalsimoncom.ipage.com/join.php" id="signUpBtn" type="button" class="btn btn-success">Sign Up</a>
				</div>
			</div>	
		</div>
	</nav>
	
	<div class="container max-width-container">
		<div class="row center-text letterSpacing row-1">
			<div class="col-md-8 col-md-offset-2">
				<h2><span class="glyphicon glyphicon-play h2-margin-right"></span>CurveBall</h2>
				<div class="signAdvice alert alert-info alert-dismissable" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<a href="../join.php">Sign up</a> or <a href="../session.php">log in</a> to compete with players all over the globe!
				</div>
			</div>
		</div>
		
		<div class="row center-text">
			<div class="col-md-6 col-md-offset-3">
				<p class="lead" style="padding-top:10px"><strong>Instructions:</strong></p>
				<p class="media-body">
				<span class="glyphicon glyphicon-triangle-right"></span> Press 'p' to pause;<br>
				<span class="glyphicon glyphicon-triangle-right"></span> Press 'h' to display your highest score;<br>
				<span class="glyphicon glyphicon-triangle-right"></span> Press 'b' to toggle the blur of the paddle (which may substantially retard your computer);<br>
				<span class="glyphicon glyphicon-triangle-right"></span> Swing your paddle and curve the ball to earn higher scores!<br><br>
				</p>			
			</div>
		</div>
		
		<button id="scoreboardBtn" class="btn btn-lg btn-info xcenter" data-toggle="modal" data-target="#scoreboard" style="display:none">Scoreboard</button>
	</div>
	
	<div id="scoreboard" class="modal fade" role="dialog" aria-labelledby="scoreboardLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">x</button>
					<h5 class="modal-title" id="scoreboardLabel">Scoreboard</h5>
				</div>
				
				<div class="modal-body">
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a id="userScoresTab">My Best</a></li>
								<li role="presentation"><a id="worldScoresTab">World Best</a></li>
							</ul>							
							
							<div class="tab-content">
								<p id="loadingSign"><br><br><span class="glyphicon glyphicon-cloud-download"></span><span id="loadingText"> Loading...</span></p>
							
								<table class="table table-hover" id="userScores">
									<thead>
										<tr><th>#</th><th>Score</th></tr>
									</thead>
									<tbody>
										<tr><th scope="row">1</th><td class="userScore">0</td></tr>
										<tr><th scope="row">2</th><td class="userScore">0</td></tr>
										<tr><th scope="row">3</th><td class="userScore">0</td></tr>
									</tbody>
								</table>
															
								<table class="table table-hover" id="worldScores">
									<thead>
										<tr><th>#</th><th>Username</th><th>Score</th></tr>
									</thead>		
									<tbody>
										<tr><th scope="row">1</th><td class="sb-username"></td><td class="sb-score">0</td></tr>
										<tr><th scope="row">2</th><td class="sb-username"></td><td class="sb-score">0</td></tr>
										<tr><th scope="row">3</th><td class="sb-username"></td><td class="sb-score">0</td></tr>
										<tr><th scope="row">4</th><td class="sb-username"></td><td class="sb-score">0</td></tr>
										<tr><th scope="row">5</th><td class="sb-username"></td><td class="sb-score">0</td></tr>
										<tr><th scope="row">6</th><td class="sb-username"></td><td class="sb-score">0</td></tr>
										<tr><th scope="row">7</th><td class="sb-username"></td><td class="sb-score">0</td></tr>
										<tr><th scope="row">8</th><td class="sb-username"></td><td class="sb-score">0</td></tr>
										<tr><th scope="row">9</th><td class="sb-username"></td><td class="sb-score">0</td></tr>
										<tr><th scope="row">10</th><td class="sb-username"></td><td class="sb-score">0</td></tr>
										<tr><th scope="row">11</th><td class="sb-username"></td><td class="sb-score">0</td></tr>
										<tr><th scope="row">12</th><td class="sb-username"></td><td class="sb-score">0</td></tr>
										<tr><th scope="row">13</th><td class="sb-username"></td><td class="sb-score">0</td></tr>
										<tr><th scope="row">14</th><td class="sb-username"></td><td class="sb-score">0</td></tr>
										<tr><th scope="row">15</th><td class="sb-username"></td><td class="sb-score">0</td></tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Go play</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="canvas-container xcenter">
		<canvas id="tex-canvas" width="800" height="540"  style="position:absolute; z-index:0" >Sorry... Your browser does not support the HTML5 canvas element :-(</canvas>
		<div id="overlay" hidden>
			<div hidden>Player Lives: <span id="playerScore"></span></div>
			<div hidden>AI Lives: <span id="aiScore"></span></div>
			<div hidden>Curve Scores: <span id="curveScore"></span></div>
			<div hidden>Level: <span id="gameLevel"></span></div>
			<div hidden>Highest: <span id="highScore"></span></div>
		</div>
		<canvas id="welcome" width="800" height="540" style="position:absolute; z-index:2">Sorry... Your browser does not support the HTML5 canvas element :-(</canvas>
		<canvas id="hud" width="800" height="540" style="position:absolute; z-index:1">Sorry... Your browser does not support the HTML5 canvas element :-(</canvas>
	</div>
</body>
<script>
	function checkSignIn() {
		if (<?php if ($_SESSION['username']) echo "true"; else echo "false"; ?>) {
			$("#greetUser").text("<?php echo $_SESSION['username']; ?>");
			$(".greeting, #signOut, #scoreboardBtn").show();
			$("#signInDropdown, #signUpBtn, .signAdvice").hide();
		} else {
			$(".greeting, #signOut, #scoreboardBtn").hide();
			$("#signInDropdown, #signUpBtn, .signAdvice").show();
		}
	}
		
	function signOut() {
		$.ajax("../logout.php")
			.done(function() {
				window.location.reload();
			});			
	}
	
	function saveFinalScore(score) {
		if (<?php if ($_SESSION['username']) echo "true"; else echo "false"; ?>) {
			var text = "score="+score+"&username="+"<?php echo $_SESSION['username']; ?>";
			$.ajax({
				method:"GET",
				url:"savescore.php",
				data:text
			});
		}
	}
	
	function getHighestScore() {
		if (<?php if ($_SESSION['username']) echo "true"; else echo "false"; ?>)
			return Number("<?php echo $_SESSION['highest']; ?>");
		else
			return 0;
	}
	
	var userScoresRetrieved = false,
		worldScoresRetrieved = false;
	
	$("#scoreboardBtn").click(function() {
		worldScoresRetrieved = userScoresRetrieved = false;
		$("#worldScoresTab").parent().removeClass("active");
		$("#userScoresTab").parent().addClass("active");
		$("#loadingSign").show();
		$("#userScores, #worldScores").hide();
		var text = "target=user&username="+"<?php echo $_SESSION['username']; ?>";
		$.ajax({
			method:"GET",
			url:"retrievescores.php",
			data:text,
			dataType:"json"
		})
			.fail(function() {
				$("#loadingText").text("Failed to retrieve data...");
			})
			.done(function(data) {
				$(".userScore").each(function(i) {
					$(this).text(data[i]);
				});
				userScoresRetrieved = true;
				if ($("#userScoresTab").parent().hasClass("active")) {
					$("#loadingSign").hide();
					$("#userScores").fadeIn();
				}
			});
	});
	
	$("#userScoresTab").click(function() {
		$("#worldScoresTab").parent().removeClass("active");
		$("#userScoresTab").parent().addClass("active");
		$("#worldScores").hide();
		if (userScoresRetrieved)
			$("#userScores").fadeIn();
		else
			$("#loadingSign").show();
	});
	
	$("#worldScoresTab").click(function() {
		$("#userScoresTab").parent().removeClass("active");
		$("#worldScoresTab").parent().addClass("active");
		$("#userScores").hide();
		if (worldScoresRetrieved) {
			$("#worldScores").fadeIn();
			return;
		}
		
		$("#loadingSign").show();
		$.ajax({
			method:"GET",
			url:"retrievescores.php",
			data:"target=world",
			dataType:"json",
			
		})
			.fail(function() {
				$("#loadingText").text("Failed to retrieve data...");
			})
			.done(function(data) {
				$(".sb-username").each(function(i) {
					$(this).text(data[i]["username"]);
				});
				$(".sb-score").each(function(i) {
					$(this).text(data[i]["score"]);
				});
				worldScoresRetrieved = true;
				
				if ($("#worldScoresTab").parent().hasClass("active")) {
					$("#loadingSign").hide();
					$("#worldScores").fadeIn();
				}
			});
	});
	
	$(document).ready(checkSignIn);
</script>
</html>