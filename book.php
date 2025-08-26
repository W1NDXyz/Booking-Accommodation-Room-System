<?php
include('config.php');
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_GET['id'])!='')
{
	$sql_room = "SELECT * FROM room WHERE room_id = ".$_GET['id']."";
	if($result_room = $connect->query($sql_room))
	{
		$rows_room = $result_room->fetch_array();
		if(!$total_room = $result_room->num_rows)
		{
			header('Location:'.$link);
			exit();
		}
	}
	else
	{
		header('Location:'.$link);
		exit();
	}
}
else
{
	header('Location:'.$link);
	exit();
}

if(isset($_POST['submit']))
{
	$sql_book = "SELECT * FROM booking WHERE booking_date = '".$_GET['date']."' AND room_id = ".$_GET['id']."";
	if($result_book = $connect->query($sql_book))
	{
		if($total_book = $result_book->num_rows)
		{
			$_SESSION['message'] = 'date exist';
		}
		else
		{
			$sql_user = "SELECT * FROM user WHERE user_email = '$email'";
			if($result_user = $connect->query($sql_user))
			{
				$rows_user = $result_user->fetch_array();
				if($total_user = $result_user->num_rows)
				{
					$sql_book = "INSERT INTO booking (booking_date, room_id, user_id) VALUES ('".$_GET['date']."', '".$_GET['id']."', '".$rows_user['user_id']."')";
					if($result_book = $connect->query($sql_book))
					{
						$book_id = $connect->insert_id;
						
						$_SESSION['message'] = 'booking success';
						header('Location:success-page.php?id='.$book_id);
						exit();
					}
					else
					{
						$_SESSION['message'] = 'booking failed';
					}
				}
				else
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
						$mail->addAddress($email, $name);
						
						$mail->isHTML(true);
						$mail->Subject = 'New Account Registration';
						$mail->Body    = '
						<!DOCTYPE html>
						<html>
						<head>
						<meta charset="utf-8">
						</head>
						<body>
						<p>Hello '.strtoupper($name).',</p>
						<p>Your account for '.$title.' has been created with the following details:</p>
						<p><b>Email Address</b>: '.$email.'<br><b>Password</b>: '.$password.'</p>
						<p>Please access the link below for further action:<br><a href="'.$link.'/login.php">'.$link.'/login.php</a></p>
						<p>Best regards,<br>--<br>Support Team</p>
						</body>
						</html>
						';
						
						$mail->send();
						
						$password = md5($password);
						
						$sql_register = "INSERT INTO user (user_name, user_email, user_phone, user_address, user_password) VALUES ('$name', '$email', '$phone', '$address', '$password')";
						if($result_register = $connect->query($sql_register))
						{
							$user_id = $connect->insert_id;
							
							$sql_book = "INSERT INTO booking (booking_date, room_id, user_id) VALUES ('".$_GET['date']."', '".$_GET['id']."', '$user_id')";
							if($result_book = $connect->query($sql_book))
							{
								$book_id = $connect->insert_id;
								
								$_SESSION['message'] = 'booking success';
								header('Location:success-page.php?id='.$book_id);
								exit();
							}
							else
							{
								$_SESSION['message'] = 'booking failed';
							}
						}
					} catch (Exception $e) {
						$_SESSION['message'] = 'reset password failed';
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
					<h2>Booking Form</h2>
				</div>
				<div class="col-md-8 grid-margin mx-auto">
					<?php if($_SESSION['message']=='booking failed') { ?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						Booking failed. Please try again.
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
					</div>
					<?php } else if($_SESSION['message']=='date exist') { ?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						Booking date not available. Please try again.
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
					</div>
					<?php } unset($_SESSION['message']); ?>
					<div class="card">
						<div class="card-body">
							<form method="post" class="forms-sample">
								<h6 class="card-title">Booking Information</h6>
								<div class="row">
									<div class="col-sm-6">
										<div class="mb-0">
											<label class="form-label fw-bold">Room Name</label>
											<input type="text" name="name" class="form-control" value="<?php echo $rows_room['room_name'];?>" disabled>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="mb-0">
											<label class="form-label fw-bold">Booking Date</label>
											<input type="text" name="date" class="form-control" value="<?php echo date('d/m/Y', strtotime($_GET['date']));?>" disabled>
										</div>
									</div>
								</div>
								<hr/>
								<h6 class="card-title">Customer Information</h6>
								<div class="row">
									<div class="col-sm-12">
										<div class="mb-3">
											<label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
											<input type="text" name="name" class="form-control" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="mb-3">
											<label class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
											<input type="email" name="email" class="form-control" required>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="mb-3">
											<label class="form-label fw-bold">Phone Number <span class="text-danger">*</span></label>
											<input type="text" name="phone" class="form-control" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="mb-3">
											<label class="form-label fw-bold">Address <span class="text-danger">*</span></label>
											<textarea name="address" class="form-control" rows="5" required></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="mb-0 d-grid">
											<button type="submit" name="submit" class="btn btn-primary btn-icon-text">
												<i class="btn-icon-prepend" data-feather="check-circle"></i>
												Book Now
											</button>
										</div>
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