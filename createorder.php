<?php
	session_start();
	require_once "connect.php";
	
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
		
		$result1 = mysqli_query($link, $sql1) or die(mysqli_error($link));
		
		$orderquery = mysqli_query($link, "SELECT Order_ID FROM `order` ORDER BY Order_ID DESC") or die(mysqli_error($link)); 
		$row = mysqli_fetch_array($orderquery);
		$orderid = $row['Order_ID'];
		foreach ($_SESSION['cart'] as $result) {
			$sql2 = "INSERT INTO `order_details` (Order_ID, Product_ID, Quantity, Description, Price, DeliveryTotal, InstallationTotal, HaulAwayTotal)
				VALUES ('$orderid', '$result[0]', '$result[6]', '$result[1]', '$result[2]', '$result[3]', '$result[4]', '$result[5]')";
			$result2 = mysqli_query($link, $sql2) or die(mysqli_error($link));
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
		
		function checkCart() {
			location.href = "checkout.php";
		}
	</script>
</head>
<body class="page">
	<header>
		<input type="image" src="img/logo3.png" id="homebtn" class="homebtn" onclick="goHome()">
		<button onclick="location.href='register.php'" class="account">Register</button>
		<button onclick="location.href='login.php'" class="account">Log In</button>
		<input type="image" src="img/cart.png" id="cart" class="cart" onclick="checkCart()"/>
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