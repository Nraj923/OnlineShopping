<?php
	session_start();
	//var_dump($_POST);
	//var_dump($_SESSION['cart']);
	$con = new mysqli("localhost","root", "hailsham923", "appliancedb", 3308);
	if (!$con) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$name = $_POST['cardname'];
	$cardnumber = (int) $_POST['cardno'];
	$expdate = $_POST['expdate'];
	$ccv = (int) $_POST['ccv'];
	$street = $_POST['street1'].$_POST['street2'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip = (int) $_POST['zip'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		
		$sql1 = "INSERT INTO `order` (Name, CardNumber, ExpDate, CCV, Street, City, State, Zip, Phone, Email)
				VALUES ('$name', $cardnumber, '$expdate', $ccv, '$street', '$city', '$state', $zip, '$phone', '$email')";
		
		//$con->query($sql1);
		$result1 = mysqli_query($con, $sql1);
		//var_dump($result1);
		if (!$result1) {
			die('Invalid Order Query: ' . mysqli_error($con));
		}
		
		$orderquery = mysqli_query($con, "SELECT Order_ID FROM `order` ORDER BY Order_ID DESC"); 
		$row = mysqli_fetch_array($orderquery);
		$orderid = $row['Order_ID'];
		foreach ($_SESSION['cart'] as $result) {
			$price = $result[2];
			$sql2 = "INSERT INTO `order_details` (Order_ID, Product_ID, Quantity, Description, Price)
				VALUES ('$orderid', '$result[0]', '$result[3]', '$result[1]', $price)";
			$result2 = mysqli_query($con, $sql2);
			//var_dump($result2);
			if (!$result2) {
				die("Invalid Detail Query: " . mysqli_error($con));
			}
		}
		session_destroy();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<link href="css/styles.css" rel="stylesheet" />	
	<link href="css/normalize.css" rel="stylesheet" />
	<script>
		function goHome() {
			location.href = "index.html";
		}
	</script>
</head>
<body>
	<header>
		<input type="image" src="img/logo3.png" id="homebtn" class="homebtn" onclick="goHome()">
		<button onclick="location.href='register.php'">Register</button>
		<button onclick="location.href='login.php'">Log In</button>
		<input type="image" src="img/cart.png" id="cart" class="cart"/>
		<div class="topnav" class="center">
			<input type="text" placeholder="Search..">
		</div>
		<div>
			<nav id="nav_menu">
				<form method="GET" action="catalog.php?prodtype='refrigerator'">
					<button type="submit" name="prodtype" value="refrigerator" id="submit">Refrigerators</button>
					<button type="submit" name="prodtype" value="oven" id="submit">Ovens</button>
					<button type="submit" name="prodtype" value="microwave" id="submit">Microwaves</button>
					<button type="submit" name="prodtype" value="washer" id="submit">Washers</button>
					<button type="submit" name="prodtype" value="dryer" id="submit">Dryers</button>
				</form>
			</nav>
		</div>
		
	</header>
	<h2>Thank you for your order!</h2>
</body>
</html>