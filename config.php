<?php
session_start();

$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'booking';

$connect = new mysqli($db_host, $db_username, $db_password, $db_name);
if($connect->connect_errno)
{
	die('Connection failed : '.$connect->connect_error);
}

// Settings
$link = 'http://localhost/booking';
$title = 'Event Room Booking System';

// SMTP Settings
$smtp_debug = '';
$smtp_host = '';
$smtp_username = '';
$smtp_password = '';
$smtp_port = '';

// Variables
$_SESSION['message'] = isset($_SESSION['message']) ? $_SESSION['message'] : '';
$name = $connect->real_escape_string(isset($_POST['name']) ? $_POST['name'] : '');
$email = $connect->real_escape_string(isset($_POST['email']) ? $_POST['email'] : '');
$role = $connect->real_escape_string(isset($_POST['role']) ? $_POST['role'] : '');
$username = $connect->real_escape_string(isset($_POST['username']) ? $_POST['username'] : '');
$password = $connect->real_escape_string(isset($_POST['password']) ? $_POST['password'] : '');
$new_password = $connect->real_escape_string(isset($_POST['new_password']) ? $_POST['new_password'] : '');
$confirm_password = $connect->real_escape_string(isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '');
$image = $connect->real_escape_string(isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '');
$description = $connect->real_escape_string(isset($_POST['description']) ? $_POST['description'] : '');
$status = $connect->real_escape_string(isset($_POST['status']) ? $_POST['status'] : '');
$phone = $connect->real_escape_string(isset($_POST['phone']) ? $_POST['phone'] : '');
$address = $connect->real_escape_string(isset($_POST['address']) ? $_POST['address'] : '');
$prices = $connect->real_escape_string(isset($_POST['prices']) ? $_POST['prices'] : '');
?>