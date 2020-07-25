<?php
session_set_cookie_params(0);
session_start();

if (!isset($_SESSION['items'])) {
	$_SESSION['items'] = 0;
}
if (!isset($_SESSION['totalprice'])) {
	$_SESSION['totalprice'] = 0;
}
//print_r($_SESSION);
//echo session_id();

if($_SERVER['REQUEST_METHOD'] == "POST") {
	if (!isset($_SESSION['cart'])) {
		$_SESSION['cart'] = array();
	} 
	
	$change = false;
	$i = 0;
	foreach ($_SESSION['cart'] as &$result) {
		if ($result[0] == $_POST['productID']) {
			$result[3] += 1;
			$change = true;
		}
		$i = $i + 1;		
	}
	
	if (!$change) {
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
		array_push($product, 1);
		array_push($_SESSION['cart'], $product);
	}
	
	$_SESSION['items'] += 1;
	
	
	
	//var_dump($_SESSION['totalprice']);
	//print_r($_SESSION);
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
		<div class="price"> Price: $<?php echo $_SESSION['totalprice'] ?> </div>
		
	</header>
	<button type="submit" name="cart" class="checkout" onclick="location.href='checkout.php';">Checkout</button>
	
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
				<td><input type="checkbox" name="delcharge"/> &nbsp <label for="delcharge">Delivery Charge: <?php echo $row["Delivery"] ?></label> &nbsp </td> 
				<td><input type="checkbox" name="inscharge"/> &nbsp <label for="inscharge">Installation Charge: <?php echo $row["Installation"] ?></label> &nbsp </td> 
				<td><input type="checkbox" name="haulaway"/> &nbsp <label for="haulaway">Haul-Away Charge: <?php echo $row["Haul_Away"] ?></label> &nbsp </td> 
				<td>
					<form method="POST" action="">
						<button type="submit" name="addtocart" id="addtocart" class="addtocart">Add to Cart</button>
						<input type="hidden" name="prodtype" id="prodtype" value="<?php echo $productType ?>"/>
						<input type="hidden" name="productID" id="productID" value="<?php echo $row["Product_ID"] ?>"/>
						<input type="hidden" name="description" id="description" value="<?php echo $row["Description"] ?>"/>
						<input type="hidden" name="price" id="price" value="<?php echo $row["Price"] ?>"/>
					</form>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
		}
	?>
</body>

</html>