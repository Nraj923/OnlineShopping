<?php
session_set_cookie_params(0);
session_start();

if (!isset($_SESSION['items'])) {
	$_SESSION['items'] = 0;
}
if (!isset($_SESSION['totalprice'])) {
	$_SESSION['totalprice'] = 0;
}

if($_SERVER['REQUEST_METHOD'] == "POST") {
	if (!isset($_SESSION['cart'])) {
		$_SESSION['cart'] = array();
	} 
	
	// If product already exists in cart, increase quantity of item rather than creating new item in cart
	$duplicate = false;
	$i = 0;
	foreach ($_SESSION['cart'] as &$result) {
		if ($result[0] == $_POST['productID']) {
			$result[6] += 1;
			$_SESSION['totalprice'] += (double) $result[2];
			if (isset($_POST['delcharge'])) {
				$result[3] += $_POST['delcharge'];
				$_SESSION['totalprice'] += $_POST['delcharge'];
			}
			if (isset($_POST['inscharge'])) {
				$result[4] += $_POST['inscharge'];
				$_SESSION['totalprice'] += $_POST['inscharge'];
			}
			if (isset($_POST['haulcharge'])) {
				$result[5] += $_POST['haulcharge'];
				$_SESSION['totalprice'] += $_POST['haulcharge'];
			}
			$duplicate = true;
		}
		$i = $i + 1;		
	}
	
	// If duplicate was not found, add item to cart
	if (!$duplicate) {
		$product = array();
		if (isset($_POST['productID'])) {
			array_push($product, $_POST['productID']);
		}
		if (isset($_POST['description'])) {
			array_push($product, $_POST['description']);
		}
		if (isset($_POST['price'])) {
			array_push($product, $_POST['price']);
			$_SESSION['totalprice'] += (double) $product[2];
		}
		array_push($product, 0);
		if (isset($_POST['delcharge'])) {
			$product[3] += $_POST['delcharge'];
			$_SESSION['totalprice'] += $_POST['delcharge'];
		}
		array_push($product, 0);
		if (isset($_POST['inscharge'])) {
			$product[4] += $_POST['inscharge'];
			$_SESSION['totalprice'] += $_POST['inscharge'];
		}
		array_push($product, 0);
		if (isset($_POST['haulcharge'])) {
			$product[5] += $_POST['haulcharge'];
			$_SESSION['totalprice'] += $_POST['haulcharge'];
		}
		array_push($product, 1); // Quantity
		array_push($_SESSION['cart'], $product);
	}
	
	$_SESSION['items'] += 1;
	
}
?>


<!DOCTYPE html>
<html>

<head >
	<meta charset="UTF-8" />
	<meta header("Cache-Control: no-cache, must-revalidate");/> 
    <title>Nick's Appliances</title> 
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
		<div class="price"> Price: $<?php echo $_SESSION['totalprice'] ?> </div>
		
	</header>
	<button type="submit" name="cart" class="checkout" onclick="location.href='checkout.php';">Checkout</button><br><br>
	
	<?php	
		require_once "connect.php";
		$productType = $_REQUEST['prodtype'];
		$sql = "SELECT * FROM `product` WHERE type='".$productType."'";
		$products = mysqli_query($link, $sql) or die(mysqli_error($link));
		$num = 1;
		while($row = $products->fetch_array()){ 
	?>
	<table>
		<tbody>
			<tr>
				<td><img src="img/<?php echo $row["Product_ID"]; ?>.jpg" class="prdimage"></td>
				<td class="description"><?php echo $row["Description"]; ?><br>SKU: <?php echo $row["Product_ID"] ?></td>
				<td>Item Price: $<?php echo $row["Price"] ?></td> 
				<form method="POST" action="">
					<td>
						<input type="checkbox" name="delcharge" value="<?php echo $row["Delivery"] ?>"/>
						<label for="delcharge">Delivery Charge: $<?php echo $row["Delivery"] ?></label>
					</td> 
					<td>
						<input type="checkbox" name="inscharge" value="<?php echo $row["Installation"] ?>"/>
						<label for="inscharge">Installation Charge: $<?php echo $row["Installation"] ?></label>
					</td> 
					<td>
						<input type="checkbox" name="haulcharge" value="<?php echo $row["Haul_Away"] ?>"/>
						<label for="haulcharge">Haul-Away Charge: $<?php echo $row["Haul_Away"] ?></label>
					</td>
					<td><button type="submit" name="addtocart" id="addtocart" class="addtocart">Add to Cart</button></td>
					<input type="hidden" name="prodtype" id="prodtype" value="<?php echo $productType ?>"/>
					<input type="hidden" name="productID" id="productID" value="<?php echo $row["Product_ID"] ?>"/>
					<input type="hidden" name="description" id="description" value="<?php echo $row["Description"] ?>"/>
					<input type="hidden" name="price" id="price" value="<?php echo $row["Price"] ?>"/>
				</form>
			</tr>
		</tbody>
	</table>
	<?php
		}
	?>
</body>

</html>