<?php
session_start();

require '../../config.php';
include '../../function/db-query.php';
include_once '../../function/class/Items.php';
include_once '../../function/class/Areas.php';

if (!$_SESSION['user_login_status']) {
	header("location:".BASE_URL."/login.php?status=not_login");
}

$_Area = new Areas;
$data_area = $_Area->AreaGetAll(); // query data yang ada di tabel db area

// tambah data ke database
if (isset($_POST['create_area_Submit'])) {
	$submit_data = $_Area->AreaCreate(
		$_POST['area_name'],
		$_POST['area_description'],
		$_POST['area_floor']
	);

	$insert_id = mysqli_insert_id($db_connection); // get last insert table id

	// header("location".BASE_URL."/dashboard/admin/user/user-page.php"); exit;
	echo "<script>document.location.href = 'area-detail.php?id=$insert_id';</script>"; exit;
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Master Data - Area</title>

	<!-- styling -->
    <?php include("../../layout/styling.php"); ?>
</head>
<body>
	<?php include("../../layout/body-theme.php"); ?>

	<div id="app">
		<!-- sidebar -->
		<?php include("../../layout/sidebar.php"); ?>
		<div id="main" class="layout-navbar navbar-fixed">
			<!-- navbar -->
			<?php include("../../layout/navbar.php"); ?>
			<div id="main-content">
				<section id="basic-vertical-layouts">
					<div class="row match-height">
						<div class="col">
							<div class="card">
								<div class="card-header">
									<div class="row match-height">
										<div class="col d-flex justify-content">
											<h4>Data Lokasi</h4>
										</div>

										<div class="col d-flex justify-content-end">
											<button type="button" class="btn btn-primary me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modal_add_area">Tambah Lokasi</button>
										</div>
									</div>
								</div>

								<!-- tabel -->
								<div class="card-content">
									<div class="card-body">
										<table id="areas_table" class="table table-hover">
											<thead>
												<tr>
													<!-- <th>No</th> -->
													<th>Nama Area</th>
													<th>Lokasi</th>
													<th>Deskripsi</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($data_area as $area): ?>
												<tr>
													<td><a href="area-detail.php?id=<?= $area['area_master_id'] ?>"><?= $area['area_master_name']; ?></a></td>
													<td><?="Lantai ". $area['area_master_floor']; ?></td>
													<td><?= $area['area_master_description']; ?></td>
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

			<!-- modal add new area -->
			<form method="POST">
				<div class="modal fade text-left" id="modal_add_area" tabindex="-1" role="dialog">
	                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
	                    <div class="modal-content">
	                        <div class="modal-header">
	                            <h5 class="modal-title">Tambah Lokasi</h5>
	                            <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
	                                aria-label="Close">
	                                <i data-feather="x"></i>
	                            </button>
	                        </div>
	                        <div class="modal-body">
	                        	<div class="form-body">
	                        		<div class="row">
	                        			<div class="col">
											<div class="form-group">
												<label>Nama Area</label>
												<input type="text" class="form-control"
												name="area_name" placeholder="" required>
											</div>

											<div class="form-group">
												<label>Deskripsi Area</label>
												<textarea class="form-control" name="area_description"></textarea>
											</div>

											<div class="form-group">
												<label>Lantai</label>
												<input type="number" class="form-control" name="area_floor" min="0" max="99" required>
											</div>
										</div>
									</div>
	                        	</div>
	                        </div>
	                        <div class="modal-footer">
	                        	<button type="submit" name="create_area_Submit" class="btn btn-primary me-1 mb-1">Tambah</button>
	                            <button type="button" class="btn" data-bs-dismiss="modal">
	                                Tutup
	                            </button>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </form>

			<!-- footer -->
			<?php include("../../layout/footer.php") ?>
		</div>
	</div>

	<script>
		let dataTable = new simpleDatatables.DataTable(
			  document.getElementById("areas_table")
			);
	</script>

	<!-- js -->
	<?php include("../../layout/javascript.php") ?>
</body>
</html>