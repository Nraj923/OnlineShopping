<?php
	session_start();	
	//var_dump($_POST);
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		if (isset($_POST['pID'])) {
			$i = 0;
			foreach ($_SESSION['cart'] as $result) {
				if ($result[0] == $_POST['pID']) {
					array_splice($_SESSION['cart'], $i, 1);
					$_SESSION['items'] -= $result[3];
					$_SESSION['totalprice'] -= ($result[2] * $result[3]);
				} 
				$i = $i + 1;
			}
		}
	}
	//var_dump($_SESSION['cart']);
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
	<body class="page">
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
		<button type="submit" name="back" class="backtoshopping" onclick="location.href='index.html';">Back to Shopping</button>
		<h1> Items in Cart </h1>
		<?php 
		if (isset($_SESSION['cart'])) {
			foreach ($_SESSION['cart'] as $result) {
		?>
		<table id="cartitems">
			<tbody>
				<tr>
					<td style="padding-right: 25px;"><img src="img/<?php echo $result[0] ?>.jpg" class="cartimage"></td>
					<td class="description" style="padding-right: 25px;"><?php echo $result[1]; ?><br>SKU: <?php echo $result[0] ?></td>
					<td style="padding-right: 25px;">$<?php echo $result[2] ?> &nbsp </td>
					<td style="padding-right: 25px;">Quantity: <?php echo $result[3] ?> &nbsp </td>
					<td style="padding-right: 25px;">
						<form method="POST" action="">
							<input type="submit" class="remove" value="Remove Item"/>
							<input type="hidden" name="pID" id="pID" value="<?php echo $result[0] ?>"/>
						</form>
					</td><br>
				</tr>
			</tbody>
		</table>
		<?php 
			}
		}
		?>
		<label>&nbsp Final Price: $<?php echo $_SESSION['totalprice'] ?></label>
		<form method="POST" action="createorder.php" class="fields">
			<h3>Payment Info</h3>
			<label for="cardno">Card Number</label>
			<input type="number" id="cardno" name="cardno" required><br>
			<label for="expdate">Expiration Date</label>
			<input type="month" id="expdate" name="expdate" required><br>
			<label for="cvv">Security Code (CCV)</label>
			<input type="number" id="ccv" name="ccv" required><br>
			<label for="cardname">Card Holder Name</label>
			<input type="text" id="cardname" name="cardname" required><br>
			
			<h3>Billing Address</h3>
			<label for="street1">Street Address 1</label>
			<input type="text" id="street1" name="street1" required><br>
			<label for="street2">Street Address 2</label>
			<input type="text" id="street2" name="street2"><br>
			<label for="city">City</label>
			<input type="text" id="city" name="city" required><br>
			<label for="state">State</label>
			<select id="state" name="state" required><br>
				<option value="AL">AL</option>
				<option value="AK">AK</option>
				<option value="AZ">AZ</option>
				<option value="AR">AR</option>
				<option value="CA">CA</option>
				<option value="CO">CO</option>
				<option value="CT">CT</option>
				<option value="DE">DE</option>
				<option value="FL">FL</option>
				<option value="GA">GA</option>
				<option value="HI">HI</option>
				<option value="ID">ID</option>
				<option value="IL">IL</option>
				<option value="IN">IN</option>
				<option value="IA">IA</option>
				<option value="KS">KS</option>
				<option value="KY">KY</option>
				<option value="LA">LA</option>
				<option value="ME">ME</option>
				<option value="MD">MD</option>
				<option value="MA">MA</option>
				<option value="MI">MI</option>
				<option value="MN">MN</option>
				<option value="MS">MS</option>
				<option value="MO">MO</option>
				<option value="MT">MT</option>
				<option value="NE">NE</option>
				<option value="NV">NV</option>
				<option value="NH">NH</option>
				<option value="NJ">NJ</option>
				<option value="NM">NM</option>
				<option value="NY">NY</option>
				<option value="NC">NC</option>
				<option value="ND">ND</option>
				<option value="OH">OH</option>
				<option value="OK">OK</option>
				<option value="OR">OR</option>
				<option value="PA">PA</option>
				<option value="RI">RI</option>
				<option value="SC">SC</option>
				<option value="SD">SD</option>
				<option value="TN">TN</option>
				<option value="TX">TX</option>
				<option value="UT">UT</option>
				<option value="VT">VT</option>
				<option value="VA">VA</option>
				<option value="WA">WA</option>
				<option value="WV">WV</option>
				<option value="WI">WI</option>
				<option value="WY">WY</option>
			</select>
			<label for="zip">Zip Code</label>
			<input type="number" id="zip" name="zip" required><br>
			<label for="phone">Phone</label>
			<input type="tel" id="phone" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"/><br>
			<label for="email">E-mail</label>
			<input type="email" id="email" name="email"><br><br>
			<input type="submit" value="Submit Payment"/>
		</form>
	</body>
</html>