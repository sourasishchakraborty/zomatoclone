<?php

session_start();

$conn=mysqli_connect("localhost","root","","zomato");

print_r($_FILES['img_file']);

$filename=$_FILES['img_file']['name'];

$dp="http://localhost/zomato/images/".$filename;

$r_id=$_SESSION['r_id'];

$query="UPDATE restaurants SET r_logo='$dp' WHERE r_id=$r_id";

try{
	mysqli_query($conn,$query);
	//echo '../images/'.$filename;
	move_uploaded_file($_FILES['img_file']['tmp_name'], 'images/'.$filename);
	header('Location:admin_profile.php');
}catch(Exception $e){
	echo "Error occured";
}


?>