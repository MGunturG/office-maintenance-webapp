<?php
/**
 * handles user processing such as creating new user, updating 
 * users detail (role and password), and get all users detail 
 * from database.
 * 
 */

class Users {
	/**
	 * Creating new user
	 * 
	 * @param string	$username a new username want to create
	 * @param string 	$password a new password for the user
	 * @param string	$role user role, admin or user (regular user)
	 * * @return void 	this function only execute sql query
	 */
	function UserCreate($username, $password, $role) {
		$create_by = $_SESSION['user_uname'];
		$create_time = date('Y-m-d H:i:s');

		// check duplicate
		$current_data = get_single_data(
			"SELECT * FROM user_master WHERE user_master_uname = '$username'"
		);

		if ($current_data == null) { // if there is no duplicate, continue
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
		} 
	}


	/**
	 * Get all users on current database
	 * 
	 * * @return array 	return query as array of users from database
	 */
	function UserGetAll() {
		return get_data(
			"SELECT * FROM user_master"
		);
	}


	/**
	 * Get certain user detail of given user id
	 * 
	 * @param int 		$user_id the unique ID of the user
	 * * @return array 	return array of given user id
	 */
	function UserDetail($user_id) {
		return get_single_data("SELECT * FROM user_master WHERE user_master_id = '$user_id'");
	}


	/**
	 * Updates the role of a specific user and sets session alerts for the UI.
	 *
	 * @param int 		 $user_id   the unique ID of the user to update.
	 * @param string     $user_role the new role designation (e.g., 'admin', 'user').
	 * * @return void
	 */
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
	}


	/**
	 * Hashes the new password and updates user credentials in the database.
	 * * This function handles both the role update and the password re-hashing
	 * before triggering a SweetAlert success notification via the session.
	 *
	 * @param int 		 $user_id       The unique identifier for the user.
	 * @param string     $user_role     The administrative or access role level.
	 * @param string     $user_password The plain-text password to be hashed.
	 * * @return void
	 */
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
	}


	/**
	 * Verifies user credentials and initializes a session upon success.
	 *
	 * @param string 	$username The unique username entered by the user.
	 * @param string 	$password The plain-text password to verify against the hash.
	 * * @return bool 	Returns true if credentials match and session is set, false otherwise.
	 */
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


	/**
	 * Terminates the user session and redirects to the login page.
	 * * Clears all session data and appends a logout status to the 
	 * URL for UI notification purposes.
	 *
	 * @return void
	 */
	function UserLogout() {
		session_start();

		// destroy current session
		session_destroy();

		// then, redirect to login page
		header("location:../login.php?status=logout");
	}
}
?>