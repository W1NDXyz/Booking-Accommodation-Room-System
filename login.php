<?php
include('../config.php');

if(isset($_POST['login']))
{
	$password = md5($password);
	
	$sql_login = "SELECT * FROM admin WHERE admin_username = '$username' AND admin_password = '$password'";
	if($result_login = $connect->query($sql_login))
	{
		$rows_login = $result_login->fetch_array();
		if($total_login = $result_login->num_rows)
		{
			$_SESSION['admin_id'] = $rows_login['admin_id'];
			header('Location:'.$link.'/admin/index.php');
			exit();
		}
		else
		{
			$_SESSION['message'] = 'login failed';
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
	<div class="page-wrapper full-page">
		<div class="page-content d-flex align-items-center justify-content-center">
			<div class="row w-100 mx-0 auth-page">
				<div class="col-md-8 col-xl-5 mx-auto">
					<div class="text-center mb-3">
						<img src="<?php echo $link;?>/assets/images/logo.png" class="img-fluid">
					</div>
					<div class="card">
						<div class="row">
							<div class="col-md-12">
								<div class="auth-form-wrapper px-4 py-5">
									<div class="noble-ui-logo d-block mb-4 text-center">Sign In</div>
									<?php if($_SESSION['message']=='login failed') { ?>
									<div class="alert alert-danger alert-dismissible fade show" role="alert">
										Invalid username or password. Please try again.
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
									</div>
									<?php } unset($_SESSION['message']); ?>
									<form method="post" class="forms-sample">
										<div class="mb-3">
											<label class="form-label fw-bold">Username</label>
											<input type="text" name="username" class="form-control" placeholder="Enter your username" required autofocus>
										</div>
										<div class="mb-3">
											<label class="form-label fw-bold">Password</label>
											<input type="password" name="password" class="form-control" placeholder="Enter your password" required>
										</div>
										<div class="d-grid">
											<button type="submit" name="login" class="btn btn-primary mb-2 mb-md-0">
												Sign In
											</button>
										</div>
										<a href="<?php echo $link.'/admin/reset-password.php';?>" class="d-block mt-3 text-muted text-center">Forgot your password?</a>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo $link;?>/assets/vendors/core/core.js"></script>
<script src="<?php echo $link;?>/assets/vendors/feather-icons/feather.min.js"></script>
<script src="<?php echo $link;?>/assets/js/template.js"></script>
</body>
</html>