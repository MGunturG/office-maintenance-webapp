<?php
/**
 * Item Detail and Update Manager
 * * Displays specific item specifications and processes attribute updates.
 * Implements granular audit logging to track changes in name, location, 
 * category, and status.
 *
 * @uses Items, Areas, Logs
 * @param int    $_GET['id'] The primary key of the item to be viewed/edited.
 * @param string $_POST['update_item_Submit'] Trigger for the data update logic.
 * @param string $_POST['new_item_name'] New name value for audit comparison.
 * @param int    $_POST['new_item_area_id'] New area ID for location tracking.
 * @return void Redirects to item-detail.php after processing updates.
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

$item_id = $_GET['id'];
$data_item = $_Item->ItemGetById($item_id);
$data_area = $_Area->AreaGetAll();
$data_item_category = $_Item->ItemGetAllCategory();
$data_item_status = $_Item->ItemGetAllStatus();
$data_log = $_Log->LogFetch("Item", $item_id);

$location = $_Area->AreaDetail($data_item['item_master_area_id']);
$location = $location['area_master_name'] . " - " . "Lantai " . $location['area_master_floor'];

$item_status = get_single_data("SELECT code_master_label FROM code_master WHERE code_master_code = {$data_item['item_master_status']} AND code_master_category = 'item_status'");

// update item data
if (isset($_POST['update_item_Submit'])) {
	$_Item->ItemUpdateData(
		$item_id,
		$_POST['new_item_name'],
		$_POST['new_item_area_id'],
		$_POST['new_item_category'],
		$_POST['new_item_status'],
	);

	// add log update item name
	if ($data_item['item_master_name'] != $_POST['new_item_name']) {
		$_Log->LogCreate('Item', $item_id, 'Updated item name from '.$data_item['item_master_name'].' to '.$_POST['new_item_name'], $_SESSION['user_uname']);
	}

	// add log move item to new area/location
	if ($data_item['item_master_area_id'] != $_POST['new_item_area_id']) {
		$current_area_name = $_Area->AreaDetail($data_item['item_master_area_id']);
		$new_area_name = $_Area->AreaDetail($_POST['new_item_area_id']);
		$_Log->LogCreate('Item', $item_id, 'Moved item from '.$current_area_name['area_master_name'].' to '.$new_area_name['area_master_name'], $_SESSION['user_uname']);
	}

	// add log update item category
	if ($data_item['item_master_category'] != $_POST['new_item_category']) {
		$_Log->LogCreate('Item', $item_id, 'Updated item category to '.$_POST['new_item_category'], $_SESSION['user_uname']);
	}

	// add log update item status
	if ($data_item['item_master_status'] != $_POST['new_item_status']) {
		$new_item_status = get_single_data("SELECT code_master_label FROM code_master WHERE code_master_category = 'item_status' AND code_master_code = {$_POST['new_item_status']}");
		$_Log->LogCreate('Item', $item_id, 'Updated item status to '.$new_item_status['code_master_label'], $_SESSION['user_uname']);
	}

	echo "<script>document.location.href = 'item-detail.php?id=$item_id';</script>"; exit;
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pusat Data - Detail Barang</title>

	<!-- styling -->
	<?php include("../../layout/styling.php") ?>
</head>
<body>
	<?php include("../../layout/body-theme.php") ?>

	<div id="app">
		<!-- sidebar -->
		<?php include("../../layout/sidebar.php") ?>

		<div id="main" class="layout-navbar navbar-fixed">
			<!-- navbar -->
			<?php include("../../layout/navbar.php") ?>

			<div id="main-content">
				<section class="section">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title"><?= $data_item['item_master_name']." ".$location ?></h4>
						</div>

						<div class="card-body">
							<div class="row">
								<div class="col-md-4">
									<img src="<?= $data_item['item_master_picture_path'] ?>" class="card-img-top img-fluid" alt="<?= $data_item['item_master_name'] ?>">
								</div>

								<div class="col-md-8">
									<br>
									<div class="form-group">
										<label>Nama Barang</label>
										<input type="text" class="form-control" value="<?= $data_item['item_master_name'] ?>" readonly="readonly">
									</div>
									<div class="form-group">
										<label>Lokasi Barang</label>
										<input type="text" class="form-control" value="<?= $location ?>" readonly="readonly">
									</div>
									<div class="form-group">
										<label>Kategori</label>
										<input type="text" class="form-control" value="<?= $_Item->ItemGetCategoryLabel($data_item['item_master_category']) ?>" readonly="readonly">
									</div>
									<div class="form-group">
										<label>Status</label>
										<input type="text" class="form-control" value="<?= $item_status['code_master_label'] ?>" readonly="readonly">
									</div>
									<?php if ($data_item['item_master_status']!="3"): ?>
									<button type="button" class="btn btn-primary me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modal_update_item"><i class="bi bi-pencil-square"></i> <span class="d-none d-md-inline"> Edit Data Barang</span></button>
									<?php endif ?>
									<button type="button" class="btn btn-primary me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modal_change_pict_item"><i class="bi bi-image"></i> <span class="d-none d-md-inline"> Ganti Gambar</span></button>
									<button type="button" class="btn btn-primary me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modal_logs_item"><i class="bi bi-list-columns-reverse"></i> <span class="d-none d-md-inline"> Lihat Log</span></button>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>

	<!-- modal view update item details -->
    <div class="modal fade text-left" id="modal_update_item" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Perbarui Data Barang</h5>
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
									<div class="form-group">
										<label>Nama Barang</label>
										<input type="text" class="form-control"
										name="new_item_name" placeholder="" value ="<?= $data_item['item_master_name'] ?>" required>
									</div>

									<div class="form-group">
										<label>Lokasi</label>
										<select name="new_item_area_id" class="choices form-select" required>
											<option value="">-- Pilih Lokasi --</option>
											<?php foreach ($data_area as $area): ?>
												<option value="<?= $area['area_master_id'] ?>" <?php echo ($area['area_master_id'] == $data_item['item_master_area_id']) ? "selected":"" ?>><?= $area['area_master_name'] . " - " . "Lantai " . $area['area_master_floor'] ?></option>
											<?php endforeach ?>
										</select>
									</div>

									<div class="form-group">
										<label>Kategori</label>
										<select name="new_item_category" class="choices form-select" required>
											<option value="">--- Pilih Kategori ---</option>
											<?php foreach ($data_item_category as $category): ?>
												<option value="<?= $category['code_master_code'] ?>" <?php echo ($category['code_master_code'] == $data_item['item_master_category'] ? "selected":"") ?> ><?= $category['code_master_label'] ?></option>
											<?php endforeach ?>
										</select>
									</div>

									<div class="form-group"	>
										<label>Status</label>
										<select name="new_item_status" class="form-select" required>
											<option value="">--- Pilih Status ---</option>
											<?php foreach ($data_item_status as $status): ?>
												<?php if ($status['code_master_code'] != "3"): ?>
												<option value="<?= $status['code_master_code'] ?>" <?php echo ($status['code_master_code'] == $data_item['item_master_status']) ? "selected":"" ?>><?= $status['code_master_label'] ?></option>
												<?php endif ?>
											<?php endforeach ?>
										</select>
									</div>
								</div>
							</div>
                    	</div>
                    </div>
                    <div class="modal-footer">
                    	<button type="submit" name="update_item_Submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                        <button type="button" class="btn me-1 mb-1" data-bs-dismiss="modal">
                            Batal
                        </button>
                    </div>
               </form>
            </div>
        </div>
    </div>

	<!-- modal view update item picture -->
	<div class="modal fade text-left" id="modal_change_pict_item" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ganti Gambar Barang</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>

                <form method="POST" action="<?= BASE_URL ?>/function/upload-function.php" enctype="multipart/form-data">
                	<input type="hidden" name="id" value="<?= $item_id ?>">
					<input type="hidden" name="action" value="insert_item_picture">
					
                    <div class="modal-body">
                    	<div class="form-body">
                    		<div class="row">
                    			<div class="col">
									<div class="form-group">
										<label>Pilih File</label>
										<input type="file" id="fileToUpload" class="form-control" name="fileToUpload" 
										onchange="showPreview(event);" required >
									</div>

									<div class="form-group">
										<img id="file-ip-1-preview" class="card-img-top img-fluid">
									</div>
								</div>
							</div>
                    	</div>
                    </div>
                    <div class="modal-footer">
                    	<button type="submit" name="upload_Submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                        <button type="button" class="btn me-1 mb-1" data-bs-dismiss="modal">
                            Batal
                        </button>
                    </div>
               </form>
               
            </div>
        </div>
    </div>

    <!-- modal view item's log -->
	<div class="modal fade text-left" id="modal_logs_item" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Log Aktivitas Barang</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>

                <?php
                	
                ?>
                <table id="logs_table" class="table table-striped">
                	<thead>
                		<tr>
                			<th>Activity</th>
                			<th>By User</th>
                			<th>Date</th>
                		</tr>
                	</thead>
                		<?php foreach ($data_log as $log): ?>
                		<tr>
                			<td><?= $log['activity_log_action'] ?></td>
                			<td><?= $log['activity_log_user'] ?></td>
                			<td><?= $log['activity_log_timestamp'] ?></td>
                		</tr>
                		<?php endforeach ?>
                	<tbody>
                	</tbody>
                </table>
               <div class="modal-footer">
	                <button type="button" class="btn me-1 mb-1" data-bs-dismiss="modal">
	                    Tutup
	                </button>
                </div>
            </div>
        </div>
    </div>

    <script>
		let dataTable = new DataTable("#logs_table", {
			responsive: {
				details: {
					display: DataTable.Responsive.display.childRowImmediate
				}
			},
			searching: false,
			ordering: false,
			language: {
				lengthMenu: " _MENU_ log per halaman"
			}
		});
	</script>

    <script>
	function showPreview(event){
	  if(event.target.files.length > 0){
	    var src = URL.createObjectURL(event.target.files[0]);
	    var preview = document.getElementById("file-ip-1-preview");
	    preview.src = src;
	    preview.style.display = "block";
	  }
	}
    </script>

	<!-- js -->
	<?php include("../../layout/javascript.php") ?>
</body>
</html>