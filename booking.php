<?php
include('config.php');

if((isset($_GET['id'])!='') && (isset($_GET['month'])!='') && (isset($_GET['year'])!=''))
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

function build_calendar($month, $year) {
	
	global $connect;
	$month = $_GET['month'];
	
    $sql_booking = "SELECT * FROM booking WHERE MONTH(booking_date) = '$month' AND YEAR(booking_date) = '$year' AND room_id = ".$_GET['id']."";
    if($result_booking = $connect->query($sql_booking))
	{
		$data_booking = array();
		while($rows_booking = $result_booking->fetch_assoc())
		{
			$data_booking[] = $rows_booking['booking_date'];
		}
	}
	
    // Create array containing abbreviations of days of week.
    $daysOfWeek = array('Sunday', 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	
	// What is the first day of the month in question?
	$firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
	
	// How many days does this month contain?
	$numberDays = date('t', $firstDayOfMonth);
	
	// Retrieve some information about the first day of the
	// month in question.
	$dateComponents = getdate($firstDayOfMonth);
	
	// What is the name of the month in question?
	$monthName = $dateComponents['month'];
	
	// What is the index value (0-6) of the first day of the
	// month in question.
	$dayOfWeek = $dateComponents['wday'];
	
	// Create the table tag opener and day headers
	$datetoday = date('Y-m-d');
	$calendar = "<div class='table-responsive'><table class='table table-bordered'>";
	$calendar .= "<center><h3>$monthName $year</h3>";
	$calendar.= "<a class='btn btn-primary btn-xs' href='?id=".$_GET['id']."&month=".date('m', mktime(0, 0, 0, $month-1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month-1, 1, $year))."'>Previous Month</a> ";
	$calendar.= "<a href='?id=".$_GET['id']."&month=".date('m', mktime(0, 0, 0, $month+1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month+1, 1, $year))."' class='btn btn-xs btn-primary'>Next Month</a></center><br>";
	$calendar .= "<tr>";
	
	// Create the calendar headers
	foreach($daysOfWeek as $day)
	{
		$calendar .= "<th  class='header text-uppercase'>$day</th>";
	} 
	
	// Create the rest of the calendar
	// Initiate the day counter, starting with the 1st.
	$currentDay = 1;
	$calendar .= "</tr><tr>";
	
	// The variable $dayOfWeek is used to
	// ensure that the calendar
	// display consists of exactly 7 columns.
	
	if($dayOfWeek > 0)
	{ 
		for($k=0;$k<$dayOfWeek;$k++)
		{
			$calendar .= "<td  class='empty'></td>"; 
		}
	}
	
	$month = str_pad($month, 2, "0", STR_PAD_LEFT);
	
	while ($currentDay <= $numberDays)
	{
		//Seventh column (Saturday) reached. Start a new row.
		if ($dayOfWeek == 7)
		{
			$dayOfWeek = 0;
			$calendar .= "</tr><tr>";
		}
		
		$currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
		$date = "$year-$month-$currentDayRel";
		$dayname = strtolower(date('l', strtotime($date)));
		$eventNum = 0;
		$today = $date==date('Y-m-d')? "today" : "";
		
		if($date<date('Y-m-d'))
		{
			$calendar.="<td class='bg-secondary'><h5>$currentDay</h5>";
		}
		else if(in_array($date, $data_booking))
		{
			$calendar.="<td class='bg-danger'><h5>$currentDay</h5>";
		}
		else
		{
			$calendar.="<td class='$today bg-success'><a href='book.php?id=".$_GET['id']."&date=$date' style='color: #000000;'><h5>$currentDay</h5></a>";
		}
		
		$calendar .="</td>";
		//Increment counters
		$currentDay++;
		$dayOfWeek++;
	}
	
	//Complete the row of the last week in month, if necessary
	if ($dayOfWeek != 7)
	{ 
		$remainingDays = 7 - $dayOfWeek;
		for($l=0;$l<$remainingDays;$l++)
		{
			$calendar .= "<td class='empty'></td>"; 
		}
	}
	
	$calendar .= "</tr>";
	$calendar .= "</table></div>";
	return $calendar;
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
				<div class="col-md-5 grid-margin">
					<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
						<ol class="carousel-indicators">
							<li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
							<?php if($total_gallery>0) { $i=1; foreach($data_gallery as $rows_gallery) { ?>
							<li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $i;?>"></li>
							<?php ++$i; } } ?>
						</ol>
						<div class="carousel-inner">
							<div class="carousel-item active">
								<img src="<?php echo $link.'/uploads/room/'.$rows_room['room_image'];?>" class="d-block w-100">
							</div>
							<?php if($total_gallery>0) { foreach($data_gallery as $rows_gallery) { ?>
							<div class="carousel-item">
								<img src="<?php echo $link.'/uploads/room/'.$rows_gallery['gallery_image'];?>" class="d-block w-100">
							</div>
							<?php } } ?>
						</div>
						<a class="carousel-control-prev" data-bs-target="#carouselExampleIndicators" role="button" data-bs-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Previous</span>
						</a>
						<a class="carousel-control-next" data-bs-target="#carouselExampleIndicators" role="button" data-bs-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Next</span>
						</a>
					</div>
				</div>
				<div class="col-md-7 grid-margin">
					<div class="card">
						<div class="card-body">
							<h3 class="text-uppercase mb-3"><?php echo $rows_room['room_name'];?></h3>
							<p class="card-text mb-3"><?php echo nl2br($rows_room['room_description']);?></p>
							<a href="#calendar" class="btn btn-primary d-block">Check Availability</a>
						</div>
					</div>
				</div>
			</div>
			<div id="calendar" class="row">
				<div class="col-md-12 grid-margin stretch-card">
					<div class="card">
						<div class="card-body">
							<?php 
							$dateComponents = getdate(); 
							$month = $dateComponents['mon']; 
							$year = $dateComponents['year']; 
							echo build_calendar($month, $year); 
							?> 
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