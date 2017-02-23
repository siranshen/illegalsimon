<!doctype html>
<html>
<head>
	<title>Weather Boy</title>
	<meta charset="utf-8" />
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	
	<!-- jQuery -->
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	
	<style>
		@font-face {
			font-family:"Lato";
			src:url("../fonts/Lato-Regular.ttf");
		}
	
		.container {
			width:100%;
			min-height:500px;
			background:url("bg.jpg") no-repeat;
			background-size:cover;
			background-position:center;
			color:white;
			font-family:"Lato","Helvetica Neue",Helvetica,Arial,sans-serif;
		}
	
		.text-center {
			text-align:center;
		}
		
		.top-row {
			position:relative;
			top:12%;
			letter-spacing:0.2px;
		}
		
		h1 {
			margin-bottom:30px;
			font-weight:600;
		}
		
		.lead {
			margin-bottom:40px;
		}
		
		.input-group {
			margin:0 8px 32px 8px;
		}
		
		.alert {
			position:relative;
			left:6%;
			width:88%;
			margin-top:25px;
		}
		
		@media (min-width: 768px) {
			.top-row {
				top:23%;
			}
		}
	</style>
</head>
<body>
	<noscript>Your browser does not support JavaScript!</noscript>

	<div class="container">
		<div class="row top-row">
			<div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2 text-center">
				<h1>WeatherBoy</h1>
				<p class="lead">Enter your city below to check its weather in 3 days!</p>
				
				<form>
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
						<input id="city" name="city" type="text" class="form-control" placeholder="E.g., Los Angeles, London, etc.">
					</div>
					
					<button id="searchBtn" type="submit" class="btn btn-lg btn-info">Find My City's Weather</button>
				</form>
				
				<div id="weatherForecast" class="alert alert-info" style="display:none"></div>
				<div id="warning" class="alert alert-danger" style="display:none"></div>
			</div>
			
		</div>
	</div>
	
	<script>
		function sizeContainer() {
			$(".container").css("height", $(window).height());
		}
	
		window.onload = function() {
			sizeContainer();			
			window.onresize = sizeContainer();
			
			$("#searchBtn").click(function(e) {
				e.preventDefault();
				var city = $("#city").val().toLowerCase();
				if (city) {
					$.get("weather.php?city=" + city, function(data) {
						if (data == "failed") {
							$("#weatherForecast").css("display", "none");
							$("#warning").text("Sorry, we are unable to find your city :(").fadeIn();
						} else {
							$("#warning").css("display", "none");
							$("#weatherForecast").html(data).fadeIn();
						}
					});
				} else {
					$("#weatherForecast").css("display", "none");
					$("#warning").text("Please enter a city!").fadeIn();
				}
			});
		}
	</script>
</body>
</html>