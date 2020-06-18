<?php

$conn=mysqli_connect("localhost","root","","zomato");

session_start();

$name=$_POST['name'];
$email=$_POST['email'];
$filename=$_FILES['img_file']['name'];

$dp="http://localhost/zomato/images/".$filename;

$cuisine=$_POST['cuisine'];
$password=$_POST['password'];

$query="INSERT INTO restaurants(r_id,r_name,r_mail,r_logo,r_cuisine,r_password) VALUES (NULL,'$name','$email','$dp','$cuisine','$password') ";

try{
	//check user already exist or not, run a query to detect if the given EmailId already exist or not
	mysqli_query($conn,$query);
	move_uploaded_file($_FILES['img_file']['tmp_name'], 'images/'.$filename);
	header('Location:admin_login.php?message=1');
}
catch(Exception $e){
	//echo "ERROR occured! Try again";
	header('Location:admin_login.php?message=0');
}

?>