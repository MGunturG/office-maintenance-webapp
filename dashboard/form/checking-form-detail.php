<?php
session_start();

require '../../config.php';
include '../../function/db-query.php';
include_once '../../function/class/Areas.php';
include_once '../../function/class/Items.php';
include_once '../../function/class/Forms.php';
include_once '../../function/class/Logs.php';

if (!$_SESSION['user_login_status']) {
	header("location:".BASE_URL."/login.php?status=not_login");
}

if (!$_GET['id']) {
	header("location:checking-form-page.php");
}

$_Area = new Areas;
$_Item = new Items;
$_Form = new Forms;
$_Log = new Logs;

$form_master_id = $_GET['id'];
$form_data = $_Form->FormDetail($form_master_id); // get form detail
$form_status = $form_data['checkingform_master_status'];

// get data items that already checked
$data_item_form = $_Form->FormDetailGetAllItem($form_master_id);

// get data items on current area
$data_item = $_Item->ItemGetAllByAreaId($form_data['checkingform_master_area_id']);

// get data area
$area_data = $_Area->AreaDetail($form_data['checkingform_master_area_id']);


/*	filter array based on their key [code line : 48-50]

	reference : 
	[1] https://stackoverflow.com/questions/10328780/how-to-extract-specific-array-keys-and-values-to-another-array
	[2] https://www.php.net/manual/en/function.array-column.php

	[3] https://stackoverflow.com/questions/27447923/how-to-filter-a-two-dimensional-array-by-value
	[4] https://www.php.net/manual/en/function.array-filter.php
	[5] https://www.php.net/manual/en/function.in-array.php

 */

$already_checked_items = array_column($data_item_form, 'checkingform_detail_item_id');
$not_yet_checked_items = array_filter($data_item, function($item) use ($already_checked_items) {
	return !(in_array($item['item_master_id'], $already_checked_items));
});


// if form add checked item submitted
if (isset($_POST['form_add_item_Submit'])) {
	$items = $_POST['checked'];
	foreach ($items as $item_id => $checkbox_value) {
		$_Form->FormAddItem($form_master_id, $item_id, '0');
	}

	// refresh page, to refresh current data
	header("location:checking-form-detail.php?id=".$form_master_id);
}


// if form submitted, save form then change form status to 1 (submitted)
if (isset($_POST['form_Submit'])) {
	$_Form->FormSave($form_master_id);

	// create new log
	$_Log->LogCreate('Checking Form', $form_master_id, 'Submitted the form', $_SESSION['user_uname']);

	echo "<script>document.location.href = 'checking-form-page.php';</script>"; exit;
}


// if form redraft clicked, change form status to 0 (draft)
if (isset($_POST['form_redraft_Submit'])) {
	$_Form->FormRedraft($form_master_id);

	// create new log
	$_Log->LogCreate('Checking Form', $form_master_id, 'Redraft the form', $_SESSION['user_uname']);

	echo "<script>document.location.href = 'checking-form-detail.php?id=$form_master_id';</script>"; exit;
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Form Pengecekan : CHECKFORM<?= $form_master_id ?></title>

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
											<h4>Form Pengecekan : CHECKFORM<?= $form_master_id ?></h4>
										</div>

										<div class="col d-flex justify-content-end">
											<?php if ($form_status != 1): ?>
												<button type="button" class="btn btn-primary me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modal_add_form_item">Tambah Barang</button>
											<?php endif; ?>
										</div>
									</div>
								</div>

								<!-- tabel -->
								<div class="card-content">
									<div class="card-body">
										<div class="row">
											 <div class="col-sm-4">
				                                <h6>Lokasi</h6>
				                                <input readonly type="text" class="form-control" readonly="readonly" name="area_name" value="<?= $area_data['area_master_name']. ' - Lantai ' .$area_data['area_master_floor']; ?>">
				                            </div>
				                            <div class="col-sm-5">
				                                <h6>Remark</h6>
				                                <input readonly type="text" class="form-control" readonly="readonly" name="area_description" value="<?= $form_data['checkingform_master_remark']; ?>">
				                            </div>
				                            <div class="col-sm-3">
				                                <h6>Tanggal Pengecekan</h6>
				                                <input readonly type="text" class="form-control" readonly="readonly" name="area_description" value="<?= $form_data['checkingform_master_effdate']; ?>">
				                            </div>
										</div>
										<form method="POST">
											<table id="forms_table" class="table table-hover">
												<thead>
													<tr>
														<th>No</th>
														<th>Nama Barang</th>
														<th>Aksi</th>
													</tr>
												</thead>
												<tbody>
													<?php $i = 1; ?>
													<?php foreach ($data_item_form as $item_form): ?>
														<?php $item_detail = $_Item->ItemDetail($item_form['checkingform_detail_item_id']) ?>
														<tr>
															<td><?= $i ?></td>
															<td><?= $item_detail['item_master_name'] ?></td>
															<td><a href="checking-form-detail-rm.php?item_id=<?= $item_detail['item_master_id']?>&&form_id=<?= $form_master_id ?>"><?php echo ($form_status!=1) ? "Hapus" : "" ?></a></td>
														</tr>
													<?php $i++; endforeach ?>
												</tbody>
											</table>
											<?php if ($form_status != 1): ?>
												<input type="submit" name="form_Submit" value="Simpan Form" class="btn btn-primary">
												<?php else: ?>
												<input type="submit" name="form_redraft_Submit" value="Redraft Form" class="btn btn-warning">
											<?php endif ?>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>


            <!-- modal form pengecekan -->
            <form method="POST">
				<div class="modal fade text-left" id="modal_add_form_item" tabindex="-1" role="dialog">
	                <div class="modal-dialog" role="document">
	                    <div class="modal-content">
	                        <div class="modal-header">
	                            <h5 class="modal-title">Tambah Barang</h5>
	                            <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
	                                aria-label="Close">
	                                <i data-feather="x"></i>
	                            </button>
	                        </div>
	                        <form method="POST">
		                        <div class="modal-body">
		                        	<div class="form-body">
		                        		<div class="row">
		                        			<div class="col">
												<table id="forms_item" class="table table-hover">
													<!-- table head -->
													<thead>
														<tr>
															<th>Nama Barang</th>
															<!-- <th>Lantai</th> -->
															<!-- <th>Area</th> -->
															<th>Sudah dicek?</th>
														</tr>
													</thead>

													<tbody>
														<?php foreach ($not_yet_checked_items as $item): ?>
															<!-- <?php $location = $_Area->AreaDetail($item['item_master_area_id']); ?> -->
															<?php if(true): ?>
															<tr>
																<td><?= $item['item_master_name']; ?></td>
																<!-- <td><?= $location['area_master_floor']; ?></td> -->
																<!-- <td><?= $location['area_master_name']; ?></td> -->
																<td><input type="checkbox" class="form-check-input form-check-success" name="checked[<?= $item['item_master_id']; ?>]"></td>
															</tr>
															<?php endif ?>
														<?php endforeach ?>
													</tbody>
												</table>
											</div>
										</div>
		                        	</div>
		                        </div>
		                        <div class="modal-footer">
		                        	<button type="submit" name="form_add_item_Submit" class="btn btn-primary me-1 mb-1">Tambah</button>
		                            <button type="button" class="btn me-1 mb-1" data-bs-dismiss="modal">
		                                Tutup
		                            </button>
		                        </div>
	                       </form>
	                    </div>
	                </div>
	            </div>
	        </form>

            <!-- footer -->
            <?php include("../../layout/footer.php"); ?>
        </div>
    </div>

	<script>
		let dataTable_1 = new DataTable("#forms_table", {
			columnDefs: [{ width: '5%', targets: 0 }],
			responsive: {
				details: {
					display: DataTable.Responsive.display.childRowImmediate
				}
			},
			language: {
				lengthMenu: " _MENU_ per halaman",
				search: "Cari: ",
			},
			searching: false,
			paging: false,
		});

		let dataTable_2 = new DataTable("#forms_item", {
			responsive: true,
			language: {
				lengthMenu: " _MENU_ per halaman",
				search: "Cari: ",
			},
			paging: false,
		});
	</script>

	<!-- js -->
	<?php include("../../layout/javascript.php") ?>
</body>
</html>