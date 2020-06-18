<?php

$conn=mysqli_connect("localhost","root","","zomato");
$order_id=$_POST['order_id'];
$delivery=$_POST['delivery'];

$query="UPDATE orders SET delivery_status='$delivery' WHERE order_id LIKE '$order_id'";
try{
	mysqli_query($conn,$query);
	$response=array('code'=>1,'message'=>'Rating submitted');
}
catch(Exception $e){
	$response=array('code'=>0,'message'=>'Some error');
}





?>