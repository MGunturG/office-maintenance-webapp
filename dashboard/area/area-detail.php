<?php
session_start();

require '../../config.php';
include '../../function/db-query.php';
include_once '../../function/class/Areas.php';
include_once '../../function/class/Items.php';

if (!$_SESSION['user_login_status']) {
	header("location:".BASE_URL."/login.php?status=not_login");
}

$_Area = new Areas;
$_Item = new Items;

// if id not provided, redirect to area-page.php
if (!isset($_GET['id'])) {
	header("location:area-page.php");
} else { // else, get all area data by id
	$area_id = $_GET['id'];
	$area_data = $_Area->AreaDetail($_GET['id']);
}

// get item data based on area id
$data_item = $_Item->ItemGetAllByAreaId($_GET['id']);

// if form create item was submitter, 
// insert new data to db table
if (isset($_POST['create_item_Submit'])) {
	$submit_data = $_Item->ItemCreate(
		$_GET['id'],
		$_POST['item_name'],
		$_POST['item_category'],
		$_POST['item_status'],
	);

	if ($submit_data) {
		echo "<script>document.location.href = 'area-detail.php?id=$area_id';</script>"; exit;
	} else {
		echo "insert nok";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Master Data - View Area</title>

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
											<h4>Detail Lokasi</h4>
										</div>

										<div class="col d-flex justify-content-end">
											<button type="button" class="btn btn-primary me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modal_add_item">Tambah Barang</button>
										</div>
									</div>
								</div>

								<div class="card-content">
									<div class="card-body">
										<div class="row">
				                            <div class="col-sm-4">
				                                <h6>Nama Lokasi</h6>
				                                <input disabled type="text" class="form-control" readonly="readonly" name="area_name" value="<?= $area_data['area_master_name']; ?>">
				                            </div>
				                            <div class="col-sm-6">
				                                <h6>Deskripsi</h6>
				                                <input disabled type="text" class="form-control" readonly="readonly" name="area_description" value="<?= $area_data['area_master_description']; ?>">
				                            </div>
				                            <div class="col-sm-2">
				                                <h6>Lantai</h6>
				                                <input disabled type="number" class="form-control" readonly="readonly" name="area_floor" min="0" max="99" value="<?= $area_data['area_master_floor']; ?>">
				                            </div>
				                            <p></p>
				                            <hr>
				                            <p></p>
				                            <!-- tabel -->
				                            <table id="items_table" class="table table-striped">
												<thead>
													<tr>
														<!-- <th>No</th> -->
														<th>Barang Di Lokasi</th>
														<th>Kategori</th>
														<th>Status</th>
														<th>Aksi</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($data_item as $item): ?>
													<tr>
														<td><?php echo htmlspecialchars($item['item_master_name']); ?></td>
														<td><?php echo htmlspecialchars($item['item_master_category']); ?></td>
														<?php if ($item['item_master_status'] == "1"): ?>
															<td><span class="badge bg-success">Active</span></td>
														<?php elseif ($item['item_master_status'] == "0"): ?>
															<td><span class="badge bg-danger">Inactive</span></td>
														<?php elseif ($item['item_master_status'] == "2"): ?>
															<td><span class="badge bg-warning">Disposed</span></td>
														<?php endif ?>
														<td>
															<a href="<?= BASE_URL."/dashboard/item/item-detail.php?id=".$item['item_master_id'] ?>">Lihat</a>
														</td>
													</tr>
													<?php endforeach ?>
												</tbody>
											</table>
				                        </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>

            <!-- modal add new area -->
			<form method="POST">
				<div class="modal fade text-left" id="modal_add_item" tabindex="-1" role="dialog">
	                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
	                    <div class="modal-content">
	                        <div class="modal-header">
	                            <h5 class="modal-title">Tambah Barang</h5>
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
												<label>Nama Barang</label>
												<input type="text" class="form-control"
												name="item_name" placeholder="" required>
											</div>

											<div class="form-group">
												<label>kategori</label>
												<select name="item_category" class="form-control">
													<option value="">-- pilih kategori --</option>
													<option value="listrik">kelistrikan</option>
													<option value="plumbing">plumbing</option>
												</select>
											</div>

											<div class="form-group">
												<label>Status</label>
												<select name="item_status" class="form-control">
													<option value="">-- pilih status ---</option>
													<option value="1" selected>aktif</option>
													<option value="0">non-aktif</option>
													<option value="2">dispose</option>
												</select>
											</div>
										</div>
									</div>
	                        	</div>
	                        </div>
	                        <div class="modal-footer">
	                        	<button type="submit" name="create_item_Submit" class="btn btn-primary me-1 mb-1">Tambah</button>
	                            <button type="button" class="btn" data-bs-dismiss="modal">
	                                <i class="bx bx-x d-block d-sm-none"></i>
	                                <span class="d-none d-sm-block">Tutup</span>
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

    <script>
		let dataTable = new simpleDatatables.DataTable(
			  document.getElementById("items_table")
			);
	</script>
    <!-- javascript -->
    <?php include("../../layout/javascript.php"); ?>
</body>
</html>