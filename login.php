<?php session_start();
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

    <link rel="stylesheet" type="text/css" href="Login.css">


  </head>
  <body>




    <section class="container-fluid bg">
      <section class="row justify-content-center">
        <section class="col-12">

          <form class="form-container" action="login.php" method="post">
          <div class="form-group">
          <center><h4>Username</h4></center>

          <input type="text" class="form-control" name="username" aria-describedby="emailHelp" placeholder="Enter Username">

          <br>
          </div>
          <div class="form-group">
          <center><label for="exampleInputPassword1"><h4>Password</h4></label></center>
          <input type="password" class="form-control" name="password" placeholder="Password">
          </div>
          <center><button type="submit" class="btn btn-info Btn" name="submit">Login</button></center>
          </form>


            </div>

          </form>

        </section>

      </section>

    </section>


  </body>
</html>



<?php
//php code..

/*
* Session = 1 is login for Register customer.
* Session = 2 is login for Administrator.
* Session = 3 is login for Owner.
*/

  if(isset($_POST['submit'])){
      $username = $_POST['username'];
      $password = $_POST['password'];

      $connection_database = mysqli_connect('localhost','root','','RAMStore');
      /*if($connection_database){
        echo "Connected successfully!"; Database system connected successfully.
      }*/

      //clearing text for security purpose.
      $clear_username = mysqli_real_escape_string($connection_database,$username);
      $clear_password = mysqli_real_escape_string($connection_database,$password);

    static $flag_checker=0;
    $query = "select username,password from RegisterCustomer";
    $Check_query = mysqli_query($connection_database,$query);

    // '===' used to check strongly equal.

    while($data_tobe_check = mysqli_fetch_assoc($Check_query)){
        if($data_tobe_check['username'] === $clear_username && $data_tobe_check['password'] === $clear_password){
          $_SESSION['flagLogin'] = 1;
          $_SESSION['Customer_Name'] = $clear_username;
          header("Location: welcome.php");
          $flag_checker++;
        }
    }

    $query = "select ID,pass from admin";
    $Check_query = mysqli_query($connection_database,$query);

    while($data_tobe_check = mysqli_fetch_assoc($Check_query)){
        if($data_tobe_check['ID'] === $clear_username && $data_tobe_check['pass'] === $clear_password){
          $_SESSION['flagLogin'] = 2;
          $_SESSION['adminID'] = $clear_username;
          header("Location: admin.php");
          $flag_checker++;

        }
    }

    $query = "select username,password from Owner";
    $Check_query = mysqli_query($connection_database,$query);

    while($data_tobe_check = mysqli_fetch_assoc($Check_query)){
        if($data_tobe_check['username'] === $clear_username && $data_tobe_check['password'] === $clear_password){
          $flag_checker++;
          $_SESSION['flagLogin'] = 3;
          $_SESSION['ownerID'] = $data_tobe_check['username'];
          header("Location: owner.php");

        }
    }

    if($flag_checker<=0){
      echo "<center><h5>      Sorry, Wrong password.</h5></center>";
    }




  }




?>
