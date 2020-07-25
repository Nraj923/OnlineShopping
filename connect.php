<?php 
	$host = "localhost";
	$user = "root";
	$password = "hailsham923";
	$db = "appliancedb";
	$port = 3308;
	
	$link = mysqli_init();
	$success = mysqli_real_connect(
		$link,
		$host,
		$user,
		$password,
		$db,
		$port
	);
?>