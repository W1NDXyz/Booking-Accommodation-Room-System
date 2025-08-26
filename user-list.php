<?php
include('../config.php');
include('session.php');

$sql_user = "SELECT * FROM user ORDER BY user_id ASC";
if($result_user = $connect->query($sql_user))
{
	$data_user = array();
	while($rows_user = $result_user->fetch_assoc())
	{
		$data_user[] = $rows_user;
	}
	$total_user = $result_user->num_rows;
	$num_user = 0;
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
					<li class="breadcrumb-item active" aria-current="page">All Users</li>
				</ol>
			</nav>
			<div class="row">
				<div class="col-md-12 grid-margin stretch-card">
					<div class="card">
						<div class="card-body">
							<h6 class="card-title">User Information</h6>
							<form method="post" class="forms-sample">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th>#</th>
												<th>Name</th>
												<th>Email</th>
												<th>Phone</th>
												<th>Address</th>
											</tr>
										</thead>
										<tbody>
											<?php if($total_user>0) { foreach($data_user as $rows_user) { ?>
											<tr>
												<td><?php echo ++$num_user;?></td>
												<td><?php echo $rows_user['user_name'];?></td>
												<td><?php echo $rows_user['user_email'];?></td>
												<td><?php echo $rows_user['user_phone'];?></td>
												<td><?php echo $rows_user['user_address'];?></td>
											</tr>
											<?php } } else { ?>
											<tr>
												<td colspan="5" class="text-center text-danger">No record!</td>
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