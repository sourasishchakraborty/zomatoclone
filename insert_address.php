<?php





$conn=mysqli_connect("localhost","root","","zomato");
$address_id=$_POST['address_id'];
$work_address=$_POST['work_address'];
$home_address=$_POST['home_address'];



$query="UPDATE users SET work_address='$work_address', home_address='$home_address' WHERE user_id LIKE $address_id";

try{
	mysqli_query($conn,$query);

	$response=array('code'=>1,'message'=>'Rating submitted');
}
catch(Exception $e){
	$response=array('code'=>0,'message'=>'Some error');
}
$response=json_encode($response);
print_r($response);



?>