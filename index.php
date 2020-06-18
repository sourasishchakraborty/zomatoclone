<?php

$conn=mysqli_connect("localhost","root","","zomato");

$query="SELECT * FROM restaurants";

$result=mysqli_query($conn, $query);


?>
<!DOCTYPE html>
<html>
<head>
	<title>Order Online</title>
	 
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>

	<nav class="navbar bg-danger">
		<h4 class="navbar-brand text-light">Zomato</h4>
	</nav>

	<div class="jumbotron">
		<h1 class="display-1 text-md-center">Hungry? Order Now</h1>
		<?php
		$counter=0;
			$query2="SELECT * FROM restaurants";

			$result2=mysqli_query($conn, $query2);

			while($row2=mysqli_fetch_array($result2)){
				$counter++;
			}
			echo '<h4 class="lead text-md-center">'.$counter.' restaurants delivering now.</h4>'

		?>


	</div>

	<div class="container">
		

		<div class="row">
			<div class="col-md-1">
				<!--<div class="card mt-2">
					<div class="card-body">
						<h4>Filter</h4>
						<input type="checkbox" name="">Veg<br>
						<input type="checkbox" name="">Non-veg<br>
					</div>
				</div>-->
			</div>
			<div class="col-md-10">
				<h4>Order food online in Kolkata</h4>
				<div class="row">
					<?php

					while($row=mysqli_fetch_array($result))
					{
						echo '<div class="col-md-6">
						<div class="card mt-2">
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<div class="row">
											<div class="col-md-3">
												<img class="card-image" src="'.$row['r_logo'].'" style="height:70px; width: 100%">
											</div>
											<div class="col-md-6">
												<h4 class="text-danger">'.$row['r_name'].'</h4>
												<p>'.$row['r_cuisine'].'<br>
												</p>
											</div>
											<div class="col-md-3">
												<p style="text-align: right;">';

												if($row['r_rating']>=4.0)
												{
													echo '<span class="badge badge-success">'.$row['r_rating'].'</span>';
												}

												else if($row['r_rating']>=3 && $row['r_rating']<4){
													echo '<span class="badge badge-warning">'.$row['r_rating'].'</span>';
												}

												else{
													echo '<span class="badge badge-danger">'.$row['r_rating'].'</span>';
												}


													
													echo '<br>
													<small>'.$row['r_num_ratings'].' ratings</small>
												</p>
												
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<a href="order.php?id='. $row['r_id'] .'" class="btn btn-sm btn-danger float-right">Order Now</a>
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

</body>
</html>