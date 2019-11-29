<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<title>Manage Product</title>
	<!DOCTYPE html>
<html>
<head>
	<title>Add Product</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="ManageProduct.css">
    <link rel="icon" type="text/css" href="https://i.ibb.co/XXGQ3X9/favicon-32x32.png">

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

												$query = "select name from admin where ID='$admin_name'";
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
											}?>


                    </li>

                </ul>
            </div>
        </nav>
        <br>
        <br>
        <br>

        <center><table border="2px">
          <tr>
            <th>PromoCode</th>
            <th>Discount%</th>
        <?php

        //showing table................
        $query = "select * from Promocode";
        $connection_database = mysqli_connect('localhost','root','','RAMStore');
        $querySend = mysqli_query($connection_database,$query);

        while($showData = mysqli_fetch_assoc($querySend)){
             $promo = $showData['promo'];
             $discount = $showData['discount'];
             echo "<tr>
                      <td>$promo</td>
                      <td>$discount</td>
                      <td><a href=promocode.php?deletecode=$promo>delete</a>
                  </tr>

             ";


        }
        echo "</table></center>";


          if(isset($_GET['deletecode'])){
            $query = "select username from RegisterCustomer";
            $sendQuery = mysqli_query($connection_database,$query);
            while($show = mysqli_fetch_assoc($sendQuery)){
                 $username = $show['username'];

                 $Query = "update RegisterCustomer set promo ='non' where username = '$username'";
                 $SEND =  mysqli_query($connection_database,$Query);

            }


            $delete = $_GET['deletecode'];
            $querydelete = "delete from Promocode where promo='$delete'";
            $send = mysqli_query($connection_database,$querydelete);
            header("Location: promocode.php");

          }

         ?>
         <br>
         <br>

         <h4>Create promo code<h4>
        <form action="promocode.php" method="post">
          <input type="text" placeholder="Enter promoCode" name="promocode"><br>
          <input type="number" step="0.01" placeholder="Enter discount in float." name="percent"><br>
            <input type="submit" value="Set promo" name="setPromo"><br>
          <h4> Email</h4><br>
          <input type="text" placeholder="Enter Subject" name="subject"><br>
          <input type="text" placeholder="Enter your message" name="msg"><br>
          <input type="submit" value="Send Email" name="sendEmail">

        </form>

        <?php

          //setting promo code in database!
          if(isset($_POST['setPromo'])){
              $promoCode = $_POST['promocode'];
              $discount = $_POST['percent'];

              $query = "insert into Promocode(promo,discount) values('$promoCode','$discount')";
              $send = mysqli_query($connection_database,$query);

              $query = "select username from RegisterCustomer";
              $sendQuery = mysqli_query($connection_database,$query);
              while($show = mysqli_fetch_assoc($sendQuery)){
                   $username = $show['username'];

                   $Query = "update RegisterCustomer set promo = '$promoCode' where username = '$username'";
                   $SEND =  mysqli_query($connection_database,$Query);

              }

              header("Location: promocode.php");
          }

          $ramstore = "noreply@ramstore.com";
          if(isset($_POST['sendEmail'])){
              $subject = wordwrap($_POST['subject'],70);
              $msg = $_POST['msg'];
              $query = "select email from RegisterCustomer";
              $sendQuery = mysqli_query($connection_database,$query);
              while($show = mysqli_fetch_assoc($sendQuery)){
                   $email = $show['email'];
                   if(mail($email,$subject,$msg,$ramstore)){
                     echo "Mail sent";
                   }else{
                     echo "Mail failed!";
                   }
              }

          }



         ?>




    </body>
    </html>
