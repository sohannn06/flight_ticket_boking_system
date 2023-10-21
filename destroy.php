<?php
include 'connection.php';

$admin_id = $_SESSION['admin_name'];
$user_id = $_SESSION['user_name'];

session_destroy();
header('location:login.php');

?>