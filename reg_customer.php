<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<title>Customer</title>
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
                        <a class="nav-link op1" href="welcome.php">Buy Product</a>
                    </li>

                    <li class="nav-item dropdown">
											<?php
												$customer_name = $_SESSION['Customer_Name'];

											  echo "<a class='nav-link dropdown-toggle op4' href='' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>$customer_name</a>
                        <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                        <a class='dropdown-item' href='Customer_setting.php'>Setting</a>
                         <div class='dropdown-divider'></div>
                        <a class='dropdown-item' href=logout.php>Log Out</a>";

												?>

                    </li>

                </ul>
            </div>
        </nav>
        <br>
        <br>
        <br>
        <h2><center>History of previous product</center></h2>
				<?php

				//placing dynamic table.
				$query = "select showDetailsRC.pid,showDetailsRC.price,showDetailsRC.quantity,showDetailsRC.status,product.pname
				from showDetailsRC,product
				where product.pid = showDetailsRC.pid and showDetailsRC.username = '$customer_name';

				";
				$connection_database = mysqli_connect('localhost','root','','RAMStore');
				$query_send = mysqli_query($connection_database,$query);
				echo "<center><table border=2 style='color:black'>
					<tr>
						<th>No.Order</th>
						<th>Product name</th>
						<th>Price</th>
						<th>quantity</th>
						<th>status</th>
					</tr>

				";

				$no_of_order=0;
				while($GetData = mysqli_fetch_assoc($query_send)){
				$no_of_order++;
					$product_name = $GetData['pname'];
					$price = $GetData['price'];
					$quantity = $GetData['quantity'];
					$status = $GetData['status'];
					$product_id= $GetData['pid'];

						echo "
							<tr>
								<td>$no_of_order</td>
								<td><a href=product.php?product_id=$product_id>$product_name</a></td>
								<td>$price</td>
								<td>$quantity</td>
								<td>$status</td>
								</tr>
						";


				}
				echo "</table></center>";


				 ?>





    </body>
    </html>
