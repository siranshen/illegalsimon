<?php
	session_start();
	
	include("../connection.php");

	if ($_GET['score']) {
		$score = intval($_GET['score']);
		$username = $_GET['username'];
		
		$query = "SELECT * FROM `users` WHERE `username`='".mysqli_real_escape_string($link, $username)."' LIMIT 1";
		
		$result = mysqli_fetch_array(mysqli_query($link, $query));
		
		$ranking = 0;
		
		if (intval($result["score1"]) < $score)
			$ranking = 1;
		else if (intval($result["score2"]) < $score)
			$ranking = 2;
		else if (intval($result["score3"]) < $score)
			$ranking = 3;
		
		if ($ranking != 0) {
			if ($ranking == 1)
				$query = "UPDATE `users` SET `score1`=".$score.", `score2`=".$result['score1'].", `score3`=".$result['score2']." WHERE `username`='".mysqli_real_escape_string($link, $username)."' LIMIT 1";
			else if ($ranking == 2)
				$query = "UPDATE `users` SET `score2`=".$score.", `score3`=".$result['score2']." WHERE `username`='".mysqli_real_escape_string($link, $username)."' LIMIT 1";
			else if ($ranking == 3)
				$query = "UPDATE `users` SET `score3`=".$score." WHERE `username`='".mysqli_real_escape_string($link, $username)."' LIMIT 1";
						
			mysqli_query($link, $query);
		}
	}
?>