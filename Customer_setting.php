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
        <?php
        $c_name = $_SESSION['Customer_Name'];
        $query = "select * from RegisterCustomer where username ='$c_name'";
        $connection_database = mysqli_connect('localhost','root','','RAMStore');
        $sent_query = mysqli_query($connection_database,$query);
        $data = mysqli_fetch_assoc($sent_query);
          //fetching data!
          $password = $data['password'];
          $address = $data['address'];
          $email = $data['email'];
          $phone_number = $data['phonenumber'];

          //displaying the data..

          echo"
          <form action='Customer_setting.php' method='post'>
          <input type='text' name='password' value=$password>
          <input type='text' name='address' value=$address>
          <input type='email' name='email' value=$email>
          <input type='tel' name='phone' value=$phone_number>
          <input type='submit' name='update' value='Update'>
          </form>


          ";

          if(isset($_POST['update'])){
            $updated_password = $_POST['password'];
            $updated_address = $_POST['address'];
            $updated_email = $_POST['email'];
            $updated_phone = $_POST['phone'];

            $query = "update RegisterCustomer set password='$updated_password',address='$updated_email',email='$updated_email',phonenumber='$updated_phone'";
            $sent_query = mysqli_query($connection_database,$query);







        }



         ?>


      </body>
      </html>
