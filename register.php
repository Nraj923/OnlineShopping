<?php
	session_start();
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
	</script>
</head>
<body>
	<header>
		<input type="image" src="img/logo3.png" id="homebtn" class="homebtn" onclick="goHome()">
		<button onclick="location.href='register.php'">Register</button>
		<button onclick="location.href='login.php'">Log In</button>
		<input type="image" src="img/cart.png" id="cart" class="cart"/>
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
	<h2>Register a New Account</h2>
	<form method="POST" action="createaccount.php">
		<label for="firstname">First Name </label>
		<input type="text" id="firstname" name="firstname"/><br>
		<label for="lastname">Last Name </label>
		<input type="text" id="lastname" name="lastname"/><br>
		<label for="mail">Email </label>
		<input type="email" id="mail" name="mail"/><br>
		<label for="username">Username </label>
		<input type="text" id="username" name="username"/><br>
		<label for="pass">Password</label>
		<input type="password" id="pass" name="pass"/><br>
		<input type="submit" value="Create Account"/>
	</form>
</body>
</html>