<nav class="sidebar">
		<div class="sidebar-header">
			<a href="<?php echo $link.'/admin/index.php';?>" class="sidebar-brand">
				<img class="ht-30" src="<?php echo $link;?>/assets/images/logo.png" alt="logo">
			</a>
			<div class="sidebar-toggler not-active">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>
		<div class="sidebar-body">
			<ul class="nav">
				<li class="nav-item nav-category">Main Menu</li>
				<li class="nav-item">
					<a href="<?php echo $link.'/admin/index.php';?>" class="nav-link">
						<i class="link-icon" data-feather="home"></i>
						<span class="link-title">Dashboard</span>
					</a>
				</li>
				<li class="nav-item nav-category">Rooms</li>
				<li class="nav-item">
					<a href="<?php echo $link.'/admin/add-room.php';?>" class="nav-link">
						<i class="link-icon" data-feather="plus-circle"></i>
						<span class="link-title">Add New</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?php echo $link.'/admin/room-list.php';?>" class="nav-link">
						<i class="link-icon" data-feather="list"></i>
						<span class="link-title">All Rooms</span>
					</a>
				</li>
				<li class="nav-item nav-category">Users</li>
				<li class="nav-item">
					<a href="<?php echo $link.'/admin/user-list.php';?>" class="nav-link">
						<i class="link-icon" data-feather="users"></i>
						<span class="link-title">All Users</span>
					</a>
				</li>
				<li class="nav-item nav-category">Bookings</li>
				<li class="nav-item">
					<a href="<?php echo $link.'/admin/booking-list.php';?>" class="nav-link">
						<i class="link-icon" data-feather="calendar"></i>
						<span class="link-title">All Bookings</span>
					</a>
				</li>
			</ul>
		</div>
	</nav>
