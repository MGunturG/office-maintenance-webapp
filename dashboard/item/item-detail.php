<?php
session_start();

require '../../config.php';
include '../../function/db-query.php';
include_once '../../function/class/Items.php';
include_once '../../function/class/Areas.php';

if (!$_SESSION['user_login_status']) {
	header("location:".BASE_URL."/login.php?status=not_login");
}

$_Item = new Items;
$_Area = new Areas;

$data_area = $_Area->AreaGetAll();
$data_item_category = $_Item->ItemGetAllCategory();
$data_item_status = $_Item->ItemGetAllStatus();

$item_id = $_GET['id'];
$data_item = $_Item->ItemGetById($item_id);

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
										<input type="text" class="form-control" value="<?= $data_item['item_master_name'] ?>">
									</div>
									<div class="form-group">
										<label>Lokasi Barang</label>
										<input type="text" class="form-control" value="<?= $location ?>">
									</div>
									<div class="form-group">
										<label>Kategori</label>
										<input type="text" class="form-control" value="<?= $data_item['item_master_category'] ?>">
									</div>
									<div class="form-group">
										<label>Status</label>
										<input type="text" class="form-control" value="<?= $item_status['code_master_label'] ?>">
									</div>
									<?php if ($data_item['item_master_status']!="3"): ?>
									<button type="button" class="btn btn-primary me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modal_update_item">Perbarui Data</button>
									<?php endif ?>
									<button type="button" class="btn btn-primary me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modal_change_pict_item">Ganti Gambar</button>
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
        <div class="modal-dialog modal-dialog-scrollable" role="document">
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