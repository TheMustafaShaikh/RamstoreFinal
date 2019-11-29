<?php
session_start();
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
                      $owner=$_SESSION['ownerID'];
                      echo "<li class='nav-item'>
                        <a class='nav-link' href=ower.php>$owner</a>
                    </li>

                    <li class='nav-item'>
                      <a class='nav-link' href=logout.php>logout</a>
                  </li>";
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

      <br>
      <br>
      <br>
      <br>
      <h2 style="color:black"><center>Your Cart</center></h2>

      <?php
      include 'cartFunction.php';

          $query = "select * from product where pid in(select pid from Cart)";
          $connection_database = mysqli_connect('localhost','root','','RAMStore');
          $send_query = mysqli_query($connection_database,$query);




//          $counter = 0;

        //  $dynamic_table = "<table><tr>";
        $total_bill=0;
          while($fetch_data = mysqli_fetch_assoc($send_query))
          {
              $pid = $fetch_data['pid'];
              $price = $fetch_data['price'];
              $name = $fetch_data['pname'];
              //$quantity = $fetch_data['quantity'];
              $image = $fetch_data['image'];

              $quantity = getQuantity($pid);
                echo "
                <table border='2'>
                <tr>
                <td><img src=Images/'$image' width=100px></td>
                <td>Product Name: $name</td>
                <td>Price: $price</td>
                <td>Quantity: $quantity</td>
                <td><a href=Cart.php?Delete_id=$pid>delete</a></td>
                </tr>
                ";

                $total_bill +=$quantity*$price;


          }
        echo "</table>
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

        <h2> Total Price: $total_bill</h2>
        <form action='Cart.php' method='post'>
        <center>
          <input type='text' placeholder='PromoCode' name='promoChecker'>
          <input type='submit' value='apply and checkout' name='promo'>
          </center>
        </form>
        <br>

        ";

          if(isset($_GET['Delete_id'])){
            $deleted_id = $_GET['Delete_id'];
            $delete_query = "delete from Cart where pid='$deleted_id'";
            $query_send = mysqli_query($connection_database,$delete_query);
            header("Location: Cart.php");
          }

          //inserting data in table registr customer.

          if(isset($_POST['promo'])){
              $promoCode = $_POST['promoChecker'];
              $Query = "select promo from RegisterCustomer where username='$customer_name'";
              $querySend = mysqli_query($connection_database,$Query);

              while($checking = mysqli_fetch_assoc($querySend)){
                  $ReallPromo = $checking['promo'];
                  if($promoCode == $ReallPromo){
                    $tableRead = "select discount from Promocode where promo =(select promo from RegisterCustomer where username='$customer_name')";
                    $send_query = mysqli_query($connection_database,$tableRead);
                    while($table = mysqli_fetch_assoc($send_query)){
                      $discount = $table['discount'];
                      $promo_dis = $total_bill * $discount;
                      $total_amount_after_Discount = $total_bill - $promo_dis;

                      echo "<center><h3>After discount = $total_amount_after_Discount</h3></center>
                      <br>
                      <center><h4>Thanks for ordering from RamStore, Hope to see you again.</h4></center>
                      ";

                      $QUERYPAYMENT = "insert into paymentRC(username,payment,afterDiscount) values('$customer_name','$total_bill',$total_amount_after_Discount)";
                      $QUERYDBSENT = mysqli_query($connection_database,$QUERYPAYMENT);


                      $fetchQuery = "select distinct(pid),quantity from Cart";
                      $fetchRun = mysqli_query($connection_database,$fetchQuery);

                      while($showData = mysqli_fetch_assoc($fetchRun)){
                        $Quantity = $showData['quantity'];
                        $Pid = $showData['pid'];
                        $Status = "Ordered";


                          //now sending data to RegisterCustomer details!
                     $FinalQuery = "insert into showDetailsRC(status,price,quantity,pid,username) values('$Status','$total_amount_after_Discount','$Quantity','$Pid','$customer_name')";
                      $FinalSendQuery = mysqli_query($connection_database,$FinalQuery);

                      $QUERYREMOVEPROMO = "update RegisterCustomer set promo=non where username='$customer_name'";
                      $SENDREMOVE = mysqli_query($connection_database,$QUERYREMOVEPROMO);

                      }
                      //now deleting all items that has been stored in cart!

                      $DeleteCart = "delete from Cart";
                      $DeletehRun = mysqli_query($connection_database,$DeleteCart);


                    }
                  }else{
                    echo "Sorry, You entered invalid promo code.";
                  }


              }





          }






       ?>







      <form action="Cart.php" method="post">
        <center><input type="submit" value="Checkout" name="out"></center>

      </form>

<?php

      if(isset($_POST['out'])){



        //checking sessions!
        if(isset($_SESSION['flagLogin'])){
          $check_value = $_SESSION['flagLogin'];
          if($check_value == 1){
            //register customer can order!
            //now getting details of registerCustomer!

            $RC = $_SESSION['Customer_Name'];
            $query = "select * from Cart";
            $total_price = 0;
            $Send_query = mysqli_query($connection_database,$query);
            while($show = mysqli_fetch_assoc($Send_query)){
              $pid = $show['pid'];
              $quantity = $show['quantity'];
              $price = $show['price'];

              $total_price += $quantity * $price;

              $QUERY = "insert into showDetailsRC(status,price,quantity,username) values('Ordered','$total_price','$quantity','$RC')";
              $send = mysqli_query($connection_database,$QUERY);

              echo "You have successfully ordered!";

            }

            $QUERYPAYMENT = "insert into paymentRC(username,payment,afterDiscount) values('$RC','$total_price','0')";
            $QUERYDBSENT = mysqli_query($connection_database,$QUERYPAYMENT);

            //now deleting all things from cart! as you have ordered!
            $DeleteCart = "delete from Cart";
            $DeletehRun = mysqli_query($connection_database,$DeleteCart);
            header("Location: welcome.php");

          }else{
            echo "Sorry, you dont have rights. ";
          }

        }else{

            //for guest customer/
            echo "<form action='Cart.php' method='post'>
                <input type='text' name='Guestname' placeholder='enter your name'>
                <input type='tel' name='phone' placeholder='enter your phone number'>
                <input type='email' name='email' placeholder='enter your email'>
                <input type='text' name='address' placeholder='enter your address'>
                <input type='submit' name='confirm' value='confirm'>
            </form>
            ";

        }




      }

      if(isset($_POST['confirm'])){
        $name = $_POST['Guestname'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];

        $query = "insert into GuestCustomer values('$name','$phone','$address','$email')";
        //$send = mysqli_query($connection_database,$query);

        $total_price = 0;
        $Query = "select * from Cart";
        $sen=mysqli_query($connection_database,$Query);
        while($ft = mysqli_fetch_assoc($sen)){
          $quantity = $ft['quantity'];
          $price = $ft['price'];
          $total_price +=$quantity*$price;
        }


        $Query = "select * from Cart";
        $send = mysqli_query($connection_database,$Query);
        $connection_database = mysqli_connect('localhost','root','','RAMStore');
        while($data = mysqli_fetch_assoc($send)){
          $pid=$data['pid'];
          $Quantity = $data['quantity'];
          $price = $data['price'];


          $QUERY = "insert into showDetailsGC values('ordered','$price','$Quantity','$pid','$email')";
          $Send = mysqli_query($connection_database,$QUERY);


        }

        $Query = "insert into paymentGC values('$total_price','$email')";
        $Send = mysqli_query($connection_database,$Query);

        $QUery = "delete from Cart";
        $SEnd = mysqli_query($connection_database,$QUery);

        header("Location: Cart.php");

      }



 ?>




    </body>
    </html>
