<?php

  //now fetching the data from the forms.

  //now fetching the data from the forms.

  if(isset($_POST['submit'])){
    //storing the data in variables;


    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];

    //$reg_user = new register_user($username,$password,$phone,$address,$email);


    //now storing the data into SQLiteDatabase..

    $connection_database = mysqli_connect('localhost','root','','RAMStore');
    //checking if database is connected or not..admin

    /*if($connection_database){
      echo "Successfully connected!"; //database conneteced!
    }else{
      echo "Error in connecting the database.";
    }*/

    $query = "insert into RegisterCustomer(username,password,address,email,promo,phonenumber) values('$username','$password','$address','$email','non','$phone')";

    $Check_query = mysqli_query($connection_database,$query);
    if($Check_query){
      echo "Success query!";
    }else{
      echo "Change Your USERNAME.";
    }




  }

 ?>




<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>RAMSTORE</title>

    <link rel="icon" type="text/css" href="https://i.ibb.co/XXGQ3X9/favicon-32x32.png">

   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="register.css">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700&display=swap" rel="stylesheet">

  </head>
  <body>

    <div class="white">


      <h3>Customer Registration</h3>
      <br>
      <br>

      <form action="register.php" method="post" class="form-group">
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-2">
              <label><h5>Email</h5></label>
              <input type="email" name="email" class="form-control" placeholder="Enter your EMAIL" required>
                </div>

                <div class="col-lg-6 col-md-6">
              <label><h5>Username </h5></label>
              <input type="text" name="username" class="form-control"  placeholder="Username" required >
               </div>
             </div>
             <br>
             <br>

              <div class="row">
                <div class="col-lg-6 col-md-6">
              <label><h5>Password</h5></label>
              <input type="password" name="password" class="form-control" placeholder="Password" required >
                </div>

                <div class="col-lg-6 col-md-6">
              <label><h5>Phone Number</h5></label>
              <input type="tel" name="phone" class="form-control" placeholder="Phone Number" required >
                </div>

              </div>
              <br>
              <br>
              <label><h5>Address</h5> </label>
              <input type="text" name="address" class="form-control" placeholder="Address" required>
              <button type="submit" name ="submit" class="btn btn-info Btn">Register Now</button>

        </form>
    </div>








  </body>
</html>
