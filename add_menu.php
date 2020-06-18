<?php

session_start();
$conn=mysqli_connect("localhost","root","","zomato");
$name=$_POST['name'];
$price=$_POST['price'];
$desc=$_POST['desc'];
$address=$_POST['address'];

$availability=$_POST['availability'];
$type=$_POST['type1'];


$r_id=$_SESSION['r_id'];

$filename=$_FILES['img_file']['name'];

$menu_img="http://localhost/zomato/images/".$filename;

$query="INSERT INTO menu (id,name,price,description,img,status,type,r_id) VALUES (NULL,'$name','$price','$desc','$menu_img','$availability','$type','$r_id')";

try{
	mysqli_query($conn,$query);
	//echo '../images/'.$filename;

	move_uploaded_file($_FILES['img_file']['tmp_name'], 'images/'.$filename);
	header('Location:admin_profile.php?msg=1');
}catch(Exception $e){
	header('Location:admin_profile.php?msg=0');
}


?>