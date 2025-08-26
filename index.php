<?php
include('config.php');

$sql_room = "SELECT * FROM room WHERE room_status = 'Active' ORDER BY room_id ASC";
if($result_room = $connect->query($sql_room))
{
	$data_room = array();
	while($rows_room = $result_room->fetch_assoc())
	{
		$data_room[] = $rows_room;
	}
	$total_room = $result_room->num_rows;
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
<link rel="stylesheet" href="<?php echo $link;?>/assets/css/demo3/style.css">
<link rel="shortcut icon" href="<?php echo $link;?>/assets/images/favicon.png" />
</head>
<body>
<div class="main-wrapper">
	<?php include('navbar.php');?>
	<div class="page-wrapper">
		<div class="page-content">
			<div class="row">
				<div class="col-md-12 grid-margin text-center">
					<h2>Our Rooms</h2>
				</div>
				<?php if($total_room>0) { foreach($data_room as $rows_room) { ?>
				<div class="col-md-3 grid-margin stretch-card">
					<div class="card text-center">
						<img src="<?php echo $link.'/uploads/room/'.$rows_room['room_image'];?>" class="card-img-top">
						<div class="card-body">
							<h5 class="card-title"><?php echo $rows_room['room_name'];?></h5>
							<a href="<?php echo $link.'/booking.php?id='.$rows_room['room_id'].'&month='.date('m').'&year='.date('Y');?>" class="btn btn-primary d-block">Book Now</a>
						</div>
					</div>
				</div>
				<?php } } ?>
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