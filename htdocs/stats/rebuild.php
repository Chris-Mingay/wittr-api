<?php

	/**
	 * Build index.php as a simple form of caching, prevents overload
	 */

	if(!file_exists("../settings.php")){
		die("settings.php is required. Please copy from settings.example.php and setup as required");
	}else{
		include("../settings.php");
	}

	$conn = new mysqli($gc['database_host'],$gc['database_user'],$gc['database_pass'],$gc['database_name']) or die("DB error");

	$sql = "SELECT COUNT(*) as total FROM `wittee`";
	$result = $conn->query($sql) or die($conn->error);
	$row = $result->fetch_assoc();
	$fullTotal = $row['total'];

	$out = file_get_contents("https://wittr.ct14hosted.co.uk/stats/pageout.php");

	$dateTime = new DateTime("now",new DateTimeZone('Europe/London'));
	
	$out = str_replace("[UPDATE_TIME]",$dateTime->format("H:i:s d/m/Y"),$out);
	$out = str_replace("[TOTAL]",$fullTotal,$out);
	
	file_put_contents("index.php",$out);
	
	echo "Done";