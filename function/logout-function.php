<?php
/**
 * User Logout Handler
 * * Terminates the current user session and clears all authentication variables.
 * Redirects the user back to the login page with a success status.
 *
 * @uses Users
 * @return void Performs header redirection to the login page.
 */

require '../config.php';
include 'db-query.php';
include_once 'class/Users.php';

$_User = new Users;
$_User->UserLogout();
header("location:".BASE_URL."/login.php?status=logout");
?>