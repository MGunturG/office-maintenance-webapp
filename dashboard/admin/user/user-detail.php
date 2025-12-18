<?php
/**
 * A page showing user's detail such as username, password, and user role
 * also a page to change or update user password and/or role
 * 
 * only admin can change user's role 
 * 
 */

session_start();

require '../../../config.php';
include '../../../function/db-query.php';
include_once '../../../function/class/Users.php';

if (!$_SESSION['user_login_status']) {
	header("location:".BASE_URL."/login.php?status=not_login");
}

$_User = new Users;

// get detail of current user ID
if (isset($_GET['id'])) {
	$user_data = $_User->UserDetail($_GET['id']);
	$user_id = $user_data['user_master_id'];
	$user_uname = $user_data['user_master_uname'];
	$user_role = $user_data['user_master_role'];
}

// if update button pressed, either update role, password, or both 
if (isset($_POST['user_Update'])) {

	if($_POST['user_passw'] == "") { // if password is blank, just update user role
		$_User->UserRoleUpdate($user_id, $_POST['user_role']);
		echo "<script>document.location.href = 'user-page.php';</script>"; exit;

	} else { // else, update role and password
		$_User->UserPasswordUpdate($user_id, $_POST['user_role'], $_POST['user_passw']);
		echo "<script>document.location.href = 'user-page.php';</script>"; exit;
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Page - Detail User</title>

	<!-- styling -->
	<?php include("../../../layout/styling.php") ?>
</head>
<body>
	<?php include("../../../layout/body-theme.php") ?>

	<div id="app">
		<!-- sidebar -->
		<?php include("../../../layout/sidebar.php") ?>

		<div id="main" class="layout-navbar navbar-fixed">
			<!-- navbar -->
			<?php include("../../../layout/navbar.php") ?>

			<div id="main-content">
				<section id="basic-vertical-layouts">
					<div class="row match-height">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h4>Detail User</h4>
								</div>
								<div class="card-content">
									<div class="card-body">
										<form method="POST">
											<div class="form-body">
												<div class="row">
													<input type="hidden" name="user_id" value="<?= $user_id ?>">

													<div class="col-12">
														<div class="form-group">
															<label for="username-vertical">Username</label>
															<input type="text" class="form-control" name="user_uname" value="<?= $user_uname ?>" disabled>
														</div>
													</div>

													<div class="col-12">
														<div class="form-group">
															<label for="password-vertical">Password</label>
															<input type="password" class="form-control" name="user_passw">
														</div>
													</div>

													<div class="col-12" <?php echo $_SESSION['user_role'] == "user" ? "hidden":"" ?>>
														<div class="form-group">
															<label for="role-vertical">Role</label>
															<select class="form-select" name="user_role" required>
																<option value="">-- Pilih Role --</option>
																<option value="admin" <?php echo $user_role == "admin" ? "selected":"" ?>>Admin</option>
																<option value="user" <?php echo $user_role == "user" ? "selected":"" ?>>User</option>
															</select>
														</div>
													</div>

													<div class="col-12 d-flex justify-content">
														<button type="submit" name="user_Update" class="btn btn-primary me-1 mb-1">Update Detail</button>
														<button type="reset"
													class="btn btn-light-secondary me-1 mb-1">Reset Form</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>

	<!-- js -->
	<?php include("../../../layout/javascript.php") ?>
</body>
</html>