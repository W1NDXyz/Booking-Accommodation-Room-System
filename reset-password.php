<?php
include('../config.php');
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['reset']))
{
	$sql_reset_password = "SELECT * FROM admin WHERE admin_email = '$email'";
	if($result_reset_password = $connect->query($sql_reset_password))
	{
		$rows_reset_password = $result_reset_password->fetch_array();
		if($total_reset_password = $result_reset_password->num_rows)
		{
			$data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz!@#$%^&*()';
			$password = substr(str_shuffle($data), 0, 8);
			
			$mail = new PHPMailer(true);
			
			try {
				$mail->SMTPDebug  = $smtp_debug;
				$mail->isSMTP();
				$mail->Host       = $smtp_host;
				$mail->SMTPAuth   = true;
				$mail->Username   = $smtp_username;
				$mail->Password   = $smtp_password;
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
				$mail->Port       = $smtp_port;
				
				$mail->setFrom($smtp_username, $title);
				$mail->addAddress($rows_reset_password['admin_email'], $rows_reset_password['admin_name']);
				
				$mail->isHTML(true);
				$mail->Subject = 'Password Reset';
				$mail->Body    = '
				<!DOCTYPE html>
				<html>
				<head>
				<meta charset="utf-8">
				</head>
				<body>
				<p>Hello '.strtoupper($rows_reset_password['admin_name']).',</p>
				<p>There has been a request to reset your password for '.$title.'. The changes as below:</p>
				<p><b>Username</b>: '.$rows_reset_password['admin_username'].'<br><b>Password</b>: '.$password.'</p>
				<p>Please access the link below for further action:<br><a href="'.$link.'/admin/login.php">'.$link.'/admin/login.php</a></p>
				<p>Best regards,<br>--<br>Support Team</p>
				</body>
				</html>
				';
				
				$mail->send();
				
				$password = md5($password);
				
				$sql_reset_password = "UPDATE admin SET admin_password = '$password' WHERE admin_id = '".$rows_reset_password['admin_id']."'";
				if($result_reset_password = $connect->query($sql_reset_password))
				{
					$_SESSION['message'] = 'reset password success';
					header('Location:'.$link.'/admin/reset-password.php');
					exit();
				}
				else
				{
					$_SESSION['message'] = 'reset password failed';
				}
			} catch (Exception $e) {
				$_SESSION['message'] = 'reset password failed';
			}
		}
		else
		{
			$_SESSION['message'] = 'invalid email';
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
									<div class="noble-ui-logo d-block mb-4 text-center">Reset Password</div>
									<?php if($_SESSION['message']=='reset password success') { ?>
									<div class="alert alert-success alert-dismissible fade show" role="alert">
										Password successfully reset. Please check your email.
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
									</div>
									<?php } else if($_SESSION['message']=='reset password failed') { ?>
									<div class="alert alert-danger alert-dismissible fade show" role="alert">
										Password reset failed. Please try again.
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
									</div>
									<?php } else if($_SESSION['message']=='invalid email') { ?>
									<div class="alert alert-warning alert-dismissible fade show" role="alert">
										Invalid email address. Please try again.
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
									</div>
									<?php } unset($_SESSION['message']); ?>
									<form method="post" class="forms-sample">
										<div class="mb-3">
											<label class="form-label fw-bold">Email Address</label>
											<input type="email" name="email" class="form-control" placeholder="Enter your email address" required autofocus>
										</div>
										<div class="d-grid">
											<button type="submit" name="reset" class="btn btn-primary mb-2 mb-md-0">
												Reset Your Password
											</button>
										</div>
										<a href="<?php echo $link.'/admin/login.php';?>" class="d-block mt-3 text-muted text-center">Never mind, I remember my password.</a>
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