<?php
/**
 * User Authentication Handler
 * * Processes login requests by verifying credentials against the Users class.
 * Redirects to the dashboard on success or back to the login page on failure.
 *
 * @uses Users
 * @param string $_POST['username'] The unique identifier for the user.
 * @param string $_POST['password'] The raw password string for verification.
 * @return void Performs header redirection based on authentication result.
 */

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