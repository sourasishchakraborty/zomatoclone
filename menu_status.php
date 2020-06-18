<?php
$conn=mysqli_connect("localhost","root","","zomato");
$menu_id=$_POST['menu_id'];
$availability=$_POST['availability'];
$query="UPDATE menu SET status=$availability WHERE id LIKE '$menu_id'";

try{
	mysqli_query($conn,$query);
	$response=array('code'=>1,'message'=>'Status updated');
}
catch(Exception $e){
	$response=array('code'=>0,'message'=>'Some error occured');

}




?>