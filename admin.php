<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <link rel="icon" type="text/css" href="https://i.ibb.co/XXGQ3X9/favicon-32x32.png">
    <link rel="stylesheet" type="text/css" href="Admin.css">
    <link href="https://fonts.googleapis.com/css?family=Cabin&display=swap" rel="stylesheet">

</head>
<body>

   <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark custom-carets">
            <a class="navbar-brand" href="">RAMSTORE</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">

                <ul class="navbar-nav ml-auto">
                	<li class="nav-item">
                        <a class="nav-link op1" href="addProduct.php">Add Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link op2" href="manageProduct.php">Manage Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link op3" href="manageCustomer.php">Manage Customer</a>
                    </li>

                    <li class="nav-item dropdown">
											<?php
												$admin_name = $_SESSION['adminID'];

												$query = "select name from admin where ID=$admin_name";
												$connection_database = mysqli_connect('localhost','root','','RAMStore');
												$sent_query = mysqli_query($connection_database,$query);
												while($name = mysqli_fetch_assoc($sent_query)){
													$admin_Name = $name['name'];

											  echo "<a class='nav-link dropdown-toggle op4' href='' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>$admin_Name</a>
                        <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                        <a class='dropdown-item' href='promocode.php'>Promo code</a>
                        <a class='dropdown-item' href='manageorder.php'>manage Order</a>
                         <div class='dropdown-divider'></div>
                        <a class='dropdown-item' href=logout.php>Log Out</a>";
											}
												?>

                    </li>

                </ul>
            </div>
        </nav>

        <h3>Current Analysis</h3>
        <br>
        <br>

        <div class="row">

                <div class="col-lg-4">
                    <div class="card" style="width: 18rem; height: 18rem; margin-left: 40px;">
  				<div class="card-body">
    			<h5 class="card-title">Total Products</h5>
    			<!--<img src="..." class="card-img-top" alt="...">-->
					<?php
					$query = "select count(pid) as total_product from product";
					$query_sent = mysqli_query($connection_database,$query);
					$total_products = mysqli_fetch_assoc($query_sent);
					$product_all = $total_products['total_product'];

    			echo "<h6 class='card-subtitle mb-2 text-muted'><b>$product_all</b></h6>";


					?>


  				</div>
				</div>
                </div>


               <div class="col-lg-4">

               	   <div class="col-lg-4">
                    <div class="card" style="width: 18rem; height: 18rem">
  				<div class="card-body">
    			<h5 class="card-title">Total Registered Customers</h5>
					<?php
					$query = "select count(username) as total_customer from RegisterCustomer";
					$query_sent = mysqli_query($connection_database,$query);
					$total_customer = mysqli_fetch_assoc($query_sent);
					$all_customer = $total_customer['total_customer'];

    			echo "<h6 class='card-subtitle mb-2 text-muted'><b>$all_customer</b></h6>";

					?>

  				</div>
				</div>
                </div>

                </div>


              <div class="col-lg-4">

              	<div class="col-lg-4">
                    <div class="card" style="width: 18rem; height: 18rem">
  				<div class="card-body">
    			<h5 class="card-title">Sales</h5>
					<?php
					$query = "select count(*) as total_payment from paymentRC";
					$query_sent = mysqli_query($connection_database,$query);
					$total_payment = mysqli_fetch_assoc($query_sent);
					$sale_all = $total_payment['total_payment'];

    			echo "<h6 class='card-subtitle mb-2 text-muted'><b>$sale_all</b></h6>";

					?>


  				</div>
				</div>
                </div>

                </div>


        </div>
        <br>

        </div>

        <br>
        <br>
        <br>
        <h4>Overall Sales</h4>




</body>
</html>
