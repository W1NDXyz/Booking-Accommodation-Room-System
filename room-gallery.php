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

$sql_gallery = "SELECT * FROM gallery WHERE room_id = ".$_GET['id']." ORDER BY gallery_id ASC";
if($result_gallery = $connect->query($sql_gallery))
{
	$data_gallery = array();
	while($rows_gallery = $result_gallery->fetch_assoc())
	{
		$data_gallery[] = $rows_gallery;
	}
	$total_gallery = $result_gallery->num_rows;
}

if(isset($_POST['submit']))
{
	for($i=0; $i<count($_FILES['images']['name']); $i++)
	{
		if($_FILES['images']['name'][$i]!='')
		{
			$sql_add_gallery = "INSERT INTO gallery (gallery_image, room_id) VALUES ('".$_FILES['images']['name'][$i]."', '".$_GET['id']."')";
			if($result_add_gallery = $connect->query($sql_add_gallery))
			{
				move_uploaded_file($_FILES['images']['tmp_name'][$i], '../uploads/room/'.$_FILES['images']['name'][$i]);
				$_SESSION['message'] = 'add gallery success';
				header('Location:'.$link.'/admin/room-gallery.php?id='.$_GET['id']);
			}
			else
			{
				$_SESSION['message'] = 'add gallery failed';
			}
		}
	}
	exit();
}

if(isset($_POST['delete']))
{
	$sql_delete_gallery = "DELETE FROM gallery WHERE gallery_id = '".$_POST['delete']."'";
	if($result_delete_gallery = $connect->query($sql_delete_gallery))
	{
		$_SESSION['message'] = 'delete gallery success';
		header('Location:'.$link.'/admin/room-gallery.php?id='.$_GET['id']);
		exit();
	}
	else
	{
		$_SESSION['message'] = 'delete gallery failed';
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
					<li class="breadcrumb-item active" aria-current="page">Room Gallery</li>
				</ol>
			</nav>
			<?php if($_SESSION['message']=='add room success') { ?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				Room information successfully updated.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
			</div>
			<?php } else if($_SESSION['message']=='add gallery success') { ?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				Room gallery successfully updated.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
			</div>
			<?php } else if($_SESSION['message']=='add gallery failed') { ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				Room gallery failed to update. Please try again.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
			</div>
			<?php } else if($_SESSION['message']=='delete gallery success') { ?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				Room gallery successfully deleted.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
			</div>
			<?php } else if($_SESSION['message']=='delete gallery failed') { ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				Room gallery failed to delete. Please try again.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
			</div>
			<?php } unset($_SESSION['message']); ?>
			<div class="row">
				<div class="col-md-12 grid-margin stretch-card">
					<div class="card">
						<div class="card-body">
							<h6 class="card-title"><?php echo 'Room Name : '.$rows_room['room_name'];?></h6>
							<form method="post" class="forms-sample" enctype="multipart/form-data">
								<div class="row">
									<div class="col-sm-3">
										<div class="mb-3">
											<input type="file" name="images[]" class="form-control myDropify" data-allowed-file-extensions="jpg jpeg png" accept="image/*">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="mb-3">
											<input type="file" name="images[]" class="form-control myDropify" data-allowed-file-extensions="jpg jpeg png" accept="image/*">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="mb-3">
											<input type="file" name="images[]" class="form-control myDropify" data-allowed-file-extensions="jpg jpeg png" accept="image/*">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="mb-3">
											<input type="file" name="images[]" class="form-control myDropify" data-allowed-file-extensions="jpg jpeg png" accept="image/*">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="mb-0 d-grid">
											<button type="submit" name="submit" class="btn btn-primary btn-icon-text">
												<i class="btn-icon-prepend" data-feather="upload"></i>
												Uploads
											</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<?php if($total_gallery>0) { ?>
			<form method="post" class="forms-sample d-grid">
			<div class="row">
				<?php foreach($data_gallery as $rows_gallery) { ?>
				<div class="col-md-3 grid-margin stretch-card">
					<div class="card">
						<img src="<?php echo $link.'/uploads/room/'.$rows_gallery['gallery_image'];?>" class="card-img-top">
						<div class="card-body">
							<div class="d-grid">
								<button type="submit" name="delete" value="<?php echo $rows_gallery['gallery_id'];?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to delete?');">Remove Image</button>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			</form>
			<?php } ?>
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