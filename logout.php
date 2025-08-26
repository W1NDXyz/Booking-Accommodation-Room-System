<?php
include('../config.php');

unset($_SESSION['admin_id']);
header('Location:'.$link.'/admin/login.php');
exit();
?>