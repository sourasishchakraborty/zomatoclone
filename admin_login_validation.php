<?php
session_start();
//1. connect to DB

$conn=mysqli_connect("localhost","root","","zomato");
//2. Fetch data from HTML
$email=$_POST['email'];
$password=$_POST['password'];
//3. Check in database
$query="SELECT * FROM restaurants WHERE r_mail LIKE '$email' AND r_password LIKE '$password'";
$result=mysqli_query($conn,$query);

//$new_result=mysqli_fetch_array($result);
//print_r($new_result);

$rows=mysqli_num_rows($result);

//echo $rows;

//4. Tell result

if($rows==1){

	$_SESSION['is_admin_loggedin']=1;

	//echo "Welcome";

	$query1="SELECT * FROM restaurants WHERE r_mail LIKE '$email'";
	$result1=mysqli_query($conn,$query1);
	$result1=mysqli_fetch_array($result1);
	$_SESSION['r_id']=$result1['r_id'];
	$_SESSION['r_name']=$result1['r_name'];
	header('Location: admin_profile.php');
	//echo $_SESSION['r_id'];
	//echo $_SESSION['r_name'];

}else{
	//echo "Incorrect email/password";
	header('Location: admin_login.php');
}

?>