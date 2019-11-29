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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
	google.charts.load('current', {packages:['corechart']});
	google.charts.setOnLoadCallback(drawStuff);

		function drawStuff() {
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'price');
			data.addColumn('number', 'Price');
			data.addRows([
				<?php
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


				echo "
				['Bought Items', $getboughtitems],
				['Total Sale Price', $total_price_sale],
				['Total profit', $profit],
				";
				?>
			]);

		 var options = {
			 title: 'Total Price Chart',
			 width: 500,
			 height: 300,
			 legend: 'none',
			 bar: {groupWidth: '95%'},
			 vAxis: { gridlines: { count: 4 } }
		 };

		 var chart = new google.visualization.ColumnChart(document.getElementById('number_format_chart'));
		 chart.draw(data, options);

		 document.getElementById('format-select').onchange = function() {
			 options['vAxis']['format'] = this.value;
			 chart.draw(data, options);
		 };
	};

</script>





<body>


   <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark custom-carets">
            <a class="navbar-brand" href="">RAMSTORE</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item dropdown">
											<?php
												$owner_name = $_SESSION['ownerID'];


											  echo "<a class='nav-link dropdown-toggle op4' href='' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>$owner_name</a>
                        <div class='dropdown-menu' aria-labelledby='navbarDropdown'>

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



	<select id="format-select">
	 <option value="">none</option>
	 <option value="decimal" selected>decimal</option>
	 <option value="scientific">scientific</option>

<option value="percent">percent</option>
	 <option value="currency">currency</option>
	 <option value="short">short</option>
	 <option value="long">long</option>
 </select>
 <div id="number_format_chart">
</div>

<?php
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
		echo "<center><h2 style='color:black'>Total sale price : $total_price_sale <b>PKR</b></h2></center>";

?>

      </body>
      </html>
