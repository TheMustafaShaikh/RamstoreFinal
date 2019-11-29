
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
					<a class="navbar-brand" href="">RAMSTORE</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
					</button>
					<form class="form-inline">
					<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
					<button class="btn btn-info my-2 my-sm-0" type="submit">Search</button>
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

							</ul>
					</div>
			</nav>

  </body>

</html>

<?php
  //showing the details of the product..
  if(isset($_GET['product_id'])){
		echo "<br><br><br>";
			$id = $_GET['product_id'];

			$connection_database = mysqli_connect('localhost','root','','RAMStore');
			$query = "select * from product where pid='$id'";
      $sent_query = mysqli_query($connection_database,$query);
			while($fetch = mysqli_fetch_assoc($sent_query)){
						$image = $fetch['image'];
						$name = $fetch['pname'];
						$desc = $fetch['pdes'];
						$stock = $fetch['pstock'];
						$price = $fetch['price'];

							echo "<img src = Images/'$image' width = 300px>";
							echo "<br><h3><b>Product: </b>$name</h2>";
							echo "<br><h5><b>Price: $price</b></h5>";
							if($stock > 0){
								echo "<br><h5><b>Available Stock: $stock </b></h5>";
							}else{
								echo "<br><h5><b>Product is unavailable.</b></h5>";
							}
							echo "<br><h4><b>Product Description: </b>$desc</h4>";

}



  }




?>
