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
        <center>
        <form class="form-inline">
    		<input class="form-control mr-sm-2" type="search" placeholder="Search items here" aria-label="Search" name="search">
    		<button class="btn btn-info my-2 my-sm-0" type="submit" name = "button_search">Search</button>
  			</form></center>

  			<br>
  			<br>
  			<br>
  			<table class="table table-bordered table-sm Size">
  <thead>
    <tr>
      <th scope="col">ProductID</th>
      <th scope="col">Product Name</th>
      <th scope="col">Product Description</th>
      <th scope="col">Product Stock</th>
      <th scope="col">Product Price</th>
    </tr>
  </thead>

  <?php

                //fetching data..

                $connection_database=mysqli_connect('localhost','root','','RAMStore');
                $query = "select * from product";
                $query_sent = mysqli_query($connection_database,$query);

              if(isset($_POST['button_search'])){
                  $searched_by_admin = $_POST['search'];

                  $search_query = "select * from product where pname like '$searched_by_admin%'";

                  $query_sent = mysqli_query($connection_database,$search_query);


                  while($fetching_Data = mysqli_fetch_assoc($query_sent)){
                    $pid = $fetching_Data['pid'];
                    $pname = $fetching_Data['pname'];
                    $pdes = $fetching_Data['pdes'];
                    $pstock = $fetching_Data['pstock'];
                    $price = $fetching_Data['price'];



                    echo "<tr>
                        <td><b>$pid</b></td>
                        <td><b>$pname</b></td>
                        <td><b>$pdes</b></td>
                        <td><b>$pstock</b></td>
                        <td><b>$price</b></td>
                        <td><a href='manageProduct.php?delete_id=$pid'>Delete</a></td>
                        <td><a href='manageProduct.php?update_id=$pid'>Edit</a></td>

                    </tr>";
                  }





              }else{

                while($fetching_Data = mysqli_fetch_assoc($query_sent)){
                  $pid = $fetching_Data['pid'];
                  $pname = $fetching_Data['pname'];
                  $pdes = $fetching_Data['pdes'];
                  $pstock = $fetching_Data['pstock'];
                  $price = $fetching_Data['price'];


                  echo "<tr>
                      <td><b>$pid</b></td>
                      <td><b>$pname</b></td>
                      <td><b>$pdes</b></td>
                      <td><b>$pstock</b></td>
                      <td><b>$price</b></td>
                      <td><a href='manageProduct.php?delete_id=$pid'>Delete</a></td>
                      <td><a href='manageProduct.php?update_id=$pid'>Edit</a></td>

                  </tr>";
                  }

                }


             ?>


    <?php
if(isset($_GET['delete_id'])){
  $delete_product = $_GET['delete_id'];
  $query = "delete from product where pid='$delete_product'";
  $send_query = mysqli_query($connection_database,$query);
	header("location: manageProduct.php");

}
?>


<?php
    if(isset($_GET['update_id'])){
      $value=$_GET['update_id'];
      include 'update_admin.php';



  }


      ?>



      <?php
  if(isset($_POST['send_update'])){
    $show_id = $_GET['update_id'];
    $updated_name = $_POST['product_name'];
    $updated_des = $_POST['product_des'];
    $updated_stock = $_POST['stock'];
    $updated_price = $_POST['price'];


    $query = "update product set pname ='$updated_name',pdes='$updated_des',pstock='$updated_stock',price='$updated_price' where pid='$show_id'";
    $check_query = mysqli_query($connection_database,$query);
    header("Location: manageProduct.php");


  }


?>


</body>
</html>
