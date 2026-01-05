<?php
/**
 * Item Inventory Management
 * * Provides an interface to view all master items and a modal to register 
 * new assets into the system with automated logging.
 *
 * @uses Items, Areas, Logs
 * @param string $_POST['create_item_Submit'] Trigger for new item registration.
 * @param string $_POST['item_name'] The name of the new asset.
 * @param int    $_POST['item_area_id'] Target location ID from area_master.
 * @param string $_POST['item_category'] Category code for the item.
 * @param int    $_POST['item_status'] Initial status (1:Active, 0:Inactive, etc).
 * @return void Redirects to item-page.php on successful creation.
 */

session_start();

require '../../config.php';
include '../../function/db-query.php';
include_once '../../function/class/Items.php';
include_once '../../function/class/Areas.php';
include_once '../../function/class/Logs.php';

if (!$_SESSION['user_login_status']) {
	header("location:".BASE_URL."/login.php?status=not_login");
}

$_Item = new Items;
$_Area = new Areas;
$_Log = new Logs;

// get all item data
$data_item = $_Item->ItemGetAll();

// get all area data
$data_area = $_Area->AreaGetAll();

// get all item category
$data_item_category = $_Item->ItemGetAllCategory();

// insert new item to db table
if (isset($_POST['create_item_Submit'])) {
	$submit_data = $_Item->ItemCreate(
		$_POST['item_area_id'],
		$_POST['item_name'],
		$_POST['item_category'],
		$_POST['item_status'],
	);

	if ($submit_data) {
		// get last insert table id
		$insert_id = mysqli_insert_id($db_connection);
		
		// create new log
		$_Log->LogCreate('Item', $insert_id, 'Add new item: '.$_POST['item_name'], $_SESSION['user_uname']);
		
		echo "<script>document.location.href = 'item-page.php';</script>"; exit;
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
	<title>Pusat Data - Barang</title>

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
											<h4>Data Barang</h4>
										</div>

										<div class="col d-flex justify-content-end">
											<button type="button" class="btn btn-primary me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modal_add_item"><i class="bi bi-plus-lg"></i> Tambah Barang</button>
										</div>
									</div>
								</div>

								<!-- tabel -->
								<div class="card-content">
									<div class="card-body">
										<table id="items_table" class="table table-striped">
											<thead>
												<tr>
													<th>Nama Barang</th>
													<th>Lokasi</th>
													<th>Kategori</th>
													<th>Status</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php $i = 1; ?>
												<?php foreach ($data_item as $item): ?>
													<?php
													$location = $_Area->AreaDetail($item['item_master_area_id']);
													$location = $location['area_master_name'] . " - " . "Lantai " . $location['area_master_floor'];
													?>
													<tr>
														<td><a href="<?php echo htmlspecialchars("item-detail.php?id=".$item['item_master_id']) ?>"><?= $item['item_master_name'] ?></a></td>
														<td><?php echo htmlspecialchars($location); ?></td>
														<td><?php echo htmlspecialchars($_Item->ItemGetCategoryLabel($item['item_master_category'])); ?></td>
														<?php if ($item['item_master_status'] == "1"): ?>
															<td><span class="badge bg-success">Active</span></td>
														<?php elseif ($item['item_master_status'] == "0"): ?>
															<td><span class="badge bg-danger">Inactive</span></td>
														<?php elseif ($item['item_master_status'] == "2"): ?>
															<td><span class="badge bg-secondary">Disposed</span></td>
														<?php elseif ($item['item_master_status'] == "3"): ?>
															<td><span class="badge bg-warning">Maintenance</span></td>
														<?php endif ?>
														<td><a href="item-detail.php?id=<?= $item['item_master_id'] ?>" class="btn btn-sm icon btn-primary"><i class="bi bi-eye-fill"></i> Lihat Detail</a></td>
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

			<!-- modal add new item -->
			<form method="POST">
				<div class="modal fade text-left" id="modal_add_item" tabindex="-1" role="dialog">
	                <div class="modal-dialog" role="document">
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
	                        		<div class="row ">
	                        			<div class="col">
											<div class="form-group">
												<label>Nama Barang</label>
												<input type="text" class="form-control"
												name="item_name" placeholder="" required>
											</div>

											<div class="form-group">
												<label>Lokasi</label>
												<select name="item_area_id" class="choices form-select" required>
													<option value="">-- Pilih Lokasi --</option>
													<?php foreach ($data_area as $area): ?>
														<option value="<?php echo htmlspecialchars($area['area_master_id']); ?>"><?php echo htmlspecialchars($area['area_master_name'] . " - " . "Lantai " . $area['area_master_floor']); ?></option>
													<?php endforeach ?>
												</select>
											</div>

											<div class="form-group">
												<label>Kategori</label>
												<select name="item_category" class="choices form-select" required>
													<option value="">--- Pilih Kategori ---</option>
													<?php foreach ($data_item_category as $category): ?>
														<option value="<?= $category['code_master_code'] ?>"><?= $category['code_master_label'] ?></option>
													<?php endforeach ?>
												</select>
											</div>

											<div class="form-group"	>
												<label>Status</label>
												<select name="item_status" class="choices form-select" required>
													<option value="">--- Pilih Status ---</option>
													<option value="1" selected>Aktif</option>
													<option value="0">Non-aktif</option>
													<option value="2">Dispose</option>
												</select>
											</div>
										</div>
									</div>
	                        	</div>
	                        </div>
	                        <div class="modal-footer">
	                        	<button type="submit" name="create_item_Submit" class="btn btn-primary me-1 mb-1">Tambah</button>
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

	<!-- custom js -->
	<!-- <script type="text/javascript">
		let dataTable = new simpleDatatables.DataTable(
			  document.getElementById("items_table")
			);
	</script> -->

	<!-- datatables -->
	<script>
		let dataTable = new DataTable("#items_table", {
			responsive: {
				details: {
					display: DataTable.Responsive.display.childRowImmediate
				}
			},
			rowReorder: {
				selector: 'td:nth-child(4)'
			},
			language: {
				lengthMenu: " _MENU_ per halaman"
			}
		});
	</script>

	<!-- js -->
	<?php include("../../layout/javascript.php") ?>
</body>
</html>