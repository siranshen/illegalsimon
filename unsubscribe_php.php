<?php
	include "connection.php";
	
	$error = NULL;
	$message = NULL;
	$found = false;

	if ($code = $_GET['value']) {
		$query = "SELECT `id` FROM `subscribers`";
		
		$result = mysqli_query($link, $query);
		while ($row = mysqli_fetch_array($result)) {
			if (md5($row['id'].md5('illegal')) == $code) {
				$found = true;
				$query = "DELETE FROM `subscribers` WHERE `id` = ".$row['id']." LIMIT 1";
				
				if (mysqli_query($link, $query))
					$message = "<div class='alert alert-success'>Success! You've been unsubscribed!</div>";
				else
					$error = "Sorry, database error...";
				
				break;
			}
		}
		
		if (!$found)
			$error = "Not found on the mailing list!";
		
		if ($error)
			$message = "<div class='alert alert-danger'>".$error."</div>";
	}
?>