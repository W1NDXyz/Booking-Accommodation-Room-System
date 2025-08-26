<?php
include('../config.php');
include('session.php');

if(isset($_POST['submit']))
{
	$password = md5($password);
	
	$sql_change_password = "SELECT * FROM admin WHERE admin_password = '$password' AND admin_id = '".$_SESSION['admin_id']."'";
	if($result_change_password = $connect->query($sql_change_password))
	{
		if($total_change_password = $result_change_password->num_rows)
		{
			if($confirm_password==$new_password)
			{
				$new_password = md5($new_password);
				
				$sql_change_password = "UPDATE admin SET admin_password = '$new_password' WHERE admin_id = '".$_SESSION['admin_id']."'";
				if($result_change_password = $connect->query($sql_change_password))
				{
					$_SESSION['message'] = 'change password success';
					header('Location:'.$link.'/admin/change-password.php');
					exit();
				}
				else
				{
					$_SESSION['message'] = 'change password failed';
				}
			}
			else
			{
				$_SESSION['message'] = 'confirm password not match';
			}
		}
		else
		{
			$_SESSION['message'] = 'current password not match';
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
					<li class="breadcrumb-item active" aria-current="page">Change Password</li>
				</ol>
			</nav>
			<?php if($_SESSION['message']=='change password success') { ?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				Password information successfully updated.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
			</div>
			<?php } else if($_SESSION['message']=='change password failed') { ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				Password information failed to update. Please try again.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
			</div>
			<?php } else if($_SESSION['message']=='current password not match') { ?>
			<div class="alert alert-warning alert-dismissible fade show" role="alert">
				Current password not match. Please try again.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
			</div>
			<?php } else if($_SESSION['message']=='confirm password not match') { ?>
			<div class="alert alert-warning alert-dismissible fade show" role="alert">
				Confirm password not match. Please try again.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
			</div>
			<?php } unset($_SESSION['message']); ?>
			<div class="row">
				<div class="col-md-12 grid-margin stretch-card">
					<div class="card">
						<div class="card-body">
							<h6 class="card-title">Password Information</h6>
							<form method="post" class="forms-sample">
								<div class="row mb-3">
									<label class="col-sm-2 col-form-label fw-bold text-md-end">Current Password <span class="text-danger">*</span></label>
									<div class="col-sm-10">
										<input type="password" name="password" class="form-control" required>
									</div>
								</div>
								<div class="row mb-3">
									<label class="col-sm-2 col-form-label fw-bold text-md-end">New Password <span class="text-danger">*</span></label>
									<div class="col-sm-10">
										<input type="password" name="new_password" class="form-control" required>
									</div>
								</div>
								<div class="row mb-3">
									<label class="col-sm-2 col-form-label fw-bold text-md-end">Confirm Password <span class="text-danger">*</span></label>
									<div class="col-sm-10">
										<input type="password" name="confirm_password" class="form-control" required>
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