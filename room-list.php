<?php
include('../config.php');
include('session.php');

$sql_room = "SELECT * FROM room ORDER BY room_id ASC";
if($result_room = $connect->query($sql_room))
{
	$data_room = array();
	while($rows_room = $result_room->fetch_assoc())
	{
		$data_room[] = $rows_room;
	}
	$total_room = $result_room->num_rows;
	$num_room = 0;
}

if(isset($_POST['delete']))
{
	$sql_delete_room = "DELETE FROM room WHERE room_id = '".$_POST['delete']."'";
	if($result_delete_room = $connect->query($sql_delete_room))
	{
		$_SESSION['message'] = 'delete room success';
		header('Location:'.$link.'/admin/room-list.php');
		exit();
	}
	else
	{
		$_SESSION['message'] = 'delete room failed';
	}
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
					<li class="breadcrumb-item active" aria-current="page">All Rooms</li>
				</ol>
			</nav>
			<?php if($_SESSION['message']=='delete room success') { ?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				Room information successfully deleted.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
			</div>
			<?php } else if($_SESSION['message']=='delete room failed') { ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				Room information failed to delete. Please try again.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
			</div>
			<?php } unset($_SESSION['message']); ?>
			<div class="row">
				<div class="col-md-12 grid-margin stretch-card">
					<div class="card">
						<div class="card-body">
							<h6 class="card-title">Room Information</h6>
							<form method="post" class="forms-sample">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th>#</th>
												<th>Image</th>
												<th>Room Name</th>
												<th>Room Prices</th>
												<th>Gallery</th>
												<th>Status</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody>
											<?php if($total_room>0) { foreach($data_room as $rows_room) { ?>
											<?php
											$sql_gallery = "SELECT * FROM gallery WHERE room_id = '".$rows_room['room_id']."'";
											if($result_gallery = $connect->query($sql_gallery))
											{
												$rows_gallery = $result_gallery->fetch_array();
												$total_gallery = $result_gallery->num_rows;
											}
											
											if($rows_room['room_status']=='Active')
											{
												$badge_status = 'bg-success';
											}
											else if($rows_room['room_status']=='Inactive')
											{
												$badge_status = 'bg-danger';
											}
											?>
											<tr>
												<td><?php echo ++$num_room;?></td>
												<td><img src="<?php echo $link.'/uploads/room/'.$rows_room['room_image'];?>"></td>
												<td><?php echo $rows_room['room_name'];?></td>
												<td><?php echo $rows_room['room_prices'];?></td>
												<td><a href="<?php echo $link.'/admin/room-gallery.php?id='.$rows_room['room_id'];?>"><?php echo $total_gallery.' images';?></a></td>
												<td><span class="badge <?php echo $badge_status;?>"><?php echo $rows_room['room_status'];?></span></td>
												<td>
													<a href="<?php echo $link.'/admin/room-gallery.php?id='.$rows_room['room_id'];?>" class="btn btn-secondary btn-icon btn-xs btn-action"><i data-feather="image"></i></a>
													<a href="<?php echo $link.'/admin/edit-room.php?id='.$rows_room['room_id'];?>" class="btn btn-warning btn-icon btn-xs btn-action"><i data-feather="edit"></i></a>
													<button type="submit" name="delete" value="<?php echo $rows_room['room_id'];?>" class="btn btn-danger btn-icon btn-xs btn-action" onclick="return confirm('Are you sure to delete?');"><i data-feather="trash"></i></button>
												</td>
											</tr>
											<?php } } else { ?>
											<tr>
												<td colspan="6" class="text-center text-danger">No record!</td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</form>
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