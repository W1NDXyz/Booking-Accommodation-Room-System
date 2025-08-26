<?php
include('../config.php');
include('session.php');

if(isset($_POST['submit']))
{
	$sql_edit_profile = "SELECT * FROM admin WHERE admin_email = '$email' AND admin_id != '".$_SESSION['admin_id']."'";
	if($result_edit_profile = $connect->query($sql_edit_profile))
	{
		if($total_edit_profile = $result_edit_profile->num_rows)
		{
			$_SESSION['message'] = 'email exist';
		}
		else
		{
			$sql_edit_profile = "SELECT * FROM admin WHERE admin_username = '$username' AND admin_id != '".$_SESSION['admin_id']."'";
			if($result_edit_profile = $connect->query($sql_edit_profile))
			{
				if($total_edit_profile = $result_edit_profile->num_rows)
				{
					$_SESSION['message'] = 'username exist';
				}
				else
				{
					$sql_edit_profile = "UPDATE admin SET admin_name = '$name', admin_email = '$email', admin_username = '$username' WHERE admin_id = '".$_SESSION['admin_id']."'";
					if($result_edit_profile = $connect->query($sql_edit_profile))
					{
						$_SESSION['message'] = 'edit profile success';
						header('Location:'.$link.'/admin/edit-profile.php');
						exit();
					}
					else
					{
						$_SESSION['message'] = 'edit profile success';
					}
				}
			}
		}
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
					<li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
				</ol>
			</nav>
			<?php if($_SESSION['message']=='edit profile success') { ?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				User information successfully updated.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
			</div>
			<?php } else if($_SESSION['message']=='edit profile failed') { ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				User information failed to update. Please try again.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
			</div>
			<?php } else if($_SESSION['message']=='email exist') { ?>
			<div class="alert alert-warning alert-dismissible fade show" role="alert">
				Email address already exists. Please enter another email address.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
			</div>
			<?php } else if($_SESSION['message']=='username exist') { ?>
			<div class="alert alert-warning alert-dismissible fade show" role="alert">
				Username already exists. Please enter another username.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
			</div>
			<?php } unset($_SESSION['message']); ?>
			<div class="row">
				<div class="col-md-12 grid-margin stretch-card">
					<div class="card">
						<div class="card-body">
							<h6 class="card-title">User Information</h6>
							<form method="post" class="forms-sample">
								<div class="row mb-3">
									<label class="col-sm-2 col-form-label fw-bold text-md-end">Username <span class="text-danger">*</span></label>
									<div class="col-sm-10">
										<input type="text" name="username" class="form-control" value="<?php echo $rows_login['admin_username'];?>" required>
									</div>
								</div>
								<div class="row mb-3">
									<label class="col-sm-2 col-form-label fw-bold text-md-end">Full Name <span class="text-danger">*</span></label>
									<div class="col-sm-10">
										<input type="text" name="name" class="form-control" value="<?php echo $rows_login['admin_name'];?>" required>
									</div>
								</div>
								<div class="row mb-3">
									<label class="col-sm-2 col-form-label fw-bold text-md-end">Email Address <span class="text-danger">*</span></label>
									<div class="col-sm-10">
										<input type="email" name="email" class="form-control" value="<?php echo $rows_login['admin_email'];?>" required>
									</div>
								</div>
								<div class="row mb-0">
									<div class="col-sm-10 ms-auto">
										<button type="submit" name="submit" class="btn btn-primary btn-icon-text">
											<i class="btn-icon-prepend" data-feather="check-circle"></i>
											Update
										</button>
										<button type="reset" class="btn btn-danger btn-icon-text">
											<i class="btn-icon-prepend" data-feather="refresh-cw"></i>
											Reset
										</button>
									</div>
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