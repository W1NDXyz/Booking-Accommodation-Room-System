<?php
include('../config.php');
include('session.php');

if(isset($_GET['id'])!='')
{
	$sql_room = "SELECT * FROM room WHERE room_id = ".$_GET['id']."";
	if($result_room = $connect->query($sql_room))
	{
		$rows_room = $result_room->fetch_array();
		if(!$total_room = $result_room->num_rows)
		{
			header('Location:'.$link.'/admin/room-list.php');
			exit();
		}
	}
	else
	{
		header('Location:'.$link.'/admin/room-list.php');
		exit();
	}
}
else
{
	header('Location:'.$link.'/admin/room-list.php');
	exit();
}

if(isset($_POST['submit']))
{
	$sql_edit_room = "UPDATE room SET room_name = '$name', room_prices = '$prices', room_description = '$description', room_status = '$status' WHERE room_id = '".$_GET['id']."'";
	if($result_edit_room = $connect->query($sql_edit_room))
	{
		if($image!='')
		{
			$image_ext = substr($image, strripos($image, '.'));
			$new_image = 'room-'.$_GET['id'].$image_ext;
			
			$sql_edit_room = "UPDATE room SET room_image = '$new_image' WHERE room_id = '".$_GET['id']."'";
			if($result_edit_room = $connect->query($sql_edit_room))
			{
				move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/room/'.$new_image);
			}
		}
		
		$_SESSION['message'] = 'edit room success';
		header('Location:'.$link.'/admin/edit-room.php?id='.$_GET['id']);
		exit();
	}
	else
	{
		$_SESSION['message'] = 'edit room failed';
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
<link rel="stylesheet" href="<?php echo $link;?>/assets/vendors/dropify/dist/dropify.min.css">
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
					<li class="breadcrumb-item"><a href="<?php echo $link.'/admin/room-list.php';?>">All Rooms</a></li>
					<li class="breadcrumb-item active" aria-current="page">Edit Room</li>
				</ol>
			</nav>
			<?php if($_SESSION['message']=='edit room success') { ?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				Room information successfully updated.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
			</div>
			<?php } else if($_SESSION['message']=='edit room failed') { ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				Room information failed to update. Please try again.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
			</div>
			<?php } unset($_SESSION['message']); ?>
			<form method="post" class="forms-sample" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-8 grid-margin">
						<div class="card">
							<div class="card-body">
								<h6 class="card-title">Room Information</h6>
								<div class="row">
									<div class="col-sm-12">
										<div class="mb-3">
											<label class="form-label fw-bold">Room Name <span class="text-danger">*</span></label>
											<input type="text" name="name" class="form-control" value="<?php echo $rows_room['room_name'];?>" required>
										</div>
										<div class="mb-3">
											<label class="form-label fw-bold">Room Price <span class="text-danger">*</span></label>
											<input type="text" name="prices" class="form-control" value="<?php echo $rows_room['room_prices'];?>" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="mb-0">
											<label class="form-label fw-bold">Room Details <span class="text-danger">*</span></label>
											<textarea name="description" class="form-control" rows="10" required><?php echo $rows_room['room_description'];?></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card grid-margin">
							<div class="card-body">
								<h6 class="card-title">Actions</h6>
								<div class="row">
									<div class="col-sm-12">
										<div class="mb-3">
											<label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
											<select name="status" class="form-select" required>
												<option value="">-- Select Status --</option>
												<option value="Active" <?php if($rows_room['room_status']=='Active') { ?>selected<?php } ?>>Active</option>
												<option value="Inactive" <?php if($rows_room['room_status']=='Inactive') { ?>selected<?php } ?>>Inactive</option>
											</select>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="mb-0 d-grid">
											<button type="submit" name="submit" class="btn btn-primary btn-icon-text">
												<i class="btn-icon-prepend" data-feather="check-circle"></i>
												Update
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card grid-margin">
							<div class="card-body">
								<h6 class="card-title">Featured Image</h6>
								<div class="row">
									<div class="col-sm-12">
										<div class="mb-0">
											<input type="file" name="image" class="form-control myDropify" data-default-file="<?php echo $link.'/uploads/room/'.$rows_room['room_image'];?>" data-allowed-file-extensions="jpg jpeg png" accept="image/*">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
		<?php include('footer.php');?>
	</div>
</div>
<script src="<?php echo $link;?>/assets/vendors/core/core.js"></script>
<script src="<?php echo $link;?>/assets/vendors/feather-icons/feather.min.js"></script>
<script src="<?php echo $link;?>/assets/js/template.js"></script>
<script src="<?php echo $link;?>/assets/vendors/dropify/dist/dropify.min.js"></script>
<script src="<?php echo $link;?>/assets/js/dropify.js"></script>
</body>
</html>