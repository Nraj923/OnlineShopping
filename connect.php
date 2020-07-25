<?php 
	$host = "nicksappliancesdb.mysql.database.azure.com";
	$user = "mysqladmin";
	$password = "Atlanta01$";
	$db = "appliancedb";
	$port = 3306;
	
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