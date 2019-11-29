<?php
  function getQuantity($pid){
    $query = "select quantity from Cart where pid='$pid'";
    $connection_database = mysqli_connect('localhost','root','','RAMStore');
    $QUERYSEND = mysqli_query($connection_database,$query);
    while($GETVALUE = mysqli_fetch_assoc($QUERYSEND)){
      $Quantity = $GETVALUE['quantity'];
      return $Quantity;
    }

  }





 ?>
