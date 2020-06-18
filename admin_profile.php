<?php
error_reporting(0);
session_start();
$conn=mysqli_connect("localhost","root","","zomato");
if(empty($_SESSION['is_admin_loggedin']))
{
	header('Location: admin_login.php');
}

$r_id=$_SESSION['r_id'];
$query="SELECT * FROM restaurants WHERE r_id='$r_id'";

$result=mysqli_query($conn,$query);
$result=mysqli_fetch_array($result);
$r_logo=$result['r_logo'];


$r_name=$_SESSION['r_name'];
$query4="SELECT * FROM orders WHERE r_id='$r_id' AND status=1";

$result4=mysqli_query($conn,$query4);
$pending=0;
$amount=0;
$delivered=0;
$total=0;
$counter=0;
while($row=mysqli_fetch_array($result4))
{
	
	$amount=$amount + $row['amount'];
	
	if($row['delivery_status']==0)
		{
			$pending++;
		}else{
			$total=$total+ $row['rating'];
			$counter++;
			$delivered++;
		}
}
$rating=$total/$counter;

$query3="UPDATE restaurants SET r_rating=$rating,r_num_ratings=$counter WHERE r_id='$r_id'";
try{
	mysqli_query($conn,$query3);
	$response=array('code'=>1,'message'=>'Rating submitted');

}
catch(Exception $e){
	$response=array('code'=>0,'message'=>'Some error');

}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Hi Admin</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style type="text/css">
	.card{
		max-height: 150px;
	}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		$('#edit_admin_dp').hide();
		$('#profile').mouseenter(function(){
			$('#edit_admin_dp').show();
		})
		$('#profile').mouseleave(function(){
			$('#edit_admin_dp').hide();
		})

		$('.avail').click(function(){
			var menu_id=$(this).data('id');
			//alert(menu_id);
			//pass menu_id to form
			$('#menu_id').val(menu_id);


		});
		$('#avail-form').submit(function(){
			//alert("Form submitted");
			var menu_id=$('#menu_id').val();
			var availability=$("input[name=availability]:checked").val();

			$.ajax({
				url:'menu_status.php',
				type: 'POST',
				data:{'menu_id':menu_id,'availability':availability},
				success:function(data){

				},
				error:function(){
					alert("Some error occured");
				}
			})
		})

		$('.order_id').click(function(){
			var order_id=$(this).text();
			//alert(order_id);
			//ajax call into order_details
			$.ajax({
				url:'fetch_order_details.php',
				type: 'POST',
				data:{'order_id':order_id},
				success:function(data){
					data=JSON.parse(data);
					$('#display_menu').html('');
					$('#display_menu').append('<table class="table"><tr><th>S. No</th><th>Name</th><th class="float-right"> Quantity</th></tr>')
					$counter3=1;

					$.each(data, function(i,item){

						$('#display_menu').append('<table class="table"><tr><td>'+ $counter3 +'</td><td>'+ item +'</td><td class="float-right">1</td></tr></table>')
						$counter3++;
					})

					$('#display_menu').append('</table>')
				},
				error:function(){

				}
			})
			$('#orderModal').modal('show');
		})

		$('.delivery').click(function(){
			var order_id=$(this).data('id');
			//alert(order_id);
			//pass order_id to form

			$('#order_id').val(order_id);
		});
		$('#delivery-form').submit(function(){
			//alert("Form Submitted");

			var order_id=$('#order_id').val();
			var delivery=$("input[name=delivery]:checked").val();
			$.ajax({
				url:'delivery_status.php',
				type:'POST',
				data:{'order_id':order_id,'delivery':delivery},
				success:function(data){

				},
				error:function(){
					alert("Some error occured");
				}
			})
		})


		/*$('#edit-admin-profile').submit(function(){
			//alert("Address updated");


			var name=$('#name').val();

			var password=$('#password').val();

			var cuisine=$('#cuisine').val();
			var address=$('#address').val();
			var email=$('#email').val();
			var phone=$('#phone').val();
			console.log(data);

			$('#editModal').modal('hide');

			$.ajax({
				

				url:'admin_edit_profile.php',
				type:'POST',
				data:{'name':name,'password':password,'cuisine':cuisine,'address':address,'email':email,'phone':phone},
				success:function(data){
					//alert(data);
					data=JSON.parse(data);

					if(data.code==1){
						alert("Profile updated successfully");
					}else{
						alert("Some error occured!Try again.");
					}
				},
				error:function(){
					alert("some error occured");
				}
			})
		})*/








	})
</script>


<body>
	<nav class="navbar bg-danger">
					<h4 class="navbar-brand text-light">Zomato Admin</h4>
					<h5 class="float-right text-light">Hi <?php echo $_SESSION['r_name']; ?></h5>
			</nav>
	<div class="container">
		<div class="row mt-3">
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-4">
						<div class="card" id="profile" style="width: 35rem; max-height: 318px; min-height: 318px;">
						  <img class="card-img-top ml-3 mt-3" src="<?php echo $r_logo; ?>" alt="Card image cap" style="height: 170px;width:170px;">
						   <a href="#" data-toggle="modal" data-target="#dpModal"><i id="edit_admin_dp" class="fa fa-edit fa-2x text-dark" style="margin-top: -80px;padding-left: 20px"></i></a>
						  <div class="card-body">
						  	<a href="" class="btn btn-large float-left text-light bg-danger" style="width: 170px;" data-toggle="modal" data-target="#editModal">Update Profile</a>
						  </div>
						</div>
					</div>
					<div class="col-md-8">
						<div class="card" style="border:none;">
							<div class="card-body">
								<h3><?php echo $result['r_name']; ?></h3>
								<p><b><?php echo $result['r_cuisine']; ?></b></p>
								<p><?php echo $result['r_address']; ?></p>
								<p>Email: <a href="mailto:<?php echo $result['r_mail']; ?>"><?php echo $result['r_mail']; ?></a></p>
								<p>Phone no: <span><?php echo $result['r_phn']; ?></span></p>
								<a href="admin_logout.php" class="text-danger float-right"><b>Log Out</b></a>

							</div>
						</div>
					</div>
				</div>
				
				
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-6">
						<div class="card bg-success text-white">
							<div class="card-body">
								<h3>Amount</h3><br><br>
								<h4 class="float-right">Rs <span><?php echo $amount; ?></span></h4>
							</div>
						</div>
						
					</div>
					<div class="col-md-6">
						<div class="card bg-warning text-white">
							<div class="card-body">
								<h3>Pending Orders</h3><br><br>
								<h4 class="float-right"><span> <?php echo $pending; ?></span></h4>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="card bg-primary text-white mt-3">
							<div class="card-body">
								<h3>Delivered</h3><br><br>
								<h4 class="float-right"><span><?php echo $delivered; ?></span></h4>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="card bg-danger text-white mt-3">
							<div class="card-body">
								<h3>Rating</h3><br><br>
								<h4 class="float-right"><span><?php echo $rating; ?></span></h4>
							</div>
						</div>
					</div>


				</div>
				
				
			</div>
		</div>

		<div class="row mt-3">
					<div class="col-md-6">
						<div class="card" style="max-height: 500px; width:34rem;  overflow-y: auto;">
							<div class="card-body">
								<h2>Menu<button class="float-right btn btn-danger btn-sm" data-toggle="modal" data-target="#menuModal">Add Menu</button></h2>
								
								<table class="table">
									<tr>
										<th>S No</th>
										<th>Name</th>
										<th>Current Status</th>
										<th>Availability</th>

									</tr>

									<?php
									$r_id=$_SESSION['r_id'];
									$query1="SELECT * FROM menu WHERE r_id='$r_id'";
									$result1=mysqli_query($conn,$query1);
									$counter1=1;
									while($row1=mysqli_fetch_array($result1))
									{
										if($row1['status']==1)
										{
											echo '<tr>
										<td>'.$counter1.'</td>
										<td>'.$row1['name'].'</td>
										<td>
											
										  <input type="checkbox" checked>
										  
											
										</td>
										<td><button class="btn btn-danger btn-sm float-right avail" data-toggle="modal" data-target="#exampleModal" data-id="'.$row1['id'].'">Change</button></td>
									</tr>';
										}
										else{
											echo '<tr class="text-muted">
										<td>'.$counter1.'</td>
										<td>'.$row1['name'].'</td>
										<td>
											
										  <input type="checkbox">
										  
											
										</td>
										<td><button class="btn btn-danger btn-sm float-right avail" data-toggle="modal" data-target="#exampleModal" data-id="'.$row1['id'].'">Change</button></td>
									</tr>';
										}
										
									$counter1++;
									}


									?>
									
								</table>
								
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="card" style="max-height: 500px; width:34rem;  overflow-y: auto;">
							<div class="card-body">
								<h2>Recent Orders</h2>
								<table class="table">
									<tr>
										<th>S No:</th>
										<th>Order ID</th>
										<th>Customer</th>
										<th>Amount</th>
										<th>Delivery Status</th>
									</tr>

									<?php
									$query2="SELECT * FROM orders o JOIN users u ON u.user_id=o.user_id WHERE r_id='$r_id' AND delivery_status=0 AND status=1";

									$result2=mysqli_query($conn,$query2);
									$counter2=1;
									while($row2=mysqli_fetch_array($result2))
									{
										echo '<tr>
										<td>'.$counter2.'</td>
										<td class="order_id"><a href="#">'.$row2['order_id'].'</a></td>
										<td>'. $row2['name'] .'</td>
										<td>Rs '.$row2['amount'].'</td>
										<td><button type="button" class="btn btn-danger btn-sm delivery"data-toggle="modal" data-target="#deliveryModal"   data-id="'.$row2['order_id'].'">Update</button><td>
									</tr>';
									$counter2++;
									}


									?>


									
								</table>
							</div>
						</div>
					</div>
				</div>



	</div>	
	<div class="modal fade" id="dpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Choose Restaurant Logo</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form action="update_admin_dp.php" method="POST" enctype="multipart/form-data">
	        	<label>Choose Restaurant Logo</label><br>
	        	<input type="file" name="img_file" class="form-control"><br>

	        	<input type="submit" name="" value="Submit" class="btn btn-danger">
	        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        </form>
	      </div>
	    </div>
	  </div>
	</div>
	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Edit Restaurant Profile</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form action="admin_edit_profile.php" method="POST">
	        	<label>Name:</label><br>
	        	<input type="text" name="name" class="form-control" value="<?php echo $_SESSION['r_name']; ?>" required><br>
	        	<label>Password:</label><br>
	        	<input type="password" name="password" class="form-control" required><br>
	        	<label>Cuisine:</label><br>
	        	<input type="text" name="cuisine" class="form-control" required><br>
	        	<label>Address:</label><br>
	        	<input type="text" name="address" class="form-control" required><br> 
	        	<label>Contact No:</label><br>
	        	<input type="number" name="phone" class="form-control" required><br>

	        	<input type="submit" name="" value="Submit" class="btn btn-danger">
	        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        </form>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="modal fade" id="menuModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Add a new item</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form action="add_menu.php" method="POST" enctype="multipart/form-data">
	        	<label>Item Name: </label><br>
	        	<input type="text" name="name" class="form-control"><br>

	        	<label>Price: </label><br>
	        	<input type="number" name="price" class="form-control"><br>

	        	<label>Description: </label><br>
	        	<input type="text" name="desc" class="form-control"><br>



	        	<label>Choose image: </label><br>
	        	<input type="file" name="img_file" class="form-control"><br>

	        	<label>Current Status: </label><br>

				  
				  <input type="radio" id="available" name="availability" value="1">
				  <label for="available"> Available</label><br>
				  
				  <input type="radio" id="notavailable" name="availability" value="0">
				  <label for="notavailable">Not available</label><br>
				<label>Type:</label><br>  
					<input type="radio" id="veg" name="type1" value="1">
				  <label for="veg"> Veg</label><br>
				  
				  <input type="radio" id="nonveg" name="type1" value="0">
				  <label for="nonveg">Non Veg</label><br>
				  

	        	<input type="submit" name="" value="Submit" class="btn btn-danger">
	        </form>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Availability Status</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	               
	      	<form id="avail-form">
	      		 <label>Current Status: </label><br>
				  <input type="radio" id="available" name="availability" value="1">
				  <label for="available"> Available</label><br>
				  
				  <input type="radio" id="notavailable" name="availability" value="0">
				  <label for="notavailable">Not available</label><br>

				  <input type="hidden" name="menu_id" id="menu_id">
				  <input type="submit" name="" value="submit" class="btn btn-danger">
	      	</form>
	             
	      </div>
	      
	    </div>
	  </div>
	</div>

	<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Order Details: </h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        
	        	<div id="display_menu"></div>
	        	
	        
	      </div>
	    </div>
	  </div>
	</div>


		<div class="modal fade" id="deliveryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Delivery Status</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	               
	      	<form id="delivery-form">
	      		 <label>The order is already delivered.Do you want to save the changes?</label><br>
				  <input type="radio" id="Yes" name="delivery" value="1">
				  <label for="Yes">Yes</label><br>
				  
				  <input type="radio" id="no" name="delivery" value="0">
				  <label for="no">No</label><br>

				  <input type="hidden" name="order_id" id="order_id">
				  <input type="submit" name="" value="submit" class="btn btn-danger">
	      	</form>
	             
	      </div>
	      
	    </div>
	  </div>
	</div>

</body>
</html>