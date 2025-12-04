<?php
require '../config.php';
include 'db-query.php';
include_once 'class/Users.php';

$_User = new Users;
$_User->UserLogout();
header("location:".BASE_URL."/login.php?status=logout");
?>