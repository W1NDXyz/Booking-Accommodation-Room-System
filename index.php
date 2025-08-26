<?php
include('../config.php');
include('session.php');

$sql_room = "SELECT * FROM room";
if($result_room = $connect->query($sql_room))
{
	$total_room = $result_room->num_rows;
}

$sql_user = "SELECT * FROM user";
if($result_user = $connect->query($sql_user))
{
	$total_user = $result_user->num_rows;
}

$sql_booking = "SELECT * FROM booking";
if($result_booking = $connect->query($sql_booking))
{
	$total_booking = $result_booking->num_rows;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title><?php echo $title;?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $link;?>/assets/vendors/core/core.css">
<link rel="stylesheet" href="<?php echo $link;?>/assets/fonts/feather-font/css/iconfont.css">
<link rel="stylesheet" href="<?php echo $link;?>/assets/css/demo1/style.css">
<link rel="shortcut icon" href="<?php echo $link;?>/assets/images/favicon.png" />
</head>
<body>
<div class="main-wrapper">
	<?php include('sidebar.php');?>
	<div class="page-wrapper">
		<?php include('navbar.php');?>
		<div class="page-content">
			<nav class="page-breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo $link.'/admin/index.php';?>">Dashboard</a></li>
					<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
				</ol>
			</nav>
			<div class="row">
				<div class="col-12 col-xl-12 stretch-card">
					<div class="row flex-grow-1">
						<div class="col-md-4 grid-margin stretch-card">
							<div class="card text-center">
								<div class="card-body">
									<div class="mb-2">
										<h6 class="card-title mb-0">Total Rooms</h6>
									</div>
									<div class="row">
										<div class="col-12 col-md-12 col-xl-12">
											<h3><?php echo $total_room;?></h3>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4 grid-margin stretch-card">
							<div class="card text-center">
								<div class="card-body">
									<div class="mb-2">
										<h6 class="card-title mb-0">Total Users</h6>
									</div>
									<div class="row">
										<div class="col-12 col-md-12 col-xl-12">
											<h3><?php echo $total_user;?></h3>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4 grid-margin stretch-card">
							<div class="card text-center">
								<div class="card-body">
									<div class="mb-2">
										<h6 class="card-title mb-0">Total Bookings</h6>
									</div>
									<div class="row">
										<div class="col-12 col-md-12 col-xl-12">
											<h3><?php echo $total_booking;?></h3>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include('footer.php');?>
	</div>
</div>
<script src="<?php echo $link;?>/assets/vendors/core/core.js"></script>
<script src="<?php echo $link;?>/assets/vendors/feather-icons/feather.min.js"></script>
<script src="<?php echo $link;?>/assets/js/template.js"></script>
</body>
</html>