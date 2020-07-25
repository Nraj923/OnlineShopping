<?php 
	$host = "nicksappliancesdb.mysql.database.azure.com";
	$user = "mysqladmin@nicksappliancesdb";
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
	
	if (!$success) {
		die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
	}
?>