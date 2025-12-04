<?php
require 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>login</title>
</head>
<body>
	<?php 
		if (isset($_GET['status'])) {
			if ($_GET['status'] == "fail") {
				echo "login nok";
			} elseif ($_GET['status'] == "not_login") {
				echo "please login";
			} elseif ($_GET['status'] == "logout") {
				echo "logout ok";
			}
		}
	?>
	<form method="POST" action="function/login-function.php" autocomplete="off">
		<label>username:</label>
		<input type="text" name="username">

		<label>password:</label>
		<input type="password" name="password">

		<button type="submit" value="login">log in</button>
	</form>
</body>
</html>