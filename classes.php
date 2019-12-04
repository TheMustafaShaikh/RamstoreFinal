
<?php

	class Admin
	{

		var $ad_name, $ad_id, $ad_password, $pro_name, $pro_id, $pro_size, $pro_types, $pro_color, $promo_codes;

		public function ManageProduct($searched_by_admin)
		{

		if($searched_by_admin){
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

		}

		public function Create_promo($promoCode,$discount)
		{


			$query = "insert into Promocode(promo,discount) values('$promoCode','$discount')";
			$send = mysqli_query($connection_database,$query);

			$query = "select username from RegisterCustomer";
			$sendQuery = mysqli_query($connection_database,$query);
			while($show = mysqli_fetch_assoc($sendQuery)){
					 $username = $show['username'];

					 $Query = "update RegisterCustomer set promo = '$promoCode' where username = '$username'";
					 $SEND =  mysqli_query($connection_database,$Query);

		}

		public function ManageRegisterCustomer()
		{
			echo "<table class='table table-bordered table-sm Size'>
			<thead>
			<tr>
			<th scope='col'>Name</th>
			<th scope='col'>Email</th>
			<th scope='col'>PhoneNumber</th>
			<th scope='col'>Address</th>
			</tr>
			</thead>";

			$query = "select * from RegisterCustomer";
			$connection_database = mysqli_connect('localhost','root','','RAMStore');
			$sent_query = mysqli_query($connection_database,$query);

				while($data = mysqli_fetch_assoc($sent_query)){
					$name = $data['username'];
					$email = $data['email'];
					$phoneNumber = $data['phonenumber'];
					$address = $data['address'];

					echo "<tr>
						<td>$name</td>
						<td>$email</td>
						<td>$phoneNumber</td>
						<td>$address</td>
						<td><a href=manageCustomer.php?Delete_username=$name>Delete</a></td>
						</tr>

					";

				}
			echo "</table>";



		}



	}






	class RegisterCustomer
	{

		var $RC_name, $RC_address, $RC_city, $RC_contact, $RC_email, $RC_password, $RC_cnic, $RC_total_purchase;
	 function R_SearchItem($searching_product,$counter)
		{

			$query = "select * from product where pname like '%$searching_product%'";
			$connection_database = mysqli_connect('localhost','root','','RAMStore');
			$submit_query = mysqli_query($connection_database,$query);
			$dynamic_table="<table><tr>";
			while($fetch_data = mysqli_fetch_assoc($submit_query))
			{
					$p_name = $fetch_data['pname'];
					$price = $fetch_data['price'];
					$image = $fetch_data['image'];
					$p_id = $fetch_data['pid'];

					if($counter < 4){
					$dynamic_table.="
					<td>
					<form action='welcome.php' method='post'>
					<div class='card f1' style='width: 300px'>
					<img class='card-img-top' src=Images/'$image' style='width: 100%'>
					<div class='card-body'>
							<a href='product.php?product_id=$p_id'>$p_name</a>
							<h5>Price: $price</h5>
								<input type='number' name='quantity' value='1'>
									<input type='submit' value='Cart' name='add'>
								</form>
					</div>
					</div>
					</td>";

					$counter++;
				}else{
					$dynamic_table.="</tr><tr>";
					$counter=0;
				}

			}
			$dynamic_table.="</tr></table>";

			echo $dynamic_table;



		}

		 function R_add_to_cart($RC)
		{

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
	}

		 function R_get_promo($customer_name,$connection_database,$total_bill)
		{
				//promo code.

				if(isset($_POST['promo'])){
						$promoCode = $_POST['promoChecker'];
						$Query = "select promo from RegisterCustomer where username='$customer_name'";
						$querySend = mysqli_query($connection_database,$Query);

						while($checking = mysqli_fetch_assoc($querySend)){
								$ReallPromo = $checking['promo'];
								$Query = "select promo from RegisterCustomer where username='$customer_name'";
								$checkit= mysqli_query($connection_database,$Query);
								$fetch_promo = mysqli_fetch_assoc($checkit);
								$user_promo = $fetch_promo['promo'];


								if($promoCode == $ReallPromo && $promoCode == $user_promo){
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

										$QUERYREMOVEPROMO = "update RegisterCustomer set promo='non' where username='$customer_name'";
										$SENDREMOVE = mysqli_query($connection_database,$QUERYREMOVEPROMO);

										//now deleting all items that has been stored in cart!

										$DeleteCart = "delete from Cart";
										$DeletehRun = mysqli_query($connection_database,$DeleteCart);


									}
								}

							}else{
									echo "Sorry, You entered invalid promo code.";
								}


						}





				}




		}

		 function SignUp()
		{
      //defining it here.

      if(isset($_POST['submit'])){
        //storing the data in variables;


        $RC_name = $_POST['username'];
        $RC_password = $_POST['password'];
        $RC_contact = $_POST['phone'];
        $RC_address = $_POST['address'];
        $RC_email = $_POST['email'];


        //$reg_user = new register_user($username,$password,$phone,$address,$email);


        //now storing the data into SQLiteDatabase..

        $connection_database = mysqli_connect('localhost','root','','RAMStore');
        //checking if database is connected or not..admin

        /*if($connection_database){
          echo "Successfully connected!"; //database conneteced!
        }else{
          echo "Error in connecting the database.";
        }*/

        $query = "insert into RegisterCustomer(username,password,address,email,promo,phonenumber) values('$RC_name','$RC_password','$RC_address','$RC_email','non','$RC_contact')";

        $Check_query = mysqli_query($connection_database,$query);
        if($Check_query){
          echo "Success query!";
        }else{
          echo "Change Your USERNAME.";
        }




      }

		}
		function Login($clear_username)
		{

			$_SESSION['flagLogin'] = 1;
			$_SESSION['Customer_Name'] = $clear_username;
			header("Location: welcome.php");

		}


		function R_giveFeedback($id)
		{


					$connection_database = mysqli_connect('localhost','root','','RAMStore');
					$query = "select * from product where pid='$id'";
					$sent_query = mysqli_query($connection_database,$query);
					while($fetch = mysqli_fetch_assoc($sent_query)){
								$image = $fetch['image'];
								$name = $fetch['pname'];
								$desc = $fetch['pdes'];
								$stock = $fetch['pstock'];
								$price = $fetch['price'];

									echo "<img src = Images/'$image' width = 300px>";
									echo "<br><h3><b>Product: </b>$name</h2>";
									echo "<br><h5><b>Price: $price</b></h5>";
									if($stock > 0){
										echo "<br><h5><b>Available Stock: $stock </b></h5>";
									}else{
										echo "<br><h5><b>Product is unavailable.</b></h5>";
									}
									echo "<br><h4><b>Product Description: </b>$desc</h4>";

		}
							echo "
								<form action='product.php?product_id=$id' method='post'>
									<input type='text' placeholder='your name' name='comment_name'>
									<input type='text' placeholder='your comment' name='comment'>
									<input type='submit' value='comment' name='send'>
								</form>
							";



			}


}


	class GuestCustomer
	{
	   var $GC_name, $GC_address, $GC_city, $GC_contact, $GC_email, $GC_total_purchase;

		public function G_SearchItem()
		{
			$query = "select * from product where pname like '%$searching_product%'";
			$connection_database = mysqli_connect('localhost','root','','RAMStore');
			$submit_query = mysqli_query($connection_database,$query);
			$dynamic_table="<table><tr>";
			while($fetch_data = mysqli_fetch_assoc($submit_query))
			{
					$p_name = $fetch_data['pname'];
					$price = $fetch_data['price'];
					$image = $fetch_data['image'];
					$p_id = $fetch_data['pid'];

					if($counter < 4){
					$dynamic_table.="
					<td>
					<form action='welcome.php' method='post'>
					<div class='card f1' style='width: 300px'>
					<img class='card-img-top' src=Images/'$image' style='width: 100%'>
					<div class='card-body'>
							<a href='product.php?product_id=$p_id'>$p_name</a>
							<h5>Price: $price</h5>
								<input type='number' name='quantity' value='1'>
									<input type='submit' value='Cart' name='add'>
								</form>
					</div>
					</div>
					</td>";

					$counter++;
				}else{
					$dynamic_table.="</tr><tr>";
					$counter=0;
				}

			}
			$dynamic_table.="</tr></table>";

			echo $dynamic_table;



		}

		public function G_add_to_cart()
		{

			$connection_database = mysqli_connect('localhost','root','','RAMStore');
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


		}

		public function G_giveFeedback($id)
		{
			$connection_database = mysqli_connect('localhost','root','','RAMStore');
			$query = "select * from product where pid='$id'";
			$sent_query = mysqli_query($connection_database,$query);
			while($fetch = mysqli_fetch_assoc($sent_query)){
						$image = $fetch['image'];
						$name = $fetch['pname'];
						$desc = $fetch['pdes'];
						$stock = $fetch['pstock'];
						$price = $fetch['price'];

							echo "<img src = Images/'$image' width = 300px>";
							echo "<br><h3><b>Product: </b>$name</h2>";
							echo "<br><h5><b>Price: $price</b></h5>";
							if($stock > 0){
								echo "<br><h5><b>Available Stock: $stock </b></h5>";
							}else{
								echo "<br><h5><b>Product is unavailable.</b></h5>";
							}
							echo "<br><h4><b>Product Description: </b>$desc</h4>";

}
					echo "
						<form action='product.php?product_id=$id' method='post'>
							<input type='text' placeholder='your name' name='comment_name'>
							<input type='text' placeholder='your comment' name='comment'>
							<input type='submit' value='comment' name='send'>
						</form>
					";



	}



	}





	class owner
	{
	var $user_name, $Password, $profit;

		public function ViewProfit()
		{
			$getboughtitems = 0;

			$query = "select sum(price) as total from supplier";
			$connection_database = mysqli_connect('localhost','root','','RAMStore');
			$Db = mysqli_query($connection_database,$query);

			while($data = mysqli_fetch_assoc($Db)){
				$getboughtitems = $data['total'];
			}

			$total_price_sale = 0;
			$QUERY = "select * from paymentRC";
			$send = mysqli_query($connection_database,$QUERY);
			while($data = mysqli_fetch_assoc($send)){
				$withoutPromo = $data['payment'];
				$withPromo = $data['afterDiscount'];

				if($withPromo > 0){
					$total_price_sale+=$withoutPromo;
				}else{
					$total_price_sale+=$withPromo;
				}

			}


										$total_price_RC = 0;
										$QUERY = "select * from paymentGC";
										$send = mysqli_query($connection_database,$QUERY);
										while($data = mysqli_fetch_assoc($send)){
											$price = $data['payment'];
											$total_price_sale +=$price;


										}



					$profit = $total_price_sale - $getboughtitems;
					echo "<center><h2 style='color:black'>Total sale price : $total_price_sale <b>PKR</b></h2></center>
					<br>
					<center><h3 style='color:black'>Bought item price: $getboughtitems<b>PKR</b></h2></center>
					<br>
					<center><h1 style='color:black'><b>Total Price: $profit</b><b>PKR</b></h3></center>


					";


		}

		public function manage_admin()
		{
			echo "<br>
			<br>
			<br>";

				$query = "select * from admin";
				$connection_database = mysqli_connect('localhost','root','','RAMStore');
				$send = mysqli_query($connection_database,$query);
				echo "<table border=2><tr>";
				if($data = mysqli_fetch_assoc($send)){
					$id = $data['ID'];
					$username = $data['name'];
					$pass = $data['pass'];

					echo "
					<td>$id</td>
					<td>$username</td>
					<td><a href='owner.php?delete_id=$id'>Delete</a></td>

					";



				}

				if(isset($_GET['delete_id'])){
					$delete_id = $_GET['delete_id'];
					$query = "delete from admin where id = $delete_id";
					$send = mysqli_query($connection_database,$query);
				}


		}


	}



?>
