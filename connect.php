<?php 
	$host = "localhost";
	$user = "root";
	$password = "password";
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
	
	if (!$success) {
		die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
	}
?>