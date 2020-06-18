<?php

session_start();

if(empty($_SESSION['is_user_loggedin'])){
	header('Location: login_form.php');
}

$conn=mysqli_connect("localhost","root","","zomato");

$r_id=$_GET['id'];

$query="SELECT * FROM restaurants WHERE r_id=$r_id";

$result=mysqli_query($conn,$query);

$result=mysqli_fetch_array($result);

if(empty($result))
{
	header('Location: error.php');
}
else
{
	$name=$result['r_name'];
	$bg=$result['r_logo'];
	$cuisine=$result['r_cuisine'];
	$r_address=$result['r_address'];
	$r_mail=$result['r_mail'];
	$r_phn=$result['r_phn'];
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Restaurant Name</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<style type="text/css">
	body{
		background-image: url("https://morrisonhouse.com/wp-content/uploads/2018/02/pexels-photo-370984.jpeg");
		/* Full height */
  height: 50% 50%;


  /* Center and scale the image nicely */
  
  background-repeat: no-repeat;
  background-size: cover;
  /* Add the blur effect */
  background-filter: blur(8px);
  

	}
	.navbar-bg{
	background: #cb2d3e;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #ef473a, #cb2d3e);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #ef473a, #cb2d3e); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */


}
</style>
<script type="text/javascript">
	$(document).ready(function(){

		var r_id='<?php echo $r_id; ?>';
		//alert(r_id);

		var flag=0;
		var order_id=0;

		$('#order-box').hide();

		$('.menu_item').click(function(){

			

			var item_id=$(this).data('id');

				
			var item_name=$('#menu_item_name' + item_id).text();

			var item_price=$('#menu_item_price' + item_id).text();

			// make an entry in the db
			$.ajax({
				url:"add_order.php",
				type:"POST",
				data:{"r_id":r_id,"menu_id":item_id,'flag':flag,'order_id':order_id},
				success:function(data){


					if(flag==0){
						flag++;
					}

					var data=JSON.parse(data);
					//console.log(data);

					order_id=data.order_id;

					$('#order-box').show();
					
					$('#show_items').append('<p>' + item_name +'<span class="float-right">Rs' + item_price +'</span></p>');


				},
				error:function(){
					alert("Hello");
				}
			});
					})


		$('#place').click(function(){
			window.location.href="http://localhost/zomato/order_details.php?order_id=" + order_id;
		})
	})
</script>
<body>

	<nav class="navbar navbar-bg fixed-top">
		<h4 class="navbar-brand text-light">Zomato</h4>
		<h4 class="float-right text-light">Hi <?php echo $_SESSION['name'] ?></h4>
	</nav>

	<div class="container">
		<div class="row">
			<div class="col-md-12 mt-2">
				<img src="<?php echo $bg; ?>" style="width:100%;height:500px;">
			</div>
		</div>

		<div class="row mt-3">
			<div class="col-md-8">

				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-body">
								<h1><?php echo $name; ?></h1>
								<h5><?php echo $cuisine; ?></h5>
							</div>
						</div>
					</div>
				</div>

				<div class="row mt-2">
					<!--<div class="col-md-3">
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-body">
										<h4>Filter</h4>
									</div>
								</div>
							</div>
						</div>
					</div>-->
					<div class="col-md-12">
						<div class="row">
							<?php

							$query2="SELECT * FROM menu WHERE r_id=$r_id AND status=1";

							$result=mysqli_query($conn,$query2);

							while($row=mysqli_fetch_array($result))
							{
								echo '<div class="col-md-12 mt-2 ">
								<div class="card">
									<div class="card-body">
										<div class="row">';

										echo '<div class="col-md-2"><img src="'.$row['img'].'"style="width:120px;height:120px;" ></div>';

										if($row['type']==1)
										{
											echo '<div class="col-md-1" style="padding:12px"><img src="https://upload.wikimedia.org/wikipedia/hi/thumb/b/b2/Veg_symbol.svg/1200px-Veg_symbol.svg.png" class="float-right" style="height:20px;width:20px;">';

										}
										else
										{
											echo '<div class="col-md-1" style="padding:12px"><img src="https://pngimage.net/wp-content/uploads/2018/06/non-veg-logo-png-2.png" class="float-right" style="height:20px;width:20px;">';


										}

											
											echo '</div>
											<div class="col-md-7">
												<h5 id="menu_item_name'.$row['id'].'">'.$row['name'].'</h5>
												<p>Rs <span id="menu_item_price'.$row['id'].'">'.$row['price'].'</span><br>
												<small>'.$row['description'].'</small></p>
											</div>
											<div class="col-md-2">
												<button data-id='.$row['id'].' class="btn btn-danger btn-sm menu_item">Add</button>
											</div>
										</div>
									</div>
								</div>
							</div>';
							}

							?>
							
						</div>
					</div>
				</div>


			</div>
			<div class="col-md-4">
				<div class="row">

					<div class="col-md-12">
						<div id="order-box" class="card bg-danger text-light">
							<div class="card-body">
								<h5>Order Details</h5>
								<div id="show_items">
									
								</div>

								<button id="place" class="btn btn-light btn-block">Place Order</button> 
							</div>
						</div>
					</div>

					<div class="col-md-12 ">
						<div class="card">
							<div class="card-body">
								<h3>Address</h3>
								<p><?php echo $r_address; ?></p>
							</div>
						</div>
					</div>
					<div class="col-md-12 mt-3">
						<div class="card">
							<div class="card-body">
								<h3>Contact us:</h3>
								<p><b>Email:</b> <a href="mailto:<?php echo $r_mail; ?>"><?php echo $r_mail; ?></a></p>
								<p><b>Call us:</b> <?php echo $r_phn; ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>