<?php session_start();
?>


<!DOCTYPE html>
<html>
<head>
	<title>Add Product</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="AddProduct.css">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700&display=swap" rel="stylesheet">
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

      <div class="white">
        <center><h2>Add Products</h2></center>
        <br>
        <br>
       <form action="addProduct.php" method="post" class="form-group" enctype="multipart/form-data">
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-2">
              <label><h5>Product ID</h5></label>
              <input type="text" class="form-control" name="product_id" required>
                </div>

                <div class="col-lg-6 col-md-6">
              <label><h5>Product Name</h5></label>
              <input type="text" name="product_name" class="form-control"   required >
               </div>
             </div>
             <br>
             <br>

              <div class="row">
                <div class="col-lg-6 col-md-6">
              <label><h5>Product Stock</h5></label>
              <input type="number" name="product_stock" class="form-control"  required >
                </div>

                <div class="col-lg-6 col-md-6">
              <label><h5>Product Price</h5></label>
              <input type="number" name="product_price" class="form-control"  required >
                </div>


              </div>
              <br>
              <br>
              <label><h5>Adding Image</h5> </label>
              <input type="file" name="image" class="form-control" required>
              <br>
              <br>
              <label><h5>Product Description</h5> </label>
              <input type="text" class="form-control" name="product_des" required>

							<br>
              <br>
              <label><h5>Supplier name</h5> </label>
              <input type="text"  name="supplier" class="form-control">

							<br>
              <br>
              <label><h5>Price</h5> </label>
              <input type="number"  name="price" class="form-control">

							<br>
              <br>
              <label><h5>bought material</h5> </label>
              <input type="text"  name="bought" class="form-control">

							<input type="submit" class="btn btn-info Btn" name="submit" value="Add Now">

        </form>

      </div>

</body>
</html>

<?php

if(isset($_POST['submit'])){
  $product_id = $_POST['product_id'];
  $product_name = $_POST['product_name'];
  $product_description = $_POST['product_des'];
  $product_stock = $_POST['product_stock'];
  $product_price = $_POST['product_price'];
  $image = $_FILES['image']['name'];
  $image_file = $_FILES['image']['tmp_name'];
	$supplier = $_POST['supplier'];
	$material_price = $_POST['price'];
	$material_bought = $_POST['bought'];
  //connection with database.



  $connection_database = mysqli_connect('localhost','root','','RAMStore');
  //now sending the query!

  $query = "insert into product(pid,pname,pdes,pstock,price,image) values('$product_id','$product_name','$product_description','$product_stock','$product_price','$image')";
  $Check_query = mysqli_query($connection_database,$query);

  move_uploaded_file($image_file,"Images/'$image'");

	$Query = "insert into supplier(Name,price,bought) values('$supplier','$material_price','$material_bought')";
	$Send = mysqli_query($connection_database,$Query);

}

?>
