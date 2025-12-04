<?php
require '../config.php';
include 'db-query.php';
include_once 'class/Users.php';

$_User = new Users;
$username = $_POST['username'];
$password = $_POST['password'];
if ($_User->UserLogin($username, $password)) {
	header("location:".BASE_URL."/dashboard");
} else {
	header("location:".BASE_URL."/login.php?status=fail");
}
?>