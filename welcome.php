<?php session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome To RAMSTORE</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="Welcome.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Cabin&display=swap" rel="stylesheet">
	<link rel="icon" type="text/css" href="https://i.ibb.co/XXGQ3X9/favicon-32x32.png">
</head>
<body>

	<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
					<a class="navbar-brand" href="welcome.php">RAMSTORE</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
					</button>
					<form class="form-inline" action="welcome.php" method="post">
					<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search_query">
					<button class="btn btn-info my-2 my-sm-0" type="submit" name="search_button">Search</button>
					</form>

					<div class="collapse navbar-collapse" id="navbarTogglerDemo01">

							<ul class="navbar-nav ml-auto">
									<li class="nav-item">
											<a class="nav-link" href="welcome.php">View Items</a>
									</li>

									<li class="nav-item">
											<a class="nav-link" href="#">About Us</a>
									</li>
									<li class="nav-item">
											<a class="nav-link" href="#">Contact</a>
									</li>

								</li>
								<li class="nav-item">
										<a class="nav-link" href="Cart.php">Cart</a>
								</li>

									<?php


									if(isset($_SESSION['flagLogin'])){
										$value = $_SESSION['flagLogin'];
									if($value == 2){
											echo "<li class='nav-item'>
												<a class='nav-link' href=admin.php>Panel</a>
										</li>

										<li class='nav-item'>
											<a class='nav-link' href=logout.php>logout</a>
									</li>";

									}else if($value == 1){
										$customer_name = $_SESSION['Customer_Name'];
										echo "<li class='nav-item'>
											<a class='nav-link' href=reg_customer.php>$customer_name</a>
									</li>

									<li class='nav-item'>
										<a class='nav-link' href=logout.php>logout</a>
								</li>";

									}else if($value == 3){

									}
								}else{
									echo "<li class='nav-item'>
											<a class='nav-link' href=login.php>Login</a>
									</li>";
								}

								?>
							</ul>
					</div>
			</nav>

			 <div class="container-fluid p1">
						 <h1>Furnish Your Home, Furnish Your Life</h1>
					</div>

				 <h2>Latest Items</h2>
				<center><p>BEST Furniture Collection Available</p></center>


					<br>
					<br>


<?php

	$query = "select * from product";
	$connection_database = mysqli_connect('localhost','root','','RAMStore');
	$submit_query = mysqli_query($connection_database,$query);
	static $counter =0;
	static $i;
	$dynamic_table="<table><tr>";

	if(isset($_POST['search_button'])){
		$searching_product = $_POST['search_query'];
		$query = "select * from product where pname like '%$searching_product%'";
		$submit_query = mysqli_query($connection_database,$query);

		while($fetch_data = mysqli_fetch_assoc($submit_query))
		{
				$p_name = $fetch_data['pname'];
				$price = $fetch_data['price'];
				$image = $fetch_data['image'];
				$p_id = $fetch_data['pid'];

				if($counter < 4){
				$dynamic_table.="
				<td>
				<form action='welcome.php' method='post'>
				<div class='card f1' style='width: 300px'>
				<img class='card-img-top' src=Images/'$image' style='width: 100%'>
				<div class='card-body'>
						<a href='product.php?product_id=$p_id'>$p_name</a>
						<h5>Price: $price</h5>
							<input type='number' name='quantity' value='1'>
								<input type='submit' value='Cart' name='add'>
							</form>
				</div>
				</div>
				</td>";

				$counter++;
			}else{
				$dynamic_table.="</tr><tr>";
				$counter=0;
			}

		}
		$dynamic_table.="</tr></table>";

		echo $dynamic_table;
	}else{

	while($fetch_data = mysqli_fetch_assoc($submit_query))
	{
			$p_name = $fetch_data['pname'];
			$price = $fetch_data['price'];
			$image = $fetch_data['image'];
			$p_id = $fetch_data['pid'];

			if($counter < 4){
			$dynamic_table.="
			<td>
			<form action='welcome.php?addtoCart=$p_id' method='post'>
			<div class='card f1' style='width: 300px'>
			<img class='card-img-top' src=Images/'$image' style='width: 100%'>
			<div class='card-body'>
					<a href='product.php?product_id=$p_id'>$p_name</a>
					<h5>Price: $price</h5>
						<input type='number' name='quantity' value='1'>
								<input type='submit' value='Cart' name='add'>
						</form>

			</div>
			</div>
			</td>";
			$counter++;
		}else{
			$dynamic_table.="</tr><tr>";
			$counter=0;
		}


	}
	$dynamic_table.="</tr></table>";

	echo $dynamic_table;
}

if(isset($_POST['add'])){

	$value = $_GET['addtoCart'];
	$quantity = $_POST['quantity'];

	$query = "select price from product where pid='$value'";
	$connection_database = mysqli_connect('localhost','root','','RAMStore');
	$send_query = mysqli_query($connection_database,$query);

	while($fetch_productPrice = mysqli_fetch_assoc($send_query)){
	$pPrice = $fetch_productPrice['price'];
	}

	$Query = "insert into Cart(price,quantity,pid) values('$pPrice','$quantity','$value')";
  $Send_query = mysqli_query($connection_database,$Query);




	}




?>




</div>

</body>
</html>
