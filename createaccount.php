<?php
	session_start();
	require_once "connect.php";
	
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['mail'];
		$username = $_POST['username'];
		$password = $_POST['pass'];
		
		$sql = "INSERT INTO `customer` (First_Name, Last_Name, Email, Username, Password)
				VALUES ('$firstname', '$lastname', '$email', '$username', '$password')";
				
		$result = mysqli_query($link, $sql) or die(mysqli_error($link));
		if (!$result) {
			die('Invalid Order Query: ' . mysqli_error($con));
		}
	}
?>

<html>
<head>
	<meta charset="UTF-8" />
	<meta header("Cache-Control: no-cache, must-revalidate");/> 
    <title>Nick's Appliances</title> 
	<link href="css/styles.css" rel="stylesheet" />	
	<link href="css/normalize.css" rel="stylesheet" />
	
	<script type="text/javascript">
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
		<label id="cartnum" class="cartnum"><?php echo $_SESSION['items'] ?> items in </label/>
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
	<h2>Thank you for creating an account!</h2><br>
	<button onclick="location.href='login.php'">Login Here</button>
</body>
</html>