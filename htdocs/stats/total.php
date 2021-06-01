<?php

	/**
	 * Provides the total for the stats page total counter
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
	echo $row['total'];