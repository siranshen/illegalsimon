<?php
	include("../connection.php");

	if ($_GET['target'] == "user") {
		$username = $_GET['username'];
		
		$query = "SELECT * FROM `users` WHERE `username` = '".$username."' LIMIT 1";
		
		if ($row = mysqli_fetch_array(mysqli_query($link, $query))) {
			$data = array($row['score1'], $row['score2'], $row['score3']);
			header("Content-Type: application/json");
			echo json_encode($data);
		}
	} else if ($_GET['target'] == "world") {
		$query = "SELECT `username`, `score1` FROM `users` ORDER BY `score1` DESC LIMIT 15";
		
		if ($result = mysqli_query($link, $query)) {
			while ($row = mysqli_fetch_array($result))
				$data[] = array('username' => $row['username'], 'score' => $row['score1']);
			
			while (count($data) < 15)
				$data[] = array('username' => '', 'score' => '0');
			
			header("Content-Type: application/json");
			echo json_encode($data);
		}
	}
?>