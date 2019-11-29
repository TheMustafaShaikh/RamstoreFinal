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
                        <a class='dropdown-item' href='promocode.php'>promo code</a>
                        <a class='dropdown-item' href='manageorder.php'>manage order</a>
                         <div class='dropdown-divider'></div>
                        <a class='dropdown-item' href=logout.php>Log Out</a>";
											}
												?>

                    </li>

                </ul>
            </div>
        </nav>
        <br>
        <br>
        <br>

        <center><table border="2px" style="color:black">
            <tr>
              <td>Register Customer</td>
              <td>Product name</td>
              <td>Price</td>
              <td>Status</td>
              <td>Status Change</td>

            </tr>
            <?php

            $query = "select showDetailsRC.username,showDetailsRC.orderno,showDetailsRC.price,showDetailsRC.status,product.pname,showDetailsRC.pid
                    from showDetailsRC,product
                    where product.pid=showDetailsRC.pid;
            ";

            $send = mysqli_query($connection_database,$query);
            while($fetch = mysqli_fetch_assoc($send)){
              $p_id = $fetch['pid'];
              $c_name = $fetch['username'];
              $p_name = $fetch['pname'];
              $price = $fetch['price'];
              $status = $fetch['status'];
              $orderno = $fetch['orderno'];


              echo "
              <tr>
                <td>$c_name</td>
                <td>$p_name</td>
                <td>$price</td>
                <td>$status</td>
                <td><a href='manageorder.php?delivered=$orderno'>Delivered</a></td>
                <td><a href='manageorder.php?cancelled=$orderno'>Cancelled</a></td>

              </tr>
              ";


            }



            if(isset($_GET['delivered'])){
              $no = $_GET['delivered'];
              $query = "update showDetailsRC set status='Delivered' where orderno='$no'";
              $SendServer = mysqli_query($connection_database,$query);

							$QUERY = "select * from showDetailsRC where order='$no'";
							$SEND = mysqli_query($connection_database,$QUERY);

							while($fetch = mysqli_fetch_assoc($SEND)){
								$minus_quantity = $fetch['quantity'];

								$QUERY = "select pstock,pid from product where pid=(select pid from showDetailsRC where orderno='$no')";
								$SEND = mysqli_query($connection_database,$QUERY);
								while($displayQuantity = mysqli_fetch_assoc($SEND)){
									$stock_available = $displayQuantity['pstock'];
									$updated = $stock_available - $minus_quantity;
									$id = $displayQuantity['pid'];
									$updateQuery = "update product set pstock=$updated where pid=$id";
									$snd = mysqli_query($connection_database,$updateQuery);
								}


							}

								header("location: manageorder.php");


            }

            if(isset($_GET['cancelled'])){
              $no = $_GET['cancelled'];
              $query = "update showDetailsRC set status='Cancelled' where orderno='$no'";
              $SendServer = mysqli_query($connection_database,$query);

            }


             ?>
           </table></center>





  </body>
  </html>
