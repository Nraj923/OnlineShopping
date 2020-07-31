<?php
	session_start();
	$_SESSION['login'] = ""; 
	require_once "connect.php";
	
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		$username = $_POST['username'];
		$password = $_POST['pass'];
		
		$_SESSION['login'] = "This username doesn't exist";
		
		$sql1 = "SELECT Username FROM `customer`";
		$result1 = mysqli_query($link, $sql1) or die(mysqli_error($link));
		while ($row1 = $result1->fetch_array()) {
			if ($row1['Username'] == $username) {
				$sql2 = "SELECT Password FROM `customer` WHERE Username='$username'";
				$result = mysqli_query($link, $sql2) or die(mysqli_error($link));
				$row2 = $result->fetch_array();
				if ($row2['Password'] == $password) {
					header("Location: index.html");
				} else {
					$_SESSION['login'] = "Incorrect password";
				}
			}
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
	<form method="POST" action="" class="fields">
		<h2>Log In</h2>
		<label for="username">Username</label>
		<input type="text" id="username" name="username"/><br>
		<label for="pass">Password</label>
		<input type="password" id="pass" name="pass"/><br>
		<button type="submit">Log In</button><br><br>
		<?php echo $_SESSION['login'] ?>
	</form>
</body>
</html>