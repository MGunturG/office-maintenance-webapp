<?php
session_start();

require '../../../config.php';
include '../../../function/db-query.php';
include_once '../../../function/class/Users.php';

if (!$_SESSION['user_login_status']) {
	header("location:".BASE_URL."/login.php?status=not_login");
}

$_User = new Users;

$data_user = $_User->UserGetAll(); // get all user on db

// if create new user form submitted
if (isset($_POST['create_new_user_Submit'])) {
	// insert new data to db
	$_User->UserCreate($_POST['username'], $_POST['password'], $_POST['role']);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Page - Buat User Baru</title>

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

			<!-- main content -->
			<div id="main-content">
				<section id="basic-vertical-layouts">
					<div class="row match-height">
						<!-- create new user card -->
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h4>Buat User Baru</h4>
								</div>
								<div class="card-content">
									<div class="card-body">
										<form method="POST">
											<div class="form-body">
												<div class="row">
													<div class="col-12">
														<div class="form-group">
															<label for="username-vertical">Username</label>
															<input type="text" class="form-control"
															name="username" placeholder="" required>
														</div>
													</div>

													<div class="col-12">
														<div class="form-group">
															<label for="password-vertical">Password</label>
															<input type="password" class="form-control"
															name="password" placeholder="" required>
														</div>
													</div>

													<div class="col-12">
														<div class="form-group">
															<label for="role-vertical">Role</label>
															<select class="form-select" name="role" required>
																<option value="">-- Pilih Role --</option>
																<option value="admin">Admin</option>
																<option value="user">User</option>
															</select>
														</div>
													</div>

													<div class="col-12 d-flex justify-content">
														<button type="submit" name="create_new_user_Submit" class="btn btn-primary me-1 mb-1">Buat</button>
														<button type="reset"
													class="btn btn-light-secondary me-1 mb-1">Reset Form</button>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>

						<!-- all user table card -->
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h4>Data User</h4>
								</div>
								<div class="card-content">
									<div class="card-body">
										<table id="users_table" class="table table-hover">
											<thead>
												<tr>
													<th>User ID</th>
													<th>Username</th>
													<th>Role</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($data_user as $user): ?>
												<tr>
													<td><a href="user-detail.php?id=<?= $user['user_master_id'] ?>">USERID<?= $user['user_master_id'] ?></a></td>
													<td><?= $user['user_master_uname'] ?></td>
													<td><?= $user['user_master_role'] ?></td>
												</tr>
												<?php endforeach ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>

			<!-- footer -->
			<?php include("../../../layout/footer.php") ?>
		</div>
	</div>

	<script>
		let dataTable = new simpleDatatables.DataTable(
			  document.getElementById("users_table")
			);
	</script>
	<!-- js -->
	<?php include("../../../layout/javascript.php") ?>
</body>
</html>