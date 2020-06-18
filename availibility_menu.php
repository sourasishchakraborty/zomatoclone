<?php


session_start();
$conn=mysqli_connect("localhost","root","","zomato");
$r_id=$_SESSION['r_id'];
$query1="SELECT * FROM menu WHERE r_id LIKE '$r_id'";
	$result1=mysqli_query($conn,$query1);
	$result1=mysqli_fetch_array($result1);
	$menu_id=$result1['id'];

	//$_SESSION['menu_id']=$menu_id;
?>