<?php
session_start();
$conn=mysqli_connect("localhost","root","","zomato");


$name=$_POST['name'];
$password=$_POST['password'];
$cuisine=$_POST['cuisine'];
$address=$_POST['address'];

$phone=$_POST['phone'];


$r_id=$_SESSION['r_id'];

$query="UPDATE restaurants SET r_name='$name',r_password='$password',r_cuisine='$cuisine',r_address='$address',r_phn='$phone' WHERE r_id='$r_id'";
try{
	mysqli_query($conn,$query);
	$_SESSION['r_name']=$name;
	header('Location:admin_profile.php?msg=1');
}
catch(Exception $e){
	header('Location:admin_profile.php?msg=0');
}



?>