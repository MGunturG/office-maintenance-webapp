<?php
session_start();

require '../../config.php';
include '../../function/db-query.php';
include_once "../../function/class/Areas.php";
include_once "../../function/class/Forms.php";

if (!$_SESSION['user_login_status']) {
	header("location:".BASE_URL."/login.php?status=not_login");
}

$current_date = date('Y-m-d');

// get data from db table formchecking
$_Form = new Forms;
$data_form = $_Form->FormMasterGetAll();

// get data from db table area
$_Area = new Areas;
$data_area = $_Area->AreaGetAll();

// if form add new checking submited
// insert to database
if (isset($_POST['create_form_Submit'])) {
	$_Form->FormCreate(
		$_POST['form_effective_date'],
		$_POST['form_area_id'],
		$_POST['form_remark'],
	);

	// get latest id that just submited
	$insert_id = mysqli_insert_id($db_connection); // get last insert table id
	header("location:".BASE_URL."/dashboard/form/checking-form-detail.php?id=".$insert_id);
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Form Pengecekan</title>

	<!-- styling -->
    <?php include("../../layout/styling.php"); ?>
</head>
<body>
	<?php include("../../layout/body-theme.php"); ?>

	<div id="app">
        <!-- sidebar -->
        <?php include("../../layout/sidebar.php"); ?>

        <div id="main" class='layout-navbar navbar-fixed'>
            <!-- navbar -->
            <?php include("../../layout/navbar.php"); ?>

            <!-- main content -->
            <div id="main-content">
                <section id="basic-vertical-layouts">
					<div class="row match-height">
						<div class="col">
							<div class="card">
								<div class="card-header">
									<div class="row match-height">
										<div class="col d-flex justify-content">
											<h4>Data Form Pengecekan</h4>
										</div>

										<div class="col d-flex justify-content-end">
											<button type="button" class="btn btn-primary me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modal_add_form">Buat Form Baru</button>
										</div>
									</div>
								</div>

								<!-- tabel -->
								<div class="card-content">
									<div class="card-body">
										<table id="forms_table" class="table table-striped">
											<thead>
												<tr>
													<!-- <th>No.</th> -->
													<th>From ID</th>
													<th>Tanggal</th>
													<th>Area</th>
													<th>Remark</th>
													<th>Dibuat Oleh</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
												<!-- <?php $i=1; ?> -->
												<?php foreach ($data_form as $form): ?>
													<?php $location = $_Area->AreaDetail($form['checkingform_master_area_id']); ?>
												<tr>
													<!-- <td><?= $i ?></td> -->
													<td><a href="<?php echo htmlspecialchars("checking-form-detail.php?id=".$form['checkingform_master_id']) ?>">CHECKFORM<?= $form['checkingform_master_id'] ?></a></td>
													<td><?php echo htmlspecialchars($form['checkingform_master_effdate']) ?></td>
													<td><?php echo htmlspecialchars('Lantai '.$location['area_master_floor']. ' - ' .$location['area_master_name']) ?></td>
													<td><?php echo htmlspecialchars($form['checkingform_master_remark']) ?></td>
													<td><?php echo htmlspecialchars($form['checkingform_master_createby']) ?></td>
													<?php if ($form['checkingform_master_status'] == "1"): ?>
														<td><span class="badge bg-success">Submitted</span></td>
													<?php else: ?>
														<td><span class="badge bg-warning">Draft</span></td>
													<?php endif ?>
												</tr>
												<?php $i++; endforeach ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>


            <!-- modal form pengecekan -->
            <form method="POST">
				<div class="modal fade text-left" id="modal_add_form" tabindex="-1" role="dialog">
	                <div class="modal-dialog modal-dialog-scrollable" role="document">
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
												<label>Lokasi</label>
												<select name="form_area_id" class="choices form-select" required>
													<option value="">-- Pilih Lokasi --</option>
													<?php foreach ($data_area as $area): ?>
														<option value="<?php echo htmlspecialchars($area['area_master_id']); ?>"><?php echo htmlspecialchars($area['area_master_name'] . " - " . "Lantai " . $area['area_master_floor']); ?></option>
													<?php endforeach ?>
												</select>
											</div>

											<div class="form-group">
												<label>Tanggal Pengecekan</label>
												<input type="date" name="form_effective_date" class="form-control mb-3 flatpickr-no-config flatpickr-input" value="<?= $current_date; ?>" required>
											</div>

											<div class="form-group">
												<label>Catatan</label>
												<textarea name="form_remark" placeholder="Catatan pengecekan. e.g. Pengecekan rutin mingguan area pantry lantai 3..." class="form-control"></textarea>
											</div>
										</div>
									</div>
	                        	</div>
	                        </div>
	                        <div class="modal-footer">
	                        	<button type="submit" name="create_form_Submit" class="btn btn-primary me-1 mb-1">Tambah</button>
	                            <button type="button" class="btn me-1 mb-1" data-bs-dismiss="modal">
	                                Batal
	                            </button>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </form>

            <!-- footer -->
            <?php include("../../layout/footer.php"); ?>
        </div>
    </div>

    <!-- for simple datatables -->
	<!-- <script>
		let dataTable = new simpleDatatables.DataTable(
			  document.getElementById("forms_table"), {
			  	columns: [
			  		{select: 5, sort: "asc"},
			  		{select: 1, type: "date"},
			  		{select: 3, sortable: false}
			  	]
			  }
			);
	</script> -->

	<!-- datatables -->
	<script>
		let dataTable = new DataTable("#forms_table", {
			responsive: {
				details: {
					display: DataTable.Responsive.display.childRowImmediate
				}
			},
			rowReorder: {
				selector: 'td:nth-child(3)'
			},
			order: [
				[5, 'asc'],
				[1, 'desc'],
			],

			language: {
				lengthMenu: " _MENU_ per halaman"
			}
		});
	</script>

	<!-- js -->
	<?php include("../../layout/javascript.php") ?>
</body>
</html>