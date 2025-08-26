<?php
include('config.php');
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
<style>
body {
	text-align: center;
}
h1 {
	color: #88B04B;
	font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
	font-weight: 900;
	font-size: 40px;
	margin-bottom: 10px;
}
i {
	color: #9ABC66;
	font-size: 100px;
	line-height: 200px;
	margin-left:-15px;
}
</style>
</head>
<body>
<div class="main-wrapper">
	<?php include('navbar.php');?>
	<div class="page-wrapper">
		<div class="page-content">
			<div class="row">
				<div class="col-md-8 grid-margin mx-auto">
					<div class="card">
						<div class="card-body">
							<div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
								<i class="checkmark">✓</i>
							</div>
							<h1>Success</h1> 
							<p style="color: #404F5E; font-family: Nunito Sans, Helvetica Neue, sans-serif; font-size:20px; margin: 0;">We received your booking.<br/>We'll be in touch shortly!</p>
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