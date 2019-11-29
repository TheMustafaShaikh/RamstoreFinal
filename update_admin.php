<?php

$sending_query = "select pname,pdes,pstock,price from product where pid='$value'";
$send_query = mysqli_query($connection_database,$sending_query);
while($fetch = mysqli_fetch_assoc($send_query)){

$pName=$fetch['pname'];
$pDes=$fetch['pdes'];
$pStock=$fetch['pstock'];
$Pprice=$fetch['price'];


echo "
<form action='admin.php?update_id=$value' method='post'>
<center><input type='text' name='product_name' value='$pName'></center>
<br>
<center><input type='text' name='product_des' value='$pDes'></center>
<br>
<center><input type='number' name='stock' value='$pStock'></center>
<br>
<center><input type='number' name='price' value='$Pprice'></center>
<br>
<center><input type='submit' name ='send_update'></center>
</form>
";


}


?>
