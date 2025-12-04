<?php

class Users {
	function UserCreate($username, $password, $role) {
		$create_by = $_SESSION['user_uname'];
		$create_time = date('Y-m-d H:i:s');

		// check duplicate
		$current_data = get_single_data(
			"SELECT * FROM user_master WHERE user_master_uname = '$username'"
		);

		if ($current_data == null) {
			$password = password_hash($password, PASSWORD_DEFAULT);

			run_query(
				"INSERT INTO user_master (user_master_uname, user_master_passw, user_master_role, user_master_createby, user_master_createtime) ".
				"VALUES ('$username', '$password', '$role', '$create_by', '$create_time')"
			);

			// sweetalert
			$_SESSION['alert_value'] = "show"; // put any value, if null, alert not showing
			$_SESSION['alert_title'] = "Mantap!";
			$_SESSION['alert_text'] = "Akun Berhasil Dibuat.";
			$_SESSION['alert_icon'] = "success"; // success, question, error, warning, info
			$_SESSION['alert_button_text'] = "OK";

			// header("location".BASE_URL."/dashboard/admin/user/user-page.php"); exit;
			echo "<script>document.location.href = 'user-page.php';</script>"; exit;
		} 
	}


	function UserGetAll() {
		return get_data(
			"SELECT * FROM user_master"
		);
	}


	function UserDetail($user_id) {
		return get_single_data("SELECT * FROM user_master WHERE user_master_id = '$user_id'");
	}

	function UserRoleUpdate($user_id, $user_role) {
		run_query(
			"UPDATE user_master SET user_master_role = '$user_role' ".
			"WHERE user_master_id = '$user_id'"
		);

		// sweetalert
		$_SESSION['alert_value'] = "show"; // put any value, if null, alert not showing
		$_SESSION['alert_title'] = "Mantap!";
		$_SESSION['alert_text'] = "Role Akun Berhasil Diperbarui.";
		$_SESSION['alert_icon'] = "success"; // success, question, error, warning, info
		$_SESSION['alert_button_text'] = "OK";

		// header("location".BASE_URL."/dashboard/admin/user/user-page.php"); exit;
		echo "<script>document.location.href = 'user-page.php';</script>"; exit;
	}


	function UserPasswordUpdate($user_id, $user_role, $user_password) {
		$user_password = password_hash($user_password, PASSWORD_DEFAULT);
		run_query(
			"UPDATE user_master SET user_master_role = '$user_role', user_master_passw = '$user_password' ".
			"WHERE user_master_id = '$user_id'"
		);

		// sweetalert
			$_SESSION['alert_value'] = "show"; // put any value, if null, alert not showing
			$_SESSION['alert_title'] = "Mantap!";
			$_SESSION['alert_text'] = "Data User Berhasil Diperbarui.";
			$_SESSION['alert_icon'] = "success"; // success, question, error, warning, info
			$_SESSION['alert_button_text'] = "OK";

			// header("location".BASE_URL."/dashboard/admin/user/user-page.php"); exit;
			echo "<script>document.location.href = 'user-page.php';</script>"; exit;
	}


	function UserLogin($username, $password) {
		// if user and password match on database 
		// return boolean true, else false
		$current_data = get_single_data("SELECT * FROM user_master WHERE user_master_uname = '$username'");
		
		$hashed_password = $current_data['user_master_passw'];

		if ($current_data && password_verify($password, $hashed_password)) {
			session_start();
			$_SESSION['user_uname'] = $username;
			$_SESSION['user_role'] = $current_data['user_master_role'];
			$_SESSION['user_login_status'] = true;
			$_SESSION['user_id'] = $current_data['user_master_id'];
			return true;
		} else {
			return false;
		}
	}


	function UserLogout() {
		session_start();

		// destroy current session
		session_destroy();

		// then, redirect to login page
		header("location:../login.php?status=logout");
	}
}
?>